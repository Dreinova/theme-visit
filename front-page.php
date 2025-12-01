<?php
$args = array(
  'post_type' => 'pantalla',
  'posts_per_page' => -1,
  'meta_query' => array(
    array(
      'key' => 'aparece_en_el_home',
      'value' => 1,            // ACF True/False guarda 1 (true) y 0 (false)
      'compare' => '='
    )
  )
);

$query = new WP_Query($args);

$argsImperdibles = array(
  'post_type' => 'lugares-visit',
  'posts_per_page' => -1,
  'meta_query' => array(
    array(
      'key' => 'pantalla_relacionada',
      'value' => '"' . 231 . '"', // ACF guarda arrays serializados
      'compare' => 'LIKE'
    )
  )
);

$queryImperdibles = new WP_Query($argsImperdibles);
?>
<?php get_header(); ?>
<!-- Hero Section -->
<section class="hero hero--home" style="background:url(<?= get_field("imagen_fondo") ?>) top center/cover no-repeat;">
  <div class="hero__overlay"></div>
  <div class="hero__content" data-aos="fade-right">
    <div class="hero__left">
      <h1 class="hero__title">
        <img src="/wp-content/uploads/2025/11/visita-logo.png" alt="Visita Logo" class="hero__title-image" />
        <span class="hero__title--red">TENJO</span>
      </h1>
      <?php $description = get_the_content($post->ID); ?>
      <?= $description ?>
    </div>

    <div class="hero__right">
      <div class="hero__tags">
        <?php if ($query->have_posts()): ?>
          <?php
          while ($query->have_posts()):
            $query->the_post();
            $titulo_superior = "turismo";
            $titulo_inferior = get_the_title();
            $link = get_permalink();
            ?>
            <a href="<?php echo esc_url($link); ?>" class="hero__tag"> <?php echo esc_html($titulo_inferior); ?></a>
          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Los 10 Imperdibles Slider dentro del Hero -->
  <div class="hero__imperdibles" data-aos="fade-left">
    <h2 class="hero__imperdibles-title">
      <span class="hero__imperdibles-title--red">LOS 10 IMPERDIBLES</span>
      <br />
      <span class="hero__imperdibles-title--white">DE TENJO</span>
    </h2>

    <!-- Splide Slider -->
    <section class="splide hero__imperdibles-slider" aria-label="Los 10 Imperdibles de Tenjo">
      <div class="splide__track">
        <ul class="splide__list">
          <?php if ($queryImperdibles->have_posts()): ?>
            <?php while ($queryImperdibles->have_posts()):
              $queryImperdibles->the_post(); ?>

              <?php
              $imagen = get_field('imagen_listado'); // tu imagen ACF
              $titulo_superior = "turismo";
              $titulo_inferior = get_the_title();
              $link = get_permalink();
              ?>
              <li class="splide__slide hero__imperdibles-item">
                <a href="<?php echo esc_url($link); ?>" class="hero__imperdibles-link" style="height: -webkit-fill-available;">
                  <img src="<?php echo esc_url($imagen); ?>" alt="Mesa de Flores" class="hero__imperdibles-image" /></a>
                <div class="que-hacer__overlay">
                  <span class="que-hacer__card-line"></span>
                  <h3 class="que-hacer__card-title">
                    <?php echo esc_html($titulo_inferior); ?>
                  </h3>
                </div>
              </li>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
          <?php endif; ?>
        </ul>
      </div>

      <!-- Botón de Play/Pause (opcional) -->
      <button class="splide__toggle" type="button" aria-label="Play/Pause Slider">
        <svg class="splide__toggle__play" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#fff">
          <path d="m22 12-20 11v-22l10 5.5z" />
        </svg>
        <svg class="splide__toggle__pause" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#fff">
          <path d="m2 1v22h7v-22zm13 0v22h7v-22z" />
        </svg>
      </button>
    </section>
  </div>
</section>

<!-- Qué Hacer Section -->
<section class="que-hacer">
  <h2 class="que-hacer__title" data-aos="fade-down">
    <span class="que-hacer__title--red">¿QUÉ HACER</span>
    <span class="que-hacer__title--gray"> EN TENJO?</span>
  </h2>


  <div class="que-hacer__grid">

    <?php if ($query->have_posts()): ?>
      <?php while ($query->have_posts()):
        $query->the_post(); ?>

        <?php
        $imagen = get_field('imagen_listado'); // tu imagen ACF
        $titulo_superior = "turismo";
        $titulo_inferior = get_the_title();
        $link = get_permalink();
        ?>

        <a href="<?php echo esc_url($link); ?>" class="que-hacer__card" data-aos="fade-down">
          <img src="<?php echo esc_url($imagen); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"
            class="que-hacer__image" />

          <div class="que-hacer__overlay">
            <span class="que-hacer__card-line"></span>
            <h3 class="que-hacer__card-title">
              <?php echo esc_html($titulo_inferior); ?>
            </h3>
          </div>
        </a>

      <?php endwhile; ?>
      <?php wp_reset_postdata(); ?>
    <?php endif; ?>

  </div>
</section>

<!-- Services Section -->
<section class="services">
  <div class="services__container">
    <!-- Card 1: Dónde Comer -->
    <a href="/pantalla/donde-comer-en-tenjo/" class="services__card" data-aos="fade-down">
      <div class="services__image-wrapper">
        <img src="/wp-content/uploads/2025/11/donde_comer.png" alt="¿Dónde Comer en Tenjo?" class="services__image" />
        <div class="services__icon-badge">
          <svg fill="#ffffff" height="40px" viewBox="0 -2.89 122.88 122.88" version="1.1">
            <g>
              <path class="st0"
                d="M36.82,107.86L35.65,78.4l13.25-0.53c5.66,0.78,11.39,3.61,17.15,6.92l10.29-0.41c4.67,0.1,7.3,4.72,2.89,8 c-3.5,2.79-8.27,2.83-13.17,2.58c-3.37-0.03-3.34,4.5,0.17,4.37c1.22,0.05,2.54-0.29,3.69-0.34c6.09-0.25,11.06-1.61,13.94-6.55 l1.4-3.66l15.01-8.2c7.56-2.83,12.65,4.3,7.23,10.1c-10.77,8.51-21.2,16.27-32.62,22.09c-8.24,5.47-16.7,5.64-25.34,1.01 L36.82,107.86L36.82,107.86z M29.74,62.97h91.9c0.68,0,1.24,0.57,1.24,1.24v5.41c0,0.67-0.56,1.24-1.24,1.24h-91.9 c-0.68,0-1.24-0.56-1.24-1.24v-5.41C28.5,63.53,29.06,62.97,29.74,62.97L29.74,62.97z M79.26,11.23 c25.16,2.01,46.35,23.16,43.22,48.06l-93.57,0C25.82,34.23,47.09,13.05,72.43,11.2V7.14l-4,0c-0.7,0-1.28-0.58-1.28-1.28V1.28 c0-0.7,0.57-1.28,1.28-1.28h14.72c0.7,0,1.28,0.58,1.28,1.28v4.58c0,0.7-0.58,1.28-1.28,1.28h-3.89L79.26,11.23L79.26,11.23 L79.26,11.23z M0,77.39l31.55-1.66l1.4,35.25L1.4,112.63L0,77.39L0,77.39z" />
            </g>
          </svg>
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
    <a href="/pantalla/donde-dormir-en-tenjo/" class="services__card" data-aos="fade-down">
      <div class="services__image-wrapper">
        <img src="/wp-content/uploads/2025/11/habitacion.png" alt="¿Dónde Dormir en Tenjo?" class="services__image" />
        <div class="services__icon-badge">
          <svg height="40px" version="1.1" viewBox="0 0 512 512" fill="white">
            <g>
              <path class="st0"
                d="M119.729,129.325v-31.38c0-13.496,10.946-24.45,24.449-24.45h78.233c13.504,0,24.45,10.954,24.45,24.45v31.38
                c0,4.078-1.093,7.868-2.861,11.248h24c-1.768-3.38-2.861-7.17-2.861-11.248v-31.38c0-13.496,10.946-24.45,24.45-24.45h78.233
                c13.503,0,24.449,10.954,24.449,24.45v31.38c0,4.078-1.092,7.868-2.86,11.248h53.209V55.628c0-17.396-14.1-31.504-31.503-31.504
                H100.883c-17.402,0-31.504,14.108-31.504,31.504v84.946h53.209C120.822,137.194,119.729,133.403,119.729,129.325z" />
              <polygon class="st0" points="442.62,155.132 69.38,155.132 3.736,324.434 508.264,324.434 	" />
              <path class="st0" d="M0,336.62v54.209c0,18.643,15.108,33.752,33.752,33.752h444.496c18.643,0,33.752-15.108,33.752-33.752V336.62
                H0z" />
              <polygon class="st0" points="70.054,487.876 130.589,487.876 136.093,440.457 64.55,440.457 	" />
              <polygon class="st0" points="381.419,487.876 441.946,487.876 447.449,440.457 375.906,440.457 	" />
            </g>
          </svg>
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
    <a href="/agenda-de-eventos/" class="services__card" data-aos="fade-down">
      <div class="services__image-wrapper">
        <img src="/wp-content/uploads/2025/11/juegos_artificiales.png" alt="Agenda de Eventos en Tenjo"
          class="services__image" />
        <div class="services__icon-badge">
          <svg fill="white" height="40px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M1411.824 0c31.171 0 56.47 25.299 56.47 56.471v56.47h169.412c93.404 0 169.412 76.01 169.412 169.412V1920H113V282.353c0-93.402 76.009-169.412 169.412-169.412h169.411v-56.47c0-31.172 25.3-56.471 56.471-56.471 31.172 0 56.471 25.299 56.471 56.471v56.47h790.589v-56.47c0-31.172 25.299-56.471 56.47-56.471Zm169.413 1242.354h-338.823v338.823h338.823v-338.823Zm-451.766 0H790.647v338.823h338.824v-338.823Zm-451.765 0H338.882v338.823h338.824v-338.823Zm903.531-451.766h-338.823v338.824h338.823V790.588Zm-451.766 0H790.647v338.824h338.824V790.588Zm-451.765 0H338.882v338.824h338.824V790.588ZM451.823 225.882H282.412c-31.059 0-56.47 25.299-56.47 56.471v169.412h1468.234V282.353c0-31.172-25.411-56.471-56.47-56.471h-169.412v56.471c0 31.172-25.299 56.471-56.47 56.471s-56.47-25.299-56.47-56.471v-56.471H564.765v56.471c0 31.172-25.299 56.471-56.471 56.471-31.171 0-56.471-25.299-56.471-56.471v-56.471Z"
              fill-rule="evenodd" />
          </svg>
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
    <a href="/recorridos-y-actividades-predisenadas/" class="services__card" data-aos="fade-down">
      <div class="services__image-wrapper">
        <img src="/wp-content/uploads/2025/11/recorridos.png" alt="Recorridos y Actividades Prediseñadas"
          class="services__image" />
        <div class="services__icon-badge">
          <img src="/wp-content/uploads/2025/11/recorrido.png" alt="Icono Mapa" class="services__icon" />
        </div>
      </div>
      <div class="services__content">
        <h3 class="services__title">
          <span class="services__title--orange">RECORRIDOS Y</span>
          <span class="services__title--gray">ACTIVIDADES PREDISEÑADAS</span>
        </h3>
      </div>
    </a>
  </div>

  <!-- Sección banco de imagenes -->
  <div class="banco-imagenes">
    <a href="/banco-de-imagenes/" class="banco-imagenes__header" data-aos="fade-down"
      aria-label="Ir al banco de imágenes">
      <span class="banco-imagenes__title" role="heading" aria-level="2">
        BANCO DE IMÁGENES
      </span>
      <div class="banco-imagenes__icon" aria-hidden="true">
        <img src="/wp-content/uploads/2025/11/camara_roja.png" alt="" class="banco-imagenes__icon-image" />
      </div>
    </a>

    <nav class="banco-imagenes__nav">
      <ul class="banco-imagenes__menu">
        <li class="banco-imagenes__item" data-aos="fade-down">
          <a href="/preguntas-frecuentes/" class="banco-imagenes__link">
            <img src="/wp-content/uploads/2025/11/preguntas.png" alt="" class="banco-imagenes__link-icon" />
            Preguntas frecuentes
          </a>
        </li>
        <li class="banco-imagenes__item" data-aos="fade-down">
          <a href="https://situr.visitatenjo.com/" class="banco-imagenes__link">
            <img src="/wp-content/uploads/2025/11/grafico.png" alt="" class="banco-imagenes__link-icon" />
            SITUR
          </a>
        </li>
      </ul>
    </nav>
  </div>
</section>

<?php get_footer(); ?>