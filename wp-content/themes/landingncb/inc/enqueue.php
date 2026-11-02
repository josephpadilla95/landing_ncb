<?php

if( ! defined( 'ABSPATH' ) ) { exit; }

function tema_enqueue_assets(){
    // CSS

    $css_bootstrap_local = '/assets/vendor/bootstrap/css/bootstrap.min.css';
    $css_bootstrap_path = get_template_directory() . $css_bootstrap_local;

    wp_enqueue_style(
        'bootstrap-css',
        get_theme_file_uri( $css_bootstrap_local ),
        [],
        file_exists( $css_bootstrap_path ) ? filemtime( $css_bootstrap_path ) : '1.0'
    );

    $css_swiper_local = '/assets/vendor/swiper/swiper-bundle.min.css';
    $css_swiper_path = get_template_directory() . $css_swiper_local;

    wp_enqueue_style(
        'swiper-css',
        get_theme_file_uri( $css_swiper_local ),
        [],
        file_exists( $css_swiper_path ) ? filemtime( $css_swiper_path ) : '1.0'
    );

    $css_remixicon_local = '/assets/remixicon/css/remixicon.css';
    $css_remixicon_path = get_template_directory() . $css_remixicon_local;

    wp_enqueue_style(
        'remixicon',
        get_theme_file_uri( $css_remixicon_local ),
        [],
        file_exists( $css_remixicon_local ) ? filemtime( $css_remixicon_path ) : '1.0',
    );

    $css_local = '/assets/dist/css/style.css';
    $css_path = get_template_directory() . $css_local;

    wp_enqueue_style(
        'landing-style',
        get_theme_file_uri( $css_local ),
        ['swiper-css', 'bootstrap-css'],
        file_exists( $css_local ) ? filemtime( $css_path ) : '1.0',
    );

    $css_font_montserrat_local = '/assets/font/Montserrat/stylesheet.css';
    $css_font_montserrat_path = get_template_directory() . $css_font_montserrat_local;

    wp_enqueue_style(
        'landing-style-font-montserrat',
        get_theme_file_uri( $css_font_montserrat_local ),
        ['landing-style'],
        file_exists( $css_font_montserrat_local ) ? filemtime( $css_font_montserrat_path ) : '1.0',
    );

    $css_font_bigcaslon_local = '/assets/font/BigCaslon/stylesheet.css';
    $css_font_bigcaslon_path = get_template_directory() . $css_font_bigcaslon_local;

    wp_enqueue_style(
        'landing-style-font-bigcaslon',
        get_theme_file_uri( $css_font_bigcaslon_local ),
        ['landing-style'],
        file_exists( $css_font_bigcaslon_local ) ? filemtime( $css_font_bigcaslon_path ) : '1.0',
    );

    // JS
    $js_bootstrap_local = '/assets/vendor/bootstrap/js/bootstrap.min.js';
    $js_bootstrap_path = get_template_directory() . $js_bootstrap_local;

    wp_enqueue_script(
        'bootstrap-js',
        get_theme_file_uri( $js_bootstrap_local ),
        [],
        file_exists( $js_bootstrap_path ) ? filemtime( $js_bootstrap_path ) : '1.0'
    );

    $js_swiper_local = '/assets/vendor/swiper/swiper-bundle.min.js';
    $js_swiper_path = get_template_directory() . $js_swiper_local;

    wp_enqueue_script(
        'swiper-js',
        get_theme_file_uri( $js_swiper_local ),
        [],
        file_exists( $js_swiper_path ) ? filemtime( $js_swiper_path ) : '1.0'
    );

    $js_tab_local = '/assets/dist/js/components/tabs-swiper.js';
    $js_tab_path = get_template_directory() . $js_tab_local;

    wp_enqueue_script(
        'tabs-swiper',
        get_theme_file_uri( $js_tab_local ),
        ['swiper-js'],
        file_exists( $js_tab_path ) ? filemtime( $js_tab_path ) : '1.0'
    );

    $js_local = '/assets/dist/js/main.js';
    $js_path = get_template_directory() . $js_local;

    wp_enqueue_script(
        'main',
        get_theme_file_uri( $js_local ),
        ['swiper-js', 'bootstrap-js', 'tabs-swiper'],
        file_exists( $js_path ) ? filemtime( $js_path ) : '1.0'
    );

    $js_contact_local = '/assets/dist/js/components/contact-form.js';
    $js_contact_path = get_template_directory() . $js_contact_local;

    wp_enqueue_script(
        'contact-form',
        get_theme_file_uri( $js_contact_local ),
        [],
        file_exists( $js_contact_path ) ? filemtime( $js_contact_path ) : '1.0'
    );
}

add_action( 'wp_enqueue_scripts', 'tema_enqueue_assets' );