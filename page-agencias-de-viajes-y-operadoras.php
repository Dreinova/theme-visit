<?php
/*
Template Name: Agencias de Viajes y Operadoras de Turismo
*/
get_header();
?>

<section
  class="hero hero--agencias"
  style="background-image: url('<?php echo esc_url(get_field('imagen_banner') ?: '/wp-content/uploads/2025/11/recorridos_bg.png'); ?>')"
>
  <div class="hero__overlay"></div>
  <div class="hero__content" data-aos="fade-right">
    <div class="hero__left">
      <h1 class="hero__title">
        <span class="hero__title--red">AGENCIAS DE VIAJES</span>
        <span class="hero__title--white">Y OPERADORAS DE TURISMO</span>
      </h1>
    </div>
  </div>
</section>

<section class="gastronomia-intro">
  <div class="gastronomia-intro__container">
    <?php echo apply_filters('the_content', get_post_field('post_content', $post->ID)); ?>
  </div>
</section>

<section class="gastronomia-grid">
  <div class="gastronomia-grid__container">
    <?php situr_render_establecimientos('agencias-de-viajes'); ?>
  </div>
</section>
<section class="situr-banner">
  <div class="situr-banner__content">
    <h2 class="situr-banner__title">
      ¿Quieres ver aquí tu establecimiento?
    </h2>
    <p class="situr-banner__text">
       <strong>Visitatenjo.com</strong> muestra los establecimientos turísticos de Tenjo pertenecientes al Sistema de Información Turística SITUR del municpio."  ¿Quieres ver aquí tu establecimiento? Registralo en minutos a través de
    </p>
    <a href="https://situr.visitatenjo.com" target="_blank" class="situr-banner__button">
      Regístralo en minutos
    </a>
  </div>
</section>
<?php get_footer(); ?>
