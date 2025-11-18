<?php get_header(); ?>

<?php get_template_part( 'template-parts/section', 'banner' ); ?>
<?php if ( get_field('titulo_principal') ) : ?>
  <?php get_template_part( 'template-parts/section', 'destino' ); ?>
  <?php endif; ?>
  <?php get_template_part( 'template-parts/section', 'porque' ); ?>
  <div class="description" data-aos="fade-up">
      <?php $description = get_the_content($post->ID); ?>
      <?= $description ?>
      <a href="/obten-asesoria-de-expertos/" class="btn-secondary">Solicita asesoría gratuita</a>
    </div>
    <?php get_template_part( 'template-parts/section', 'eventosfrontpage' ); ?>

<?php get_footer(); ?>