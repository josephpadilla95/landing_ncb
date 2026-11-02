<section class="banner-video position-relative overflow-hidden">
    <video
        class="position-absolute top-50 start-50 translate-middle w-100 h-100"
        style="object-fit: cover; z-index: -1;"
        autoplay
        muted
        loop
        playsinline
        preload="auto">
        <?php $video_url = get_field('banner_video'); ?>
        <source src="<?php echo esc_url( $video_url['url'] ); ?>" type="video/mp4">
        Tu navegador no soporta video HTML5.
    </video>
    <img class="flecha-down position-absolute bottom-0 start-50" src="<?php echo site_url(); ?>/wp-content/uploads/2026/09/icon-flecha-abajo.svg" alt="">
</section>