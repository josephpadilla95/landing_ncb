<?php

/**
 * Formulario de contacto: validación y envío por correo.
 * Acción AJAX: ncb_contact
 */
defined('ABSPATH') || exit;

add_action('wp_ajax_nopriv_ncb_contact', 'ncb_contact_handle');
add_action('wp_ajax_ncb_contact',        'ncb_contact_handle');

/** Destinatarios corporativos. */
function ncb_contact_recipients(): array
{
    return [
        'jpadilla@aeonlinesolutions.com',        // ← cambia por los correos reales
        //'marketing@tudominio.com',
    ];
}

function ncb_contact_respond(bool $ok, string $message, int $status = 200, array $errors = []): void
{
    wp_send_json(['ok' => $ok, 'message' => $message, 'errors' => $errors], $status);
}

/** Máximo 3 envíos válidos cada 10 minutos por IP. */
function ncb_contact_rate_key(): string
{
    return 'ncb_contact_' . md5($_SERVER['REMOTE_ADDR'] ?? 'unknown');
}

/** Misma lógica que los pattern del HTML. Devuelve [datos limpios, errores]. */
function ncb_contact_validate(array $in): array
{
    $data   = [];
    $errors = [];

    // Nombre
    $data['nombre'] = sanitize_text_field($in['nombre_apellido'] ?? '');
    $len = mb_strlen($data['nombre']);
    if ($len < 3 || $len > 100 || ! preg_match("/^[\p{L}\s'.-]+$/u", $data['nombre'])) {
        $errors['nombre_apellido'] = 'Ingresa un nombre válido.';
    }

    // DNI / CE
    $data['dni'] = strtoupper(sanitize_text_field($in['dni_ce'] ?? ''));
    if (! preg_match('/^[A-Z0-9]{8,12}$/', $data['dni'])) {
        $errors['dni_ce'] = 'Ingresa un DNI o CE válido.';
    }

    // Celular (Perú: 9 dígitos, empieza en 9)
    $data['celular'] = preg_replace('/\D/', '', $in['celular'] ?? '');
    if (! preg_match('/^9\d{8}$/', $data['celular'])) {
        $errors['celular'] = 'Ingresa un celular de 9 dígitos.';
    }

    // Correo
    $data['correo'] = sanitize_email($in['correo'] ?? '');
    if (! is_email($data['correo']) || strlen($data['correo']) > 120) {
        $errors['correo'] = 'Ingresa un correo válido.';
    }

    // Consentimientos
    if (($in['acepta_datos'] ?? '') !== '1') {
        $errors['acepta_datos'] = 'Debes aceptar para continuar.';
    }
    $data['publicidad'] = ($in['acepta_publicidad'] ?? '') === '1';

    // Proyecto (solo informativo)
    /*$post_id         = absint( $in['proyecto_id'] ?? 0 );
    $data['proyecto'] = $post_id && get_post_status( $post_id )
        ? sanitize_text_field( get_the_title( $post_id ) )
        : 'Sitio web';*/

    return [$data, $errors];
}

function ncb_contact_handle(): void
{

    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        ncb_contact_respond(false, 'Método no permitido.', 405);
    }

    if (! check_ajax_referer('contacto_ncb', 'contacto_nonce', false)) {
        ncb_contact_respond(false, 'La sesión expiró. Recarga la página e inténtalo de nuevo.', 403);
    }

    // Honeypot: respuesta "exitosa" falsa para no delatar el filtro
    if (! empty($_POST['website'])) {
        ncb_contact_respond(true, '¡Gracias! Pronto nos pondremos en contacto.');
    }

    $rate_key = ncb_contact_rate_key();
    $attempts = (int) get_transient($rate_key);
    if ($attempts >= 3) {
        ncb_contact_respond(false, 'Demasiados envíos. Inténtalo de nuevo en unos minutos.', 429);
    }

    [$data, $errors] = ncb_contact_validate(wp_unslash($_POST));
    if ($errors) {
        ncb_contact_respond(false, 'Revisa los campos marcados.', 422, $errors);
    }

    // Correo en texto plano
    $body = implode("\n", [
        'Nuevo contacto desde la web',
        '',
        //'Proyecto: ' . $data['proyecto'],
        'Nombre: '   . $data['nombre'],
        'DNI/CE: '   . $data['dni'],
        'Celular: '  . $data['celular'],
        'Correo: '   . $data['correo'],
        '',
        'Autoriza uso de datos: Sí',
        'Autoriza publicidad: ' . ($data['publicidad'] ? 'Sí' : 'No'),
        'Fecha: ' . wp_date('d/m/Y H:i'),
    ]);

    $host    = preg_replace('/^www\./', '', (string) wp_parse_url(home_url(), PHP_URL_HOST));
    $from = "no-reply@{$host}";
    if (! is_email($from)) {
        $from = get_option('admin_email');   // respaldo
    }
    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        "From: NCB Inmobiliaria <{$from}>",
        "Reply-To: {$data['nombre']} <{$data['correo']}>",
    ];
    $subject = 'Nuevo contacto web – NCB Inmobiliaria';

    if (! wp_mail(ncb_contact_recipients(), $subject, $body, $headers)) {
        error_log('[NCB contacto] wp_mail falló para ' . $data['correo']);
        ncb_contact_respond(false, 'No pudimos enviar tu mensaje. Inténtalo nuevamente.', 500);
    }

    set_transient($rate_key, $attempts + 1, 10 * MINUTE_IN_SECONDS);
    ncb_contact_respond(true, '¡Gracias! Pronto nos pondremos en contacto.');
}
