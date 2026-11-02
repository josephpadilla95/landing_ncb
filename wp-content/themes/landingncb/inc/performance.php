<?php 

/**
 * Convierte automáticamente las imágenes subidas a WebP cuando el
 * servidor lo soporta (requiere GD o Imagick con soporte WebP, algo
 * común en hosting moderno; en Laragon depende de tu build de PHP).
 */
add_filter( 'image_editor_output_format', function ( $formats ) {
    $formats['image/jpeg'] = 'image/webp';
    $formats['image/png']  = 'image/webp';
    return $formats;
} );
