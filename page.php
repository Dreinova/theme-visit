<?php
get_header(); ?>
<div
  class="page-content <?php echo 'page-' . get_post_field('post_name', get_post()); ?>"
>
  <?php get_template_part( 'template-parts/section', 'banner' ); ?>
  <div class="description">
    <?php $description = get_the_content($post->ID); ?>
    <?= $description ?>
  </div>
</div>

<?php get_footer(); ?>
