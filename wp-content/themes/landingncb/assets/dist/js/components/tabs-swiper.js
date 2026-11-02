// components/tabs-swiper.js

function initTabsSwiper(sectionSelector) {
  const seccion = document.querySelector(sectionSelector);
  if (!seccion) return;

  const tabsNav = seccion.querySelector(".tabs-nav");
  const tabPanel = seccion.querySelector(".tab-panel");
  let currentSwiper = null;

  if (!tabsNav || !tabPanel) {
    console.error(
      `No se encontraron .tabs-nav o .tab-panel dentro de gbgb ${sectionSelector}`,
    );
    return;
  }

  let items = [];
  try {
    items = JSON.parse(seccion.dataset.ambientes || "[]");
  } catch (e) {
    console.error("Error al parsear datos:", e);
    return;
  }

  /**
   * CONTRUSCCIÓN DEL TABS
   */
  function renderTabs(activeId) {
    tabsNav.innerHTML = "";
    items.forEach((item) => {
      const li = document.createElement("li");
      const btn = document.createElement("button");
      btn.className = "tab-btn" + (item.id === activeId ? " active" : "");
      btn.type = "button";
      btn.textContent = item.label;
      btn.addEventListener("click", () => activateTab(item.id));
      li.appendChild(btn);
      tabsNav.appendChild(li);
    });
  }

  // Destruye cualquier swiper activo antes de cambiar de contenido/tab
  function destroySwiperIfNeeded() {
    if (currentSwiper) {
      currentSwiper.destroy(true, true);
      currentSwiper = null;
    }
  }

  /**
   * CONSTRUCCIÓN DE GALLERY
   */
  function renderGallery(item) {
    const controls = seccion.dataset.controls || "nav";
    const showNav = controls === "nav" || controls === "both";
    const showDots = controls === "dots" || controls === "both";
    tabPanel.innerHTML = `
      <div class="swiper project-swiper">
        <div class="swiper-wrapper">
          ${item.images.map((img) => `<div class="swiper-slide">${img.html}</div>`).join("")}
        </div>
        ${
          showNav
            ? `
        <div class="swiper-button-prev"><i class="ri-arrow-left-s-line"></i></div>
        <div class="swiper-button-next"><i class="ri-arrow-right-s-line"></i></div>`
            : ""
        }
      ${showDots ? `<div class="swiper-pagination"></div>` : ""}
      </div>
    `;

    const swiperEl = seccion.querySelector(".project-swiper");
    const config = {
      loop: item.images.length > 1,
    };

    if (showNav) {
      config.navigation = {
        nextEl: swiperEl.querySelector(".swiper-button-next"),
        prevEl: swiperEl.querySelector(".swiper-button-prev"),
      };
    }

    if (showDots) {
      config.pagination = {
        el: swiperEl.querySelector(".swiper-pagination"),
        clickable: true,
      };
    }

    currentSwiper = new Swiper(swiperEl, config);
  }

  /**
   * CONSTRUCCIÓN RENDERIZADO DE MAPAS
   */
  function renderMap(item) {
    tabPanel.innerHTML = `
      <div class="map-wrap">
        <iframe
          src="${item.map}"
          width="100%"
          height="480"
          style="border:0;"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
          title="${item.label}">
        </iframe>
      </div>
    `;
  }

  /**
   * CONSTRUCCIÓN DE TABS CON SLIDER ANIDADO
   */

  function renderUnits(item, unitIdx = 0) {
    destroySwiperIfNeeded();

    if (!item.units || !item.units.length) {
      tabPanel.innerHTML = "";
      return;
    }

    const unit = item.units[unitIdx];
    const imgs = unit.images;
    const multiple = imgs.length > 1;

    tabPanel.innerHTML = `
    <ul class="units-list">
      ${item.units
        .map(
          (u, i) => `
        <li>
          <button type="button" class="unit-btn${i === unitIdx ? " active" : ""}" data-index="${i}">
            <span class="unit-btn__text">
              <strong>${u.nombre}${u.etiqueta}</strong>
              <span>${u.metraje} | ${u.dormitorios} | ${u.banos}</span>
            </span>
            <i class="${i === unitIdx ? "ri-arrow-right-s-line" : "ri-arrow-down-s-line"}"></i>
          </button>
        </li>`,
        )
        .join("")}
    </ul>

    <div class="units-viewer">
      <div class="swiper units-swiper">
        <div class="swiper-wrapper">
          ${imgs
            .map(
              (img) => `
            <div class="swiper-slide">
              <div class="units-figure">${img.html}</div>
              <p class="units-caption"></p>
            </div>`,
            )
            .join("")}
        </div>
      </div>
      ${
        multiple
          ? `
        <button type="button" class="units-arrow units-arrow--prev" aria-label="Anterior"><i class="ri-arrow-left-line"></i></button>
        <button type="button" class="units-arrow units-arrow--next" aria-label="Siguiente"><i class="ri-arrow-right-line"></i></button>`
          : ""
      }
    </div>
  `;

    // Selector secundario: al hacer clic se activa ese departamento
    tabPanel.querySelectorAll(".unit-btn").forEach((btn) => {
      btn.addEventListener("click", () =>
        renderUnits(item, Number(btn.dataset.index)),
      );
    });

    // Slider: solo flechas, sin dots
    currentSwiper = new Swiper(tabPanel.querySelector(".units-swiper"), {
      slidesPerView: 1,
      spaceBetween: 0,
      loop: multiple,
      navigation: multiple
        ? {
            prevEl: tabPanel.querySelector(".units-arrow--prev"),
            nextEl: tabPanel.querySelector(".units-arrow--next"),
          }
        : false,
    });
  }

  function renderContent(item) {
    destroySwiperIfNeeded();

    if (item.type === "map") {
      renderMap(item);
    } else if (item.type === "units") {
      renderUnits(item); // índice 0 = primer departamento activo por defecto
    } else {
      renderGallery(item);
    }
  }

  function activateTab(id) {
    const item = items.find((a) => a.id === id);
    if (!item) return;
    renderTabs(id);
    renderContent(item);
  }

  if (items.length) activateTab(items[0].id);
}
