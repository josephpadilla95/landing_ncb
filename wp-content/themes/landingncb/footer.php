<?php
// hace el llamado a la función ncb_get_info_general_id() que esta en functions.php
$info_id = ncb_get_info_general_id();

$num_whatsapp = get_field('num_whatsapp', $info_id);
$mensaje_whatsapp = get_field('mensaje_whatsapp', $info_id);
$correo_ncb = get_field('correo_ncb', $info_id);
$direccion_ncb = get_field('direccion_ncb', $info_id);

?>
<footer class="site-footer">

    <div class="container">
        <!-- Top: logo + contacto -->
        <div class="footer-top">
            <a href="#" class="footer-brand">
                <?php
                $imagen_logo_ncb_footer = get_field('logo_footer_blanco', $info_id);

                echo wp_get_attachment_image(
                    $imagen_logo_ncb_footer['ID'],
                    'logo-ncb-white-footer',
                    false,
                    [
                        'class' => '',
                        'loading' => 'lazy', // la imagen se daescarga inmediatamente
                        'fetchpriority' => 'high', // prioridad de descarga
                        'alt' => esc_attr('Logo NCB inmobiliaria'),
                        'style' => ''
                    ]
                )
                ?>
            </a>

            <div class="footer-contact">
                <a href="https://api.whatsapp.com/send?phone=51<?php echo $num_whatsapp; ?>&amp;text=<?php echo $mensaje_whatsapp; ?>" target="_b" rel="">
                    <i class="ri-whatsapp-line"></i> (+51) <?php echo $num_whatsapp; ?>
                </a>
                <a href="mailto:<?php echo $correo_ncb; ?>"><?php echo $correo_ncb; ?></a>
                <a href="<?php echo $direccion_ncb; ?>" target="_b">Dirección Aquí</a>
            </div>
        </div>

        <div class="footer-divider"></div>

        <!-- Columnas de links -->
        <div class="footer-links">
            <div class="footer-links-col">
                <a href="#">Proyectos en Venta</a>
                <a href="#">Proyectos Entregados</a>
            </div>
            <div class="footer-links-col">
                <a href="#">Nosotros</a>
                <a href="#">Compra y Venta</a>
            </div>
            <div class="footer-links-col">
                <a href="#">Blog</a>
                <a href="#">Trabaja con nosotros</a>
            </div>
        </div>

        <!-- Redes sociales -->
        <div class="footer-social">

            <?php if (have_rows('redes_sociales', $info_id)) : ?>
                <?php while (have_rows('redes_sociales', $info_id)) : the_row();
                    $red_social = get_sub_field_object('red_social', $info_id);
                    $value = $red_social['value'];
                    $name_red_social = $red_social['choices'][$value];

                    $url_red_social = get_sub_field( 'url_red_social', $info_id );
                ?>

                    <a href="<?php echo esc_url( $url_red_social ); ?>" aria-label="<?php echo $name_red_social; ?>" target="_b">
                        <i class="ri-<?php echo $value; ?>-line"></i>
                    </a>

                <?php endwhile; ?>
            <?php endif; ?>
        </div>

        <div class="footer-divider"></div>

        <!-- Links legales -->
        <div class="footer-bottom">
            <a href="<?php echo site_url(); ?>/politica-privacidad/">Políticas de Privacidad</a>
            <a href="<?php echo site_url(); ?>/terminos-y-condiciones/">Terminos y Condiciones</a>
            <a href="#">Libro de Reclamaciones</a>
        </div>
    </div>


</footer>
<?php wp_footer(); ?>
</body>

</html>