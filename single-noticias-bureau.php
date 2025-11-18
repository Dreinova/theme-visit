<?php get_header(); ?>

<?php
if (have_posts()) :
    while (have_posts()) : the_post();
        $img = get_the_post_thumbnail_url(get_the_ID(), 'large');
        $categorias = get_the_terms(get_the_ID(), 'categoria-noticia');
?>
    <section class="single-noticia">
        <div class="container">
            
            <?php if (!empty($categorias) && !is_wp_error($categorias)) : ?>
                <div class="categoria">
                    <?php foreach ($categorias as $categoria) : ?>
                        <a href="<?= esc_url(get_term_link($categoria)); ?>">
                            <?= esc_html($categoria->name); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <h1 class="titulo"><?php the_title(); ?></h1>

            <?php if ($img) : ?>
                <div class="imagen">
                    <img src="<?= esc_url($img); ?>" alt="<?php the_title(); ?>">
                </div>
            <?php endif; ?>

            <div class="contenido">
                <?php the_content(); ?>
            </div>

        </div>
    </section>

<?php
    endwhile;
endif;
?>

<?php get_footer(); ?>
