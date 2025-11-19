<?php
/*
Template Name: Página de FAQ
*/
$args = array(
    'post_type'      => 'recorridos-visit',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
);

$recorridos_query = new WP_Query($args);
if ($recorridos_query->have_posts()) :
?>
<?php get_header(); ?>

<!-- Hero con imagen de fondo -->
   <section
     class="hero hero--recorridos"
     style="background-image: url('/wp-content/uploads/2025/11/recorridos_bg.png')"
   >
     <div class="hero__overlay"></div>
     <div class="hero__content">
       <div class="hero__left">
         <h1 class="hero__title">
           <span class="hero__title--red">RECORRIDOS Y</span>
           <span class="hero__title--white">ACTIVIDADES PREDISEÑADAS</span>
         </h1>
       </div>
     </div>
   </section>

   <!-- Sección de introducción -->
   <section class="recorridos-intro">
     <div class="recorridos-intro__container">
       <?= get_the_content(); ?>
     </div>
   </section>

   <!-- Grid de restaurantes gastronómicos -->
   <section class="recorridos-grid">
     <div class="recorridos-grid__container">
      <?php while ($recorridos_query->have_posts()) : $recorridos_query->the_post(); ?>
      <?php
          // Campos principales
          $title       = get_the_title();
          $content     = get_the_content();
          $image       = get_the_post_thumbnail_url();
          $link        = get_permalink();
      ?>

       <a href="<?= esc_url($link); ?>" class="recorrido-card">
         <img
           src="<?= esc_url($image); ?>"
           alt="Faunáticos Granja Pedagógica"
           class="recorrido-card__image"
         />
         <div class="recorrido-card__overlay">
           <h3 class="recorrido-card__title">
             <?= esc_html($title); ?>
           </h3>
         </div>
       </a>
      <?php endwhile; ?>
     </div>
   </section>
   <?php
    endif;
    wp_reset_postdata();
?>
<?php get_footer(); ?>