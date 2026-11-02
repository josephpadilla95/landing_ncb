<?php
$informacion_general_id = $args['informacion_general_id'] ?? null;

$imagen_formulario = get_field('imagen_formulario', $informacion_general_id);

// Endpoint que enviará los correos (ajusta la ruta cuando lo tengas)
//$endpoint = get_theme_file_uri('inc/send-contact.php');
?>
<section class="section-contacto" id="contacto">
  <div class="container pb-5 contacto-ncb">
    <div class="container-fluid px-0">
      <div class="row g-0 align-items-center">

        <!-- Formulario -->
        <div class="col-lg-5 contacto-ncb__col-form">
          <h2 class="contacto-ncb__title">Deseo más información</h2>

          <form id="form-contacto"
            class="contacto-ncb__form"
            method="post"
            action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>"
            novalidate>

            <input type="hidden" name="action" value="ncb_contact">

            <?php wp_nonce_field('contacto_ncb', 'contacto_nonce'); ?>
            <input type="hidden" name="informacion_general_id" value="<?php echo esc_attr($informacion_general_id); ?>">

            <!-- Honeypot anti-spam: un usuario real nunca lo ve ni lo llena -->
            <div class="d-none" aria-hidden="true">
              <label>No llenar este campo
                <input type="text" name="website" tabindex="-1" autocomplete="off">
              </label>
            </div>

            <div class="row g-4">
              <div class="col-md-6">
                <label for="nombre_apellido" class="form-label">Nombre y Apellido</label>
                <input type="text" class="form-control" id="nombre_apellido" name="nombre_apellido"
                  placeholder="Escribir" autocomplete="name" required minlength="3" maxlength="100">
                <div class="invalid-feedback">Ingresa tu nombre y apellido.</div>
              </div>

              <div class="col-md-6">
                <label for="dni_ce" class="form-label">DNI/CE</label>
                <input type="text" class="form-control" id="dni_ce" name="dni_ce"
                  placeholder="Escribir" required pattern="[A-Za-z0-9]{8,12}" maxlength="12">
                <div class="invalid-feedback">Ingresa un DNI o CE válido.</div>
              </div>

              <div class="col-md-6">
                <label for="celular" class="form-label">Celular</label>
                <input type="tel" class="form-control" id="celular" name="celular"
                  placeholder="Escribir" autocomplete="tel-national" inputmode="numeric"
                  required pattern="9[0-9]{8}" maxlength="9">
                <div class="invalid-feedback">Ingresa un celular de 9 dígitos.</div>
              </div>

              <div class="col-md-6">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" class="form-control" id="correo" name="correo"
                  placeholder="Escribir" autocomplete="email" required maxlength="120">
                <div class="invalid-feedback">Ingresa un correo válido.</div>
              </div>
            </div>

            <div class="contacto-ncb__checks">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="acepta_publicidad" name="acepta_publicidad" value="1">
                <label class="form-check-label" for="acepta_publicidad">
                  Autorizo recibir publicidad, promociones, ofertas y encuestas de NCB.
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="acepta_datos" name="acepta_datos" value="1" required>
                <label class="form-check-label" for="acepta_datos">
                  Autorizo el uso de mis datos y
                  <a href="<?php echo esc_url(get_privacy_policy_url() ?: '#'); ?>" target="_blank" rel="noopener">políticas de privacidad.</a>
                </label>
              </div>
            </div>

            <div class="text-center text-lg-start mt-4">
              <button type="submit" class="btn btn-ncb">
                Enviar <i class="ri-arrow-right-line" aria-hidden="true"></i>
              </button>
            </div>

            <div class="contacto-ncb__status mt-3" role="status" aria-live="polite"></div>
          </form>
        </div>

        <!-- Imagen -->
        <div class="col-lg-6 contacto-ncb__col-img">

          <?php
          echo wp_get_attachment_image(
            $imagen_formulario['ID'],
            'img-formulario',
            false,
            [
              'class' => 'contacto-ncb__img',
              'loading' => 'lazy', // la imagen se descarga inmediatamente
              'fetchpriority' => 'high', // prioridad de descarga
              'alt' => esc_attr('Imagen proyecto en formulario'),
              'style' => ''
            ]
          )
          ?>
        </div>

      </div>
    </div>
  </div>

</section>