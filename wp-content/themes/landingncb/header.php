<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo site_url(); ?>/wp-content/uploads/2026/09/favicon.webp" sizes="32x32">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); //genera clases para la etiqueta body  
        ?>>

    <?php wp_body_open(); // hook para plugins (GTM, accesibilidad)  
    ?>

    <?php
    // hace el llamado a la función ncb_get_info_general_id() que esta en functions.php
    $info_id = ncb_get_info_general_id();
    ?>
    <!-- ===== HEADER ===== -->
    <header class=" bg-transparent fixed-top" id="header-ncb">
        <div class="container main-header d-flex align-items-center justify-content-between ">
            <div class="header-left d-flex align-items-center">
                <button class="bt-menu bg-transparent border-0 m-0 p-0 fs-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidenav" aria-controls="sidenav">
                    <i class="ri-menu-line"></i>
                </button>

                <a href="<?php echo esc_url(home_url('/')); ?>" class="condicional-logic-logo-img-top">

                    <?php
                    $imagen_logo_ncb_top = get_field('logo_header', $info_id);

                    echo wp_get_attachment_image(
                        $imagen_logo_ncb_top['ID'],
                        'logo-ncb',
                        false,
                        [
                            'class' => 'img-fluid',
                            'loading' => 'eager', // la imagen se daescarga inmediatamente
                            'fetchpriority' => 'high', // prioridad de descarga
                            'alt' => esc_attr('Logo NCB inmobiliaria'),
                            'style' => 'max-height: 48px; width: auto;'
                        ]
                    )
                    ?>
                </a>

                <a href="<?php echo esc_url(home_url('/')); ?>" class="condicional-logic-logo-img-scroll">

                    <?php
                    $imagen_logo_ncb_scroll = get_field('logo_header_white', $info_id);

                    echo wp_get_attachment_image(
                        $imagen_logo_ncb_scroll['ID'],
                        'logo-ncb',
                        false,
                        [
                            'class' => 'img-fluid',
                            'loading' => 'eager', // la imagen se daescarga inmediatamente
                            'fetchpriority' => 'high', // prioridad de descarga
                            'alt' => esc_attr('Logo NCB inmobiliaria'),
                            'style' => 'max-height: 48px; width: auto;'
                        ]
                    )
                    ?>
                </a>
            </div>

            <div class="header-right d-flex align-items-center">
                <a href="#" class="nav-link-custom">Proyectos</a>
                <a href="#" class="btn-cotizar border-0 rounded-3 text-decoration-none">Cotizar ahora</a>
            </div>
        </div>
    </header>

    <?php
    // Solo dígitos, por si el número viene con espacios o guiones
    $num_whatsapp = get_field('num_whatsapp', $info_id);

    $wa_text = get_field('mensaje_whatsapp', $info_id);
    $wa_url  = 'https://api.whatsapp.com/send?phone=51' . $num_whatsapp . '&text=' . rawurlencode($wa_text);

    if ($num_whatsapp) : ?>
        <a href="<?php echo esc_url($wa_url); ?>"
            class="whatsapp-float"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="Escríbenos por WhatsApp">
            <i class="ri-whatsapp-fill" aria-hidden="true"></i>
        </a>
    <?php endif; ?>

    <?php
    // Solo dígitos, por si el número viene con espacios o guiones
    //$num_whatsapp = get_field('num_whatsapp', $info_id);

    //$wa_text = get_field('mensaje_whatsapp', $info_id);
    //$wa_url  = 'https://api.whatsapp.com/send?phone=51' . $num_whatsapp . '&text=' . rawurlencode($wa_text);

    //if ($num_whatsapp) : ?>
        <a href="#"
            class="contacto-float"
            target=""
            rel=""
            aria-label="Escríbenos por Contacto">
            <img src="<?php echo site_url(); ?>/wp-content/uploads/2026/10/icon-anotacion.svg" alt="">
        </a>
    <?php //endif; ?>

    <?php
    get_template_part('template-parts/sections/sidenav');
    ?>