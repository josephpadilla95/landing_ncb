document.addEventListener("DOMContentLoaded", function () {
  const header = document.getElementById("header-ncb");

  function setHeaderHeight() {
    document.documentElement.style.setProperty(
      "--header-h",
      `${header.offsetHeight}px`,
    );
  }

  if (header) {
    setHeaderHeight();
    new ResizeObserver(setHeaderHeight).observe(header);
  }

  function toggleHeaderClass() {
    header.classList.toggle("scrolled", window.scrollY > 80);
  }

  window.addEventListener("scroll", toggleHeaderClass, { passive: true });
  toggleHeaderClass(); // por si la página carga ya scrolleada

  /**
   * TABS
   * ( La lógica esta en la siguiente ruta /assets/dist/js/components/tabs-swiper.js )
   */
  initTabsSwiper(".sobre-proyecto");
  initTabsSwiper(".entorno");
  initTabsSwiper(".flats");

  /**
   * FORMULARIO
   */

  initContactForm("#form-contacto");

  const sidenav = document.getElementById("sidenav");

  if (sidenav) {
    const offcanvas = bootstrap.Offcanvas.getOrCreateInstance(sidenav);

    sidenav.querySelectorAll('.sidenav-list a[href^="#"]').forEach((link) => {
      link.addEventListener("click", (e) => {
        e.preventDefault();

        const href = link.getAttribute("href");
        const target = document.querySelector(href);

        if (target) {
          // Cuando el menú termine de cerrarse, baja a la sección
          sidenav.addEventListener(
            "hidden.bs.offcanvas",
            () => {
              target.scrollIntoView({ behavior: "smooth" });
              history.pushState(null, "", href);
            },
            { once: true },
          );
        }

        offcanvas.hide();
      });
    });
  }
});
