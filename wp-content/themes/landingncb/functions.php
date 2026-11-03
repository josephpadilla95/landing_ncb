<?php

if (! defined('ABSPATH')) {
    exit;
}

require get_template_directory() . '/inc/setup.php';
require get_template_directory() . '/inc/enqueue.php';
require get_template_directory() . '/inc/performance.php';
require_once get_template_directory() . '/inc/template-tab.php';
require_once get_template_directory() . '/inc/template-location-section.php';
require_once get_theme_file_path( 'inc/contact-form.php' );

// Evita que WordPress cambie las comillas rectas por comillas latinas/angulares
add_filter('run_wptexturize', '__return_false');

/**
 * Devuelve el ID del post 'informacion_general' del sitio.
 * Memorizado: solo hace la consulta la primera vez que se llama.
 */
function ncb_get_info_general_id()
{
    static $info_id = null;
    static $ya_consultado = false;

    if ($ya_consultado) {
        return $info_id;
    }

    $query = new WP_Query([
        'post_type'              => 'informacion_general',
        'posts_per_page'         => 1,
        'no_found_rows'          => true,
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false, // usarás ACF (get_field), no post meta directo
    ]);

    if ($query->have_posts()) {
        $query->the_post();
        $info_id = get_the_ID();
        wp_reset_postdata();
    }

    $ya_consultado = true;
    return $info_id;
}

/**
 * Devuelve el ID del proyecto activo de la landing.
 * Memoizado: solo consulta la base de datos una vez por carga de página,
 * sin importar cuántas secciones lo necesiten.
 */
function ncb_get_proyecto_id()
{
    static $proyecto_id = null;
    static $ya_consultado = false;

    if ($ya_consultado) {
        return $proyecto_id;
    }

    $query = new WP_Query([
        'post_type'              => 'proyectos',
        'posts_per_page'         => 1,
        'no_found_rows'          => true,
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false,
    ]);

    if ($query->have_posts()) {
        $query->the_post();
        $proyecto_id = get_the_ID();
        wp_reset_postdata();
    }

    $ya_consultado = true;
    return $proyecto_id;
}

/**
 * Resuelve campos sueltos de ACF.
 * @param array $map     ['clave' => 'campo_acf'] o ['clave' => ['field' => 'campo_acf', 'type' => 'text|url|html']]
 * @param mixed $post_id
 * @return array ['clave' => valor_escapado]
 */
function resolve_section_extras(array $map, $post_id = null): array
{
    $out = [];

    foreach ($map as $key => $config) {
        $field = is_array($config) ? ($config['field'] ?? '') : $config;
        $type  = is_array($config) ? ($config['type']  ?? 'text') : 'text';

        if (! $field) {
            continue;
        }

        $value = get_field($field, $post_id);

        if ($value === null || $value === false || $value === '') {
            $out[$key] = '';
            continue;
        }

        switch ($type) {
            case 'url':
                $out[$key] = esc_url(is_array($value) ? ($value['url'] ?? '') : $value);
                break;
            case 'html':
                $out[$key] = wp_kses_post($value);
                break;
            default: // text
                $out[$key] = esc_html(is_scalar($value) ? $value : '');
        }
    }

    return $out;
}
