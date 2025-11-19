<?php 
get_header(); 
$imagen_fondo      = get_field('imagen_banner');
$titulo             = get_the_title(); // Texto completo
$palabra_resaltada  = get_field('palabra_resaltada');

// Quitar la palabra resaltada del título
$titulo_sin_resaltar = str_replace($palabra_resaltada, '', $titulo);
$titulo_sin_resaltar = trim($titulo_sin_resaltar); // Limpia espacios dobles

?>

 <!-- Hero con imagen de fondo -->
    <section
      class="hero hero--turismo-cultural"
      style="background-image: url(<?=$imagen_fondo?>)"
    >
      <div class="hero__overlay"></div>
      <div class="hero__content">
        <div class="hero__left">
          <h1 class="hero__title">
    <span class="hero__title--red">Turismo</span>
    <span class="hero__title--white"><?= $titulo_sin_resaltar ?></span>
</h1>

        </div>
      </div>
    </section>

    <!-- Sección de introducción -->
    <section class="turismo-intro">
      <div class="turismo-intro__container">
        <?=get_the_content()?>
      </div>
    </section>

<?php get_footer(); ?>
