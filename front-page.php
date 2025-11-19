<?php
$args = array(
    'post_type' => 'pantalla',
    'posts_per_page' => -1,
    'meta_query' => array(
        array(
            'key'   => 'aparece_en_el_home',
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
            'key'     => 'pantalla_relacionada',
            'value'   => '"' . 231 . '"', // ACF guarda arrays serializados
            'compare' => 'LIKE'
        )
    )
);

$queryImperdibles = new WP_Query($argsImperdibles);
?>
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
            <?php if ($query->have_posts()) : ?>
  <?php 
  while ($query->have_posts()) : $query->the_post(); 
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
              <?php if ($queryImperdibles->have_posts()) : ?>
  <?php while ($queryImperdibles->have_posts()) : $queryImperdibles->the_post(); ?>

    <?php 
      $imagen = get_field('imagen_listado'); // tu imagen ACF
      $titulo_superior = "turismo"; 
      $titulo_inferior = get_the_title(); 
      $link = get_permalink(); 
    ?>
  <li class="splide__slide hero__imperdibles-item">
    <a href="<?php echo esc_url($link); ?>" class="hero__imperdibles-link">
      <img
        src="<?php echo esc_url($imagen); ?>"
        alt="Mesa de Flores"
        class="hero__imperdibles-image"
    /></a>
  </li>
  <?php endwhile; ?>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>
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
        
<?php if ($query->have_posts()) : ?>
  <?php while ($query->have_posts()) : $query->the_post(); ?>

    <?php 
      $imagen = get_field('imagen_listado'); // tu imagen ACF
      $titulo_superior = "turismo"; 
      $titulo_inferior = get_the_title(); 
      $link = get_permalink(); 
    ?>

    <a href="<?php echo esc_url($link); ?>" class="que-hacer__card">
      <img
        src="<?php echo esc_url($imagen); ?>"
        alt="<?php echo esc_attr(get_the_title()); ?>"
        class="que-hacer__image"
      />

      <div class="que-hacer__overlay">
        <h3 class="que-hacer__card-title">
          <span class="que-hacer__card-line"></span>
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
        <a href="/pantalla/donde-comer-en-tenjo/" class="services__card">
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
        <a href="/pantalla/donde-dormir-en-tenjo/" class="services__card">
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
        <a href="/agenda-de-eventos/" class="services__card">
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
        <a href="/recorridos-y-actividades-predisenadas/" class="services__card">
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
          href="/banco-de-imagenes/"
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
              <a href="/preguntas-frecuentes/" class="banco-imagenes__link">
                <img
                  src="/wp-content/uploads/2025/11/preguntas.png"
                  alt=""
                  class="banco-imagenes__link-icon"
                />
                Preguntas frecuentes
              </a>
            </li>
            <li class="banco-imagenes__item">
              <a href="/banco-de-imagenes/" class="banco-imagenes__link">
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