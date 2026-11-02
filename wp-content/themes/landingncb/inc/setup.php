<?php 

if( ! defined( 'ABSPATH' ) ) { exit; }

function setup_tema(){
    add_theme_support( 'title-tag' );  // genera automaticamente la etiqueta <title>
}

add_action( 'after_setup_theme', 'setup_tema' );

/**
 * Tamaño de imagenes propios
 */
function landing_image_sizes(){
    add_image_size( 'logo-ncb', 400, 150, false ); // sin recorte, mantiene proporción
    add_image_size( 'logo-banco', 86, 30, false ); 
    add_image_size( 'imagen-proyecto', 730, 480, true ); // con recorte
    add_image_size( 'imagen-sobre-proyecto', 1440, 520, true ); // con recorte
    add_image_size( 'logo-ncb-white-footer', 147, 37, false ); // sin recorte
    add_image_size( 'img-flats-duplex', 492, 316, false ); // sin recorte
    add_image_size( 'img-formulario', 492, 316, false ); // sin recorte
}

add_action( 'after_setup_theme', 'landing_image_sizes' );