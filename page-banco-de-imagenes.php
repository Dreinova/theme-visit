<?php
/*
Template Name: Página de FAQ
*/
$args = array(
  'post_type' => 'imagenes-visit',
  'posts_per_page' => -1,
  'orderby' => 'menu_order',
  'order' => 'ASC',
);
 get_header(); 
$images_query = new WP_Query($args);
if ($images_query->have_posts()):
?>
<!-- Hero del Banco de Imágenes -->
<section
  class="banco-hero"
  style="background-image: url('/wp-content/uploads/2025/12/BANCO-DE-IMAGENES.jpg')"
>
  <div class="banco-hero__overlay"></div>
  <div class="banco-hero__content" data-aos="fade-right">
    <!-- Buscador -->
    <div class="banco-hero__search">
      <div class="banco-hero__search-wrapper">
        <img src="/wp-content/uploads/2025/11/lupa.png" alt="Buscar" class="banco-hero__search-icon" />
        <input
          type="search"
          id="searchInput"
          name="search"
          class="banco-hero__search-input"
          placeholder="Escribe aquí lo que estas buscando"
          aria-label="Buscar imágenes"
          autocomplete="off"
        />
      </div>

      <!-- Separador vertical -->
      <div class="banco-hero__divider"></div>

      <!-- Select de categorías -->
      <div class="banco-hero__select-wrapper">
        <select
          class="banco-hero__select"
          id="categorySelect"
          name="category"
          class="banco-hero__select"
          aria-label="Seleccionar categoría"
        >
          <option value="">CATEGORÍAS</option>
          <option value="naturaleza">Naturaleza</option>
          <option value="cultura">Cultura</option>
          <option value="gastronomia">Gastronomía</option>
          <option value="eventos">Eventos</option>
          <option value="arquitectura">Arquitectura</option>
        </select>
      </div>
      <!-- Botón oculto para enviar con Enter -->
      <button type="submit" class="visually-hidden">Buscar</button>
    </div>
  </div>
</section>

<!-- Sección Galería de Imágenes -->
<section class="galeria">
  <div class="galeria__container">
    <?php 
      while ($images_query->have_posts()):
      $images_query->the_post(); 
    ?>
    <?php
      // Campos principales
      $title = get_the_title();
      $content = get_the_content();
      $post_id = get_the_ID();
$image_thumb = get_the_post_thumbnail_url($post_id, 'thumbnail');
        $link = get_permalink();

    ?>
    <!-- Imagen 1 -->
   <div class="galeria__item" data-categoria="naturaleza">
        <a href="<?= esc_url($link); ?>?img=<?= esc_url($image_thumb); ?>&alt=<?=$title ?>" class="galeria__image-wrapper">
          <img src="<?= esc_url($image_thumb); ?>" alt="<?=$title?>" class="galeria__image" />
          <div class="galeria__overlay">
            <span class="galeria__btn-view" aria-label="Ver imagen">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
              </svg>
            </span>
          </div>
        </a>
      </div>
 <?php endwhile; ?>
  </div>
</section>
<?php endif; wp_reset_postdata();?>
<?php get_footer(); ?>