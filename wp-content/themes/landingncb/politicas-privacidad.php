<?php

/*
template name: Política de privacidad
*/

get_header('v2');  // carga header-v2.php
?>

<div class="main pt-4 mt-4">

    <section class="container py-4 py-md-5 mt-4">
        <h2 class="title-legal fw-semibold"><?php the_title()?></h2>
        <?php the_field('informacion_legal'); ?>
    </section>

</div>

<?php get_footer(); ?>