<?php

/**
 * Sección de ubicación: un solo mapa + enlaces fijos (Google Maps / Waze).
 * No usa Swiper ni JS.
 *
 * @param mixed  $post_id    Post de donde salen los campos ACF.
 * @param string $title      Título visible.
 * @param string $section_id Ancla de la sección (para el menú).
 * @param array  $fields     Nombres de los campos ACF (opcional).
 */
function render_location_section($post_id = null, string $title = '', string $section_id = 'ubicacion', array $fields = [])
{

    $fields = wp_parse_args($fields, [
        'map'    => 'mapa_entorno_proyecto',
        'google' => 'url_google_maps',
        'waze'   => 'url_wase',
    ]);

    // Mapa: acepta la URL del src o el código <iframe> completo
    $map = (string) get_field($fields['map'], $post_id);
    if (preg_match('/src=["\']([^"\']+)["\']/i', $map, $m)) {
        $map = html_entity_decode($m[1]);
    }

    // Solo se permiten mapas embebidos de Google
    $parts = wp_parse_url($map);
    $valid = ! empty($parts['host'])
        && preg_match('/(^|\.)google\.com$/', $parts['host'])
        && strpos($parts['path'] ?? '', '/maps/embed') === 0;

    if (! $valid) {
        return;
    }

    // Opciones fijas
    $options = [];
    $defs = [
        'google' => ['label' => 'Ir con Google Maps', 'icon' => 'icon-google-maps.svg'],
        'waze'   => ['label' => 'Ir con Waze',        'icon' => 'icon-waze.svg'],
    ];
    foreach ($defs as $key => $def) {
        $url = esc_url((string) get_field($fields[$key], $post_id));
        if ($url) {
            $options[] = $def + ['url' => $url];
        }
    }
?>
    <section class="tabs-swiper-section mapa-ubicacion" id="<?php echo esc_attr($section_id); ?>">

        <?php if ($title) : ?>
            <h2 class="sobre-proyecto__title text-center"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if ($options) : ?>
            <ul class="tabs-nav">
                <?php foreach ($options as $opt) : ?>
                    <li>
                        <a class="tab-btn" href="<?php echo $opt['url']; ?>" target="_blank" rel="noopener noreferrer">
                            <img src="<?php echo esc_url(site_url('wp-content/uploads/2026/11/' . $opt['icon'])); ?>"
                                alt="" width="18" height="18" loading="lazy">
                            <?php echo esc_html($opt['label']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div class="map-wrap mapa-ubicacion__map">
            <iframe src="<?php echo esc_url($map); ?>"
                title="<?php echo esc_attr($title ?: 'Mapa de ubicación'); ?>"
                allowfullscreen
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>
<?php }
