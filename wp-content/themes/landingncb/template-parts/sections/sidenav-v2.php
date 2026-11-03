<!-- ===== SIDENAV OFFCANVAS ===== -->
<div class="offcanvas offcanvas-start offcanvas-custom" tabindex="-1" id="sidenav" aria-label="Menú principal" data-bs-backdrop="false">
    <div class="offcanvas-body p-0">
        <nav aria-label="Principal">
            <ul class="sidenav-list">
                <li><a href="<?php echo site_url();?>#proyecto">Proyecto</a></li>
                <li><a href="<?php echo site_url();?>#sobre-proyecto">Galería</a></li>
                <li><a href="<?php echo site_url();?>#flats">Planos</a></li>
                <li><a href="<?php echo site_url();?>#contacto">Charlemos</a></li>
                <li><a href="<?php echo site_url();?>#ubicacion">Ubicación</a></li>
            </ul>
        </nav>
    </div>
</div>

<!-- Fondo oscuro propio (no usa el backdrop de Bootstrap) -->
<div class="menu-shade" data-bs-dismiss="offcanvas" data-bs-target="#sidenav" aria-hidden="true"></div>