<?php get_header(); ?>
<!-- Hero con imagen de fondo -->
<section
  class="hero hero--turismo-gastronomico"
  style="background-image: url('/wp-content/uploads/2025/11/turismo_gastronomico_bg.png')"
>
  <div class="hero__overlay"></div>
  <div class="hero__content" data-aos="fade-right">
    <div class="hero__left">
      <h1 class="hero__title">
        <span class="hero__title--red">TURISMO</span>
        <span class="hero__title--white">GASTRONÓMICO</span>
      </h1>
    </div>
  </div>
</section>

<!-- Sección de introducción -->
<section class="gastronomia-intro">
  <div class="gastronomia-intro__container">
   <?php $description = get_the_content($post->ID); ?>
            <?= $description ?>
  </div>
</section>

<!-- Grid de restaurantes gastronómicos -->
<section class="gastronomia-grid">
  <div class="gastronomia-grid__container">
    <!-- Restaurante 1 -->
    <a href="#" class="restaurante-card">
      <img
        src="/wp-content/uploads/2025/11/faunaticos.png"
        alt="Faunáticos Granja Pedagógica"
        class="restaurante-card__image"
      />
      <div class="restaurante-card__overlay">
        <h3 class="restaurante-card__title">
          FAUNÁTICOS<br />GRANJA PEDAGÓGICA
        </h3>
      </div>
    </a>
  </div>
</section>
<?php get_footer(); ?>
