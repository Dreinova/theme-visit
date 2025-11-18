<?php get_header(); ?>
<!-- Hero Section -->
    <section class="hero hero--home" style="background:url(<?=get_field("imagen_fondo")?>) top center/cover no-repeat;">
      <div class="hero__overlay"></div>
      <div class="hero__content">
        <div class="hero__left">
          <h1 class="hero__title">
            <img
              src="/wp-content/uploads/2025/11/visita-logo.png"
              alt="Visita Logo"
              class="hero__title-image"
            />
            <span class="hero__title--red">TENJO</span>
          </h1>
            <?php $description = get_the_content($post->ID); ?>
            <?= $description ?>
        </div>

        <div class="hero__right">
          <div class="hero__tags">
            <a href="#" class="hero__tag">Turismo Cultural</a>
            <a href="#" class="hero__tag">Turismo de Naturaleza y Aventura</a>
            <a href="#" class="hero__tag">Turismo de Bienestar</a>
            <a href="#" class="hero__tag">Turismo de Negocios y Eventos</a>
          </div>
        </div>
      </div>

      <!-- Los 10 Imperdibles Slider dentro del Hero -->
      <div class="hero__imperdibles">
        <h2 class="hero__imperdibles-title">
          <span class="hero__imperdibles-title--red">LOS 10 IMPERDIBLES</span>
          <br />
          <span class="hero__imperdibles-title--white">DE TENJO</span>
        </h2>

        <!-- Splide Slider -->
        <section
          class="splide hero__imperdibles-slider"
          aria-label="Los 10 Imperdibles de Tenjo"
        >
          <div class="splide__track">
            <ul class="splide__list">
              <li class="splide__slide hero__imperdibles-item">
                <a href="#" class="hero__imperdibles-link">
                  <img
                    src="/wp-content/uploads/2025/11/mesa_flores.png"
                    alt="Mesa de Flores"
                    class="hero__imperdibles-image"
                /></a>
              </li>
              <li class="splide__slide hero__imperdibles-item">
                <a href="#" class="hero__imperdibles-link">
                  <img
                    src="/wp-content/uploads/2025/11/parque.png"
                    alt="Parque"
                    class="hero__imperdibles-image"
                /></a>
              </li>
              <li class="splide__slide hero__imperdibles-item">
                <a href="#" class="hero__imperdibles-link"
                  ><img
                    src="/wp-content/uploads/2025/11/iglesia.png"
                    alt="Iglesia"
                    class="hero__imperdibles-image"
                /></a>
              </li>
              <li class="splide__slide hero__imperdibles-item">
                <a href="#" class="hero__imperdibles-link"
                  ><img
                    src="/wp-content/uploads/2025/11/pueblo_antiguo.png"
                    alt="Pueblo Antiguo"
                    class="hero__imperdibles-image"
                /></a>
              </li>
              <li class="splide__slide hero__imperdibles-item">
                <a href="#" class="hero__imperdibles-link"
                  ><img
                    src="/wp-content/uploads/2025/11/sendero.png"
                    alt="Sendero"
                    class="hero__imperdibles-image"
                /></a>
              </li>
              <li class="splide__slide hero__imperdibles-item">
                <a href="#" class="hero__imperdibles-link"
                  ><img
                    src="/wp-content/uploads/2025/11/vista_panoramica.png"
                    alt="Vista Panorámica"
                    class="hero__imperdibles-image"
                /></a>
              </li>
            </ul>
          </div>

          <!-- Botón de Play/Pause (opcional) -->
          <button
            class="splide__toggle"
            type="button"
            aria-label="Play/Pause Slider"
          >
            <svg
              class="splide__toggle__play"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
              fill="#fff"
            >
              <path d="m22 12-20 11v-22l10 5.5z" />
            </svg>
            <svg
              class="splide__toggle__pause"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
              fill="#fff"
            >
              <path d="m2 1v22h7v-22zm13 0v22h7v-22z" />
            </svg>
          </button>
        </section>
      </div>
    </section>

    <!-- Qué Hacer Section -->
    <section class="que-hacer">
      <h2 class="que-hacer__title">
        <span class="que-hacer__title--red">¿QUÉ HACER</span>
        <span class="que-hacer__title--gray"> EN TENJO?</span>
      </h2>

      <div class="que-hacer__grid">
        <a href="#" class="que-hacer__card">
          <img src="/wp-content/uploads/2025/11/turismo.png" alt="Turismo" class="que-hacer__image" />
          <div class="que-hacer__overlay">
            <h3 class="que-hacer__card-title">
              TURISMO
              <span class="que-hacer__card-line"></span>
            </h3>
          </div>
        </a>

        <a href="#" class="que-hacer__card">
          <img
            src="/wp-content/uploads/2025/11/naturaleza.png"
            alt="Naturaleza"
            class="que-hacer__image"
          />
          <div class="que-hacer__overlay">
            <h3 class="que-hacer__card-title">
              TURISMO
              <span class="que-hacer__card-line"></span>
              DE NATURALEZA Y AVENTURA
            </h3>
          </div>
        </a>

        <a href="#" class="que-hacer__card">
          <img
            src="/wp-content/uploads/2025/11/bienestar.png"
            alt="Bienestar"
            class="que-hacer__image"
          />
          <div class="que-hacer__overlay">
            <h3 class="que-hacer__card-title">
              TURISMO
              <span class="que-hacer__card-line"></span>
              DE BIENESTAR
            </h3>
          </div>
        </a>

        <a href="#" class="que-hacer__card">
          <img src="/wp-content/uploads/2025/11/negocios.png" alt="Negocios" class="que-hacer__image" />
          <div class="que-hacer__overlay">
            <h3 class="que-hacer__card-title">
              TURISMO
              <span class="que-hacer__card-line"></span>
              DE NEGOCIOS Y EVENTOS
            </h3>
          </div>
        </a>
      </div>
    </section>

    <!-- Services Section -->
    <section class="services">
      <div class="services__container">
        <!-- Card 1: Dónde Comer -->
        <a href="#" class="services__card">
          <div class="services__image-wrapper">
            <img
              src="/wp-content/uploads/2025/11/donde_comer.png"
              alt="¿Dónde Comer en Tenjo?"
              class="services__image"
            />
            <div class="services__icon-badge">
              <img
                src="/wp-content/uploads/2025/11/cuchillo_tenedor.png"
                alt="Icono Comer"
                class="services__icon"
              />
            </div>
          </div>
          <div class="services__content">
            <h3 class="services__title">
              <span class="services__title--orange">¿DÓNDE COMER</span>
              <span class="services__title--gray">EN TENJO?</span>
            </h3>
          </div>
        </a>

        <!-- Card 2: Dónde Dormir -->
        <a href="#" class="services__card">
          <div class="services__image-wrapper">
            <img
              src="/wp-content/uploads/2025/11/habitacion.png"
              alt="¿Dónde Dormir en Tenjo?"
              class="services__image"
            />
            <div class="services__icon-badge">
              <img
                src="/wp-content/uploads/2025/11/cama.png"
                alt="Icono Dormir"
                class="services__icon"
              />
            </div>
          </div>
          <div class="services__content">
            <h3 class="services__title">
              <span class="services__title--orange">¿DÓNDE DORMIR</span>
              <span class="services__title--gray">EN TENJO?</span>
            </h3>
          </div>
        </a>

        <!-- Card 3: Agenda de Eventos -->
        <a href="agenda.html" class="services__card">
          <div class="services__image-wrapper">
            <img
              src="/wp-content/uploads/2025/11/juegos_artificiales.png"
              alt="Agenda de Eventos en Tenjo"
              class="services__image"
            />
            <div class="services__icon-badge">
              <img
                src="/wp-content/uploads/2025/11/agenda.png"
                alt="Icono Calendario"
                class="services__icon"
              />
            </div>
          </div>
          <div class="services__content">
            <h3 class="services__title">
              <span class="services__title--orange">AGENDA DE EVENTOS</span>
              <span class="services__title--gray">EN TENJO</span>
            </h3>
          </div>
        </a>

        <!-- Card 4: Recorridos y Actividades -->
        <a href="#" class="services__card">
          <div class="services__image-wrapper">
            <img
              src="/wp-content/uploads/2025/11/recorridos.png"
              alt="Recorridos y Actividades Prediseñadas"
              class="services__image"
            />
            <div class="services__icon-badge">
              <img
                src="/wp-content/uploads/2025/11/recorrido.png"
                alt="Icono Mapa"
                class="services__icon"
              />
            </div>
          </div>
          <div class="services__content">
            <h3 class="services__title">
              <span class="services__title--orange">RECORRIDOS Y</span>
              <span class="services__title--gray"
                >ACTIVIDADES PREDISEÑADAS</span
              >
            </h3>
          </div>
        </a>
      </div>

      <!-- Sección banco de imagenes -->
      <div class="banco-imagenes">
        <a
          href="banco-imagenes.html"
          class="banco-imagenes__header"
          aria-label="Ir al banco de imágenes"
        >
          <span class="banco-imagenes__title" role="heading" aria-level="2">
            BANCO DE IMÁGENES
          </span>
          <div class="banco-imagenes__icon" aria-hidden="true">
            <img
              src="/wp-content/uploads/2025/11/camara_roja.png"
              alt=""
              class="banco-imagenes__icon-image"
            />
          </div>
        </a>

        <nav class="banco-imagenes__nav">
          <ul class="banco-imagenes__menu">
            <li class="banco-imagenes__item">
              <a href="faq.html" class="banco-imagenes__link">
                <img
                  src="/wp-content/uploads/2025/11/preguntas.png"
                  alt=""
                  class="banco-imagenes__link-icon"
                />
                Preguntas frecuentes
              </a>
            </li>
            <li class="banco-imagenes__item">
              <a href="#" class="banco-imagenes__link">
                <img
                  src="/wp-content/uploads/2025/11/grafico.png"
                  alt=""
                  class="banco-imagenes__link-icon"
                />
                SITUR
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </section>

<?php get_footer(); ?>