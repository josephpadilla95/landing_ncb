<?php
$proyecto_id = $args['proyecto_id'] ?? null;
if (! $proyecto_id) return; // seguridad: si no hay proyecto, no renderiza nada
?>

<?php
$distrito = get_field_object('distrito_proyecto', $proyecto_id);
$value = $distrito['value'];
$name_distrito = $distrito['choices'][$value];

$direccion = get_field('direccion_proyecto', $proyecto_id);

$tipo_moneda = get_field('tipo_de_moneda_proyecto', $proyecto_id);

$precio = get_field('precio_proyecto', $proyecto_id);

$estado_proyecto = get_field_object('estado_proyecto', $proyecto_id);
$estado_value = $estado_proyecto['value'];
$estado_name = $estado_proyecto['choices'][$estado_value];

$entrega_proyecto = get_field_object('ano_de_entrega', $proyecto_id);
$entrega_value = $entrega_proyecto['value'];
$entrega_name = $entrega_proyecto['choices'][$entrega_value];

$dormitorios = get_field('dormitorios', $proyecto_id);
$banos = get_field('banos', $proyecto_id);

$tamanos_proyecto = get_field('tamanos_proyecto', $proyecto_id);
$metro01 = !empty($tamanos_proyecto['metros_01']) ? $tamanos_proyecto['metros_01'] . ' m²' : null;
$metro02 = !empty($tamanos_proyecto['metros_02']) ? $tamanos_proyecto['metros_02'] . ' m²' : null;
$pisos   = !empty($tamanos_proyecto['pisos'])     ? $tamanos_proyecto['pisos'] . ' Pisos'  : null;

$banco_financiado = get_field('banco_financiamiento', $proyecto_id);

$brochure = get_field('brochure_proyecto', $proyecto_id);

$mensaje_proyecto = get_field('mensaje_proyecto', $proyecto_id);

$imagen_proyecto = get_field('imagen_proyecto', $proyecto_id);

$titulo_proyecto = get_the_title($proyecto_id); // en vez de the_title()
?>

<div class="container py-4 py-md-5" id="proyecto">
    <!-- Header -->
    <div class="row align-items-center">
        <div class="col-8">
            <h1 class="project-title">Proyecto <span><?php echo esc_html($titulo_proyecto); ?></span></h1>
        </div>
        <div class="col-4 text-end">
            <a href="#" class="back-link"><i class="ri-arrow-left-long-line"></i> Proyectos Similares</a>
        </div>
    </div>

    <div class="divider"></div>

    <div class="row">
        <!-- Columna izquierda: información -->
        <div class="col-lg-4 info-col pe-lg-4">

            <?php if (!empty($direccion)) : ?>
                <div class="label-muted pb-2">Dirección:</div>
                <div class="info-value mb-3 d-flex align-items-center gap-2">
                    <img src="<?php echo site_url(); ?>/wp-content/uploads/2026/08/icon-ubicacion.svg" alt="">
                    <div><p class="mb-0"><?php echo $direccion ?></p><strong><?php echo $name_distrito ?></strong></div>
                </div>
                <div class="divider"></div>
            <?php endif; ?>

            <?php if (!empty($dormitorios)) : ?>
                <div class="label-muted pb-2">Dormitorios:</div>
                <div class="info-value mb-3 d-flex align-items-center gap-2">
                    <img src="<?php echo site_url(); ?>/wp-content/uploads/2026/08/dormitorio.svg" alt="">
                    <?php echo $dormitorios; ?> Dorms.
                </div>
                <div class="divider"></div>
            <?php endif; ?>

            <?php if (!empty($banos)) : ?>
                <div class="label-muted pb-2">Baños:</div>
                <div class="info-value mb-3 d-flex align-items-center gap-2">
                    <img src="<?php echo site_url(); ?>/wp-content/uploads/2026/10/Figure-bano.webp" alt="">
                    <?php echo $banos; ?> Baños.
                </div>
                <div class="divider"></div>
            <?php endif; ?>

            <?php
            $partes = array_filter([$metro01, $metro02, $pisos]); // Filtra el arreglo para eliminar los nulos o vacíos
            $resultado = implode(' - ', $partes); // Une los elementos existentes con un guion rodeado de espacios

            if (!empty($resultado)) :
            ?>
                <div class="label-muted pb-2">Área:</div>
                <div class="info-value mb-3 d-flex align-items-center gap-2">
                    <img src="<?php echo site_url(); ?>/wp-content/uploads/2026/08/area.svg" alt="">
                    <?php echo $resultado ?>
                </div>
                <div class="divider"></div>
            <?php endif; ?>

            <?php if (!empty($banco_financiado)) : ?>
                <div class="label-muted pb-2">Financiado por:</div>
                <div class="bank-badge mb-3">
                    <?php
                    echo wp_get_attachment_image(
                        $banco_financiado['ID'],
                        'logo-banco',
                        false,
                        [
                            'class' => '',
                            'loading' => 'lazy', // la imagen se descarga inmediatamente
                            'fetchpriority' => 'high', // prioridad de descarga
                            'alt' => esc_attr('Banco de Financiamiento'),
                            'style' => ''
                        ]
                    )
                    ?>
                </div>
                <div class="divider"></div>
            <?php endif; ?>

        </div>

        <!-- Columna derecha: cita e imagen -->
        <div class="col-lg-8 ps-lg-5 mt-4 mt-lg-0 cita">
            <?php echo wp_kses_post($mensaje_proyecto); ?>

            <?php
            echo wp_get_attachment_image(
                $imagen_proyecto['ID'],
                'imagen-proyecto',
                false,
                [
                    'class' => 'project-image mt-3',
                    'loading' => 'lazy', // la imagen se descarga inmediatamente
                    'fetchpriority' => 'high', // prioridad de descarga
                    'alt' => esc_attr('Render del proyecto'),
                    'style' => ''
                ]
            )
            ?>
        </div>
    </div>
</div>