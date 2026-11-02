<?php
get_header();
?>

<main class="main" id="">
    <?php
    get_template_part('template-parts/sections/banner');
    get_template_part( 'template-parts/sections/info-proyecto', null,  [
        'proyecto_id' => ncb_get_proyecto_id(),
    ]);
    get_template_part( 'template-parts/sections/tab-sobre-proyecto', null, [
        'proyecto_id' => ncb_get_proyecto_id(),
    ] );
    get_template_part( 'template-parts/sections/tab-flats-duplex', null, [
        'proyecto_id' => ncb_get_proyecto_id(),
    ] );
    get_template_part( 'template-parts/sections/section-contacto', null, [
        'informacion_general_id' => ncb_get_info_general_id(),
    ] );
    get_template_part( 'template-parts/sections/tab-entorno-proyecto', null, [
        'proyecto_id' => ncb_get_proyecto_id(),
    ] );
    ?>
</main>

<?php get_footer(); ?>