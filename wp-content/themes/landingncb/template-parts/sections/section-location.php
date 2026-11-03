<?php
// template-parts/sections/section-location.php

$proyecto_id = $args['proyecto_id'] ?? null;
if ( ! $proyecto_id ) return;

?>

<div class="container pb-5">
    <?php render_location_section( $proyecto_id, 'Entorno Privilegiado' ); ?>
</div>