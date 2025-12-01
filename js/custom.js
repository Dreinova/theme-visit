document.addEventListener("DOMContentLoaded", function () {
  // ============================================
  // MENÚ HAMBURGUESA (debe funcionar en TODAS las páginas)
  // ============================================
  const headerToggle = document.querySelector(".header__toggle");
  const headerNav = document.querySelector(".header__nav");

  if (headerToggle && headerNav) {
    // Toggle al hacer clic en el botón hamburguesa
    headerToggle.addEventListener("click", function () {
      headerToggle.classList.toggle("is-active");
      headerNav.classList.toggle("is-active");
      document.body.classList.toggle("menu-open");
    });

    // Cerrar menú al hacer clic en un enlace
    const menuLinks = document.querySelectorAll(".header__menu-link");
    menuLinks.forEach((link) => {
      link.addEventListener("click", function () {
        headerToggle.classList.remove("is-active");
        headerNav.classList.remove("is-active");
        document.body.classList.remove("menu-open");
      });
    });

    // Cerrar menú al hacer clic fuera
    document.addEventListener("click", function (e) {
      if (
        !headerToggle.contains(e.target) &&
        !headerNav.contains(e.target) &&
        headerNav.classList.contains("is-active")
      ) {
        headerToggle.classList.remove("is-active");
        headerNav.classList.remove("is-active");
        document.body.classList.remove("menu-open");
      }
    });

    // Cerrar menú al presionar ESC
    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && headerNav.classList.contains("is-active")) {
        headerToggle.classList.remove("is-active");
        headerNav.classList.remove("is-active");
        document.body.classList.remove("menu-open");
      }
    });
  }

  // ============================================
  // SPLIDE SLIDER (solo para index.html)
  // ============================================
  const splideElement = document.querySelector(".hero__imperdibles-slider");

  if (splideElement) {
    const splideImperdibles = new Splide(".hero__imperdibles-slider", {
      type: "loop",
      perPage: 4,
      perMove: 1,
      gap: "1rem",
      padding: "2rem",
      arrows: false,
      pagination: false,

      autoplay: true, // Auto reproducción
      autoScroll: { speed: 1 },
      interval: 3000,
      pauseOnHover: true,
      pauseOnFocus: true,

      drag: true, // Permite moverlo manteniendo click
      direction: "rtl", // Mover de derecha a izquierda

      breakpoints: {
        480: {
          perPage: 1,
          gap: "0.5rem",
          padding: "1rem",
        },
        768: {
          perPage: 2,
          gap: "0.75rem",
          padding: "1.5rem",
        },
        1024: {
          perPage: 3,
          gap: "1rem",
        },
      },
    });

    // Para que funcione el botón Play/Pause
    splideImperdibles.mount({ Autoplay });
  }
});
