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
    splideImperdibles.mount();
  }
});


// Obtener parámetros de URL cambio de imagenes interna
const urlParams = new URLSearchParams(window.location.search);
const imgSrc = urlParams.get("img");
const imgAlt = urlParams.get("alt");

// Actualizar imagen
if (imgSrc) {
  document.getElementById("internaImagen").src = imgSrc;
  document.getElementById("internaImagen").alt = imgAlt || "Imagen";
  document.getElementById("btnDescargar").href = imgSrc;
  document.getElementById("btnDescargar").download = imgSrc;
}

// ============================================
// MODAL DE DESCARGA (página interna.html)
// ============================================
const btnDescargar = document.getElementById("btnDescargar");
const modalDescarga = document.getElementById("modalDescarga");
const modalOverlay = modalDescarga?.querySelector(".modal__overlay");
const modalClose = modalDescarga?.querySelector(".modal__close");
const btnConfirmar = document.getElementById("btnConfirmarDescarga");

if (btnDescargar && modalDescarga) {
  // Abrir modal
  btnDescargar.addEventListener("click", function (e) {
    e.preventDefault();
    modalDescarga.classList.add("is-active");
    // document.body.style.overflow = "hidden";
  });

  // Cerrar modal al hacer clic en overlay
  modalOverlay?.addEventListener("click", function () {
    modalDescarga.classList.remove("is-active");
    // document.body.style.overflow = "";
  });

  // Cerrar modal al hacer clic en botón X
  modalClose?.addEventListener("click", function () {
    modalDescarga.classList.remove("is-active");
    // document.body.style.overflow = "";
  });

  // Cerrar modal con tecla ESC
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape" && modalDescarga.classList.contains("is-active")) {
      modalDescarga.classList.remove("is-active");
      // document.body.style.overflow = "";
    }
  });

  // Confirmar descarga
  btnConfirmar?.addEventListener("click", function () {
    // Limpiar errores previos
    clearErrors();

    // Obtener valores
    const nombre = document.getElementById("nombre");
    const apellidos = document.getElementById("apellidos");
    const cedula = document.getElementById("cedula");
    const correo = document.getElementById("correo");
    const politicas = document.getElementById("politicas");
    const condiciones = document.getElementById("condiciones");

    let isValid = true;

    // Validar nombre
    if (!nombre.value.trim()) {
      showError("nombre", "errorNombre");
      isValid = false;
    }

    // Validar apellidos
    if (!apellidos.value.trim()) {
      showError("apellidos", "errorApellidos");
      isValid = false;
    }

    // Validar cédula
    if (!cedula.value.trim()) {
      showError("cedula", "errorCedula");
      isValid = false;
    }

    // Validar correo
    if (!correo.value.trim()) {
      showError("correo", "errorCorreo");
      isValid = false;
    } else if (!isValidEmail(correo.value)) {
      showError("correo", "errorCorreo", "Correo electrónico inválido");
      isValid = false;
    }

    // Si hay errores, no continuar
    if (!isValid) {
      return;
    }

    // Deshabilitar botón y cambiar texto
    btnConfirmar.disabled = true;
    btnConfirmar.textContent = "ENVIANDO...";

    // Simular envío de datos (aquí irá tu lógica real de envío)
    setTimeout(() => {
      // Cambiar a "ENVIADO"
      btnConfirmar.textContent = "ENVIADO";
      btnConfirmar.style.background = "#4caf50";

      // Aquí puedes agregar la lógica de descarga real
      console.log("Descarga confirmada:", {
        nombre: nombre.value,
        apellidos: apellidos.value,
        cedula: cedula.value,
        correo: correo.value,
      });

      // Esperar 1 segundo antes de cerrar el modal
      setTimeout(() => {
        // Cerrar modal
        modalDescarga.classList.remove("is-active");
        // document.body.style.overflow = "";

        // Limpiar formulario
        clearForm();

        // Resetear botón a su estado original
        // btnConfirmar.textContent = "CONFIRMAR DESCARGA";
        // btnConfirmar.disabled = false;
        // btnConfirmar.style.background = "";
      }, 1000);
    }, 1000);
  });

  // Función para mostrar error
  function showError(inputId, errorId, customMessage = "Campo obligatorio") {
    const input = document.getElementById(inputId);
    const error = document.getElementById(errorId);

    if (input && error) {
      input.classList.add("has-error");
      error.textContent = customMessage;
      error.classList.add("is-visible");
    }
  }

  // Función para limpiar errores
  function clearErrors() {
    const inputs = document.querySelectorAll(".modal__input");
    const errors = document.querySelectorAll(".modal__error");

    inputs.forEach((input) => input.classList.remove("has-error"));
    errors.forEach((error) => error.classList.remove("is-visible"));
  }

  // Función para limpiar formulario
  function clearForm() {
    document.getElementById("nombre").value = "";
    document.getElementById("apellidos").value = "";
    document.getElementById("cedula").value = "";
    document.getElementById("correo").value = "";
    document.getElementById("politicas").checked = false;
    document.getElementById("condiciones").checked = false;
  }

  // Función para validar email
  function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }

  // Ocultar errores al escribir
  if (modalDescarga) {
    const inputs = ["nombre", "apellidos", "cedula", "correo"];

    inputs.forEach((inputId) => {
      const input = document.getElementById(inputId);
      if (input) {
        input.addEventListener("input", function () {
          this.classList.remove("has-error");
          const errorId =
            "error" + inputId.charAt(0).toUpperCase() + inputId.slice(1);
          const error = document.getElementById(errorId);
          if (error) {
            error.classList.remove("is-visible");
          }
        });
      }
    });
  }
}
