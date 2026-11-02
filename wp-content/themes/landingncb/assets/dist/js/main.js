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
});
