<?php

$proyecto_id = $args['proyecto_id'] ?? null;
if ( ! $proyecto_id ) return;

$free_data = [
    'precio'   => 'precio_desde',                                   // atajo: texto
    'brochure' => [ 'field' => 'brochure_proyecto',    'type' => 'url' ],
    'avance'   => [ 'field' => 'avance_de_obras', 'type' => 'url' ],
]

?>

<div class="container pb-5">
    <?php render_tabs_section('lista_flats_duplex', 'flats', 'Flats y Duplex', 'units', $proyecto_id, 'nav', $free_data); ?>
</div>