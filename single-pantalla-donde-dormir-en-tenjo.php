<?php get_header(); ?>

<section
  class="hero hero--turismo-gastronomico"
  style="background-image: url('/wp-content/uploads/2025/11/7-DONDE-DORMIR.jpeg')"
>
  <div class="hero__overlay"></div>
  <div class="hero__content" data-aos="fade-right">
    <div class="hero__left">
      <h1 class="hero__title">
        <span class="hero__title--red">DÓNDE</span>
        <span class="hero__title--white">DORMIR</span>
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
    <?php situr_render_establecimientos('alojamiento'); ?>
  </div>
</section>

<?php get_footer(); ?>
