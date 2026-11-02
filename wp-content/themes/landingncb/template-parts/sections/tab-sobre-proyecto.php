<?php
// template-parts/sections/tab-sobre-proyecto.php

$proyecto_id = $args['proyecto_id'] ?? null;
if ( ! $proyecto_id ) return;

render_tabs_section('imagenes_de_area_de_proyecto', 'sobre-proyecto', 'Sobre el Proyecto', 'gallery', $proyecto_id , 'dots');