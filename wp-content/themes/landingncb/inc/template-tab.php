<?php

/**
 * Renderiza una sección de tabs. Soporta dos modos por item:
 * - 'gallery': repeater anidado de imágenes -> Swiper
 * - 'map': un iframe de Google Maps
 *
 * @param string $field_name    Nombre del repeater padre en ACF.
 * @param string $section_class Clase única para esta sección.
 * @param string $title         Título visible.
 * @param string $mode          'gallery' | 'map'
 */
function render_tabs_section(string $field_name, string $section_class, string $title = '', string $mode = 'gallery', $post_id = null, string $controls = 'nav', array $extras = [])
{
    //$precio = $free_data ? get_field( $free_data, $post_id ) : '';
    $extra = resolve_section_extras($extras, $post_id);
    $items = [];

    if (have_rows($field_name, $post_id)) :
        while (have_rows($field_name, $post_id)) : the_row();

            $nombre = get_sub_field('nombre_de_area');

            if ($mode === 'map') :

                $mapa_iframe = get_sub_field('mapa_iframe'); // URL del src del iframe

                $items[] = [
                    'id'    => sanitize_title($nombre),
                    'label' => esc_html($nombre),
                    'type'  => 'map',
                    'map'   => esc_url($mapa_iframe),
                ];
            elseif (have_rows('lista_imagenes_area')) :

                $imagenes = [];


                while (have_rows('lista_imagenes_area')) : the_row();

                    $imagen    = get_sub_field('imagen_area');
                    $imagen_id = is_array($imagen) ? $imagen['ID'] : $imagen;

                    if ($imagen_id) {
                        $img_html = wp_get_attachment_image(
                            $imagen_id,
                            'imagen-sobre-proyecto',
                            false,
                            [
                                'class'   => 'project-sobre-img',
                                'loading' => 'lazy',
                                'alt'     => esc_attr(get_post_meta($imagen_id, '_wp_attachment_image_alt', true) ?: $nombre),
                            ]
                        );
                        $imagenes[] = ['html' => $img_html];
                    }

                endwhile;
                $items[] = [
                    'id'     => sanitize_title($nombre),
                    'label'  => esc_html($nombre),
                    'type'   => 'gallery',
                    'images' => $imagenes,
                ];
            elseif ($mode === 'units') :

                $departamentos = [];

                if (have_rows('lista_departamentos')) :
                    while (have_rows('lista_departamentos')) : the_row();

                        $nombre_depto = get_sub_field('nombre_departamento');
                        $etiqueta = get_sub_field('etiqueta_destacada');
                        $grupo = get_sub_field('grupo_content');
                        $metraje_departamento = $grupo['metraje_departamento'];
                        $dormitorio_departamento = $grupo['dormitorio_departamento'];
                        $banos_departamento = $grupo['banos_departamento'];

                        $imagenes     = [];

                        if (have_rows('lista_de_imagenes')) :
                            while (have_rows('lista_de_imagenes')) : the_row();

                                $img    = get_sub_field('imagen_departamento');
                                $img_id = is_array($img) ? $img['ID'] : $img;

                                if ($img_id) {
                                    $imagenes[] = [
                                        'html'      => wp_get_attachment_image($img_id, 'img-flats-duplex', false, [
                                            'class'   => 'units-img',
                                            'loading' => 'lazy',
                                            'alt'     => esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', true) ?: $nombre_depto),
                                        ]),
                                        /*'etiqueta'  => esc_html(get_sub_field('etiqueta')),
                                        'destacada' => esc_html(get_sub_field('etiqueta_destacada')),*/
                                    ];
                                }

                            endwhile;
                        endif;

                        $departamentos[] = [
                            'nombre'      => esc_html($nombre_depto),
                            'etiqueta'    => esc_html($etiqueta),
                            'metraje'     => esc_html($metraje_departamento),
                            'dormitorios' => esc_html($dormitorio_departamento),
                            'banos'       => esc_html($banos_departamento),
                            'images'      => $imagenes,
                        ];

                    endwhile;
                endif;

                $items[] = [
                    'id'     => sanitize_title($nombre),
                    'label'  => esc_html($nombre),
                    'type'   => 'units',
                    //'precio' => esc_html($precio),
                    'units'  => $departamentos,
                ];
            endif;
        endwhile;
    endif;
?>

    <section class="tabs-swiper-section <?php echo esc_attr($section_class); ?>"
        data-controls="<?php echo esc_attr($controls); ?>"
        data-ambientes='<?php echo esc_attr(wp_json_encode($items)); ?>'>

        <?php if ($title) : ?>
            <h2 class="sobre-proyecto__title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if (! empty($extra['precio'])) : ?>
            <p class="tabs-price">Desde: <?php echo $extra['precio']; ?></p>
        <?php endif; ?>

        <ul class="tabs-nav"></ul>

        <div class="slider-wrap">
            <div class="tab-panel"></div>
        </div>

        <?php if (! empty($extra['brochure']) || ! empty($extra['avance'])) : ?>
            <div class="tabs-ctas">
                <?php if (! empty($extra['brochure'])) : ?>
                    <a class="tabs-cta" href="<?php echo $extra['brochure']; ?>" target="_blank" rel="noopener">
                        Descargar Brochure <i class="ri-arrow-down-line"></i>
                    </a>
                <?php endif; ?>
                <?php if (! empty($extra['avance'])) : ?>
                    <a class="tabs-cta" href="<?php echo $extra['avance']; ?>" target="_blank" rel="noopener">
                        Avance de Obra <i class="ri-hammer-line"></i>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </section>
<?php }
