<?php
/*
Template Name: Página de FAQ
*/
$args = array(
    'post_type'      => 'preguntas-visit',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
);

$faq_query = new WP_Query($args);

if ($faq_query->have_posts()) :
?>
<?php get_header(); ?>
<!-- Hero con imagen de fondo -->
    <section
      class="hero hero--faq"
      style="background-image: url('/wp-content/uploads/2025/11/faq-bg.jpg')"
    >
      <div class="hero__overlay"></div>
      <div class="hero__content">
        <div class="hero__left">
          <h1 class="hero__title">
            <span class="hero__title--red">PREGUNTAS</span>
            <span class="hero__title--white">FRECUENTES</span>
          </h1>
        </div>
      </div>
    </section>

    <!-- Sección Preguntas frecuentes -->
    <section class="faq">
      <div class="faq__container">
        <div class="faq__column">
            <?php $i = 0; // contador ?>
            <?php while ($faq_query->have_posts()) : $faq_query->the_post(); ?>
            <div class="faq__item">
              <input type="checkbox" id="faq-<?= $i; ?>" class="faq__checkbox" />
              <label for="faq-<?= $i; ?>" class="faq__question">
                <svg
                  class="faq__icon"
                  width="14"
                  height="8"
                  viewBox="0 0 14 8"
                  fill="none"
                >
                  <path
                    d="M1 1L7 7L13 1"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                  />
                </svg>
                <span><?php the_title(); ?></span>
              </label>
              <div class="faq__answer">
                <div class="faq__answer-content">
                  <?php the_content(); ?>
                </div>
              </div>
            </div>
               <?php $i++; // aumenta el contador ?>
            <?php endwhile; ?>
        </div>
      </div>
    </section>
  
  </div>
</section>
<?php
endif;
wp_reset_postdata();
?>
</div>
  

<?php get_footer(); ?>

