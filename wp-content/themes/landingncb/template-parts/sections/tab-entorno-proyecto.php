<?php
// template-parts/sections/tab-entorno-proyecto.php

$proyecto_id = $args['proyecto_id'] ?? null;
if ( ! $proyecto_id ) return;

?>

<div class="container pb-5">
    <?php render_tabs_section('alrededores_proyecto', 'entorno', 'Entorno Privilegiado', 'map', $proyecto_id); ?>
</div>