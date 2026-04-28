<?php
/*
Template Name: Página de FAQ
*/
$paged = 1;

$args = [
  'post_type'      => 'imagenes-visit',
  'posts_per_page' => 12,
  'paged'          => $paged,
  'orderby'        => 'menu_order',
  'order'          => 'ASC',
];

$images_query = new WP_Query($args);
get_header(); 
if ($images_query->have_posts()):
?>
<!-- Hero del Banco de Imágenes -->
<section class="banco-hero">
  <?php
  // Reutilizamos el helper del hero pero con la clase de banco-hero
  $img = '/wp-content/uploads/2025/12/BANCO-DE-IMAGENES.jpg';
  printf(
    '<img class="banco-hero__media" src="%s" width="1920" height="1080" alt="%s" fetchpriority="high" decoding="async" />',
    esc_url($img),
    esc_attr('Banco de imágenes Visita Tenjo')
  );
  ?>
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
  <div class="galeria__container" id="galeria-container" data-page="1">
  <?php while ($images_query->have_posts()): $images_query->the_post(); ?>
    <?php
      // Campos principales
      $title = get_the_title();
      $content = get_the_content();
      $post_id = get_the_ID();
      $image_thumb = get_the_post_thumbnail($post_id, 'galeria_thumb');
      $link = get_permalink();
    ?>
    <!-- Imagen 1 -->
   <div class="galeria__item" data-categoria="naturaleza">
        <a href="<?= esc_url($link); ?>?alt=<?=$title ?>" class="galeria__image-wrapper">
          <?= wp_get_attachment_image(
  get_post_thumbnail_id($post_id),
  'galeria_thumb',
  false,
  [
    'class' => 'galeria__image',
    'loading' => 'lazy',
    'decoding' => 'async',
    'sizes' => '(max-width: 768px) 100vw, 33vw'
  ]
)?>
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
  <div class="load-more-wrapper">
  <button id="load-more-btn" data-max="<?php echo $images_query->max_num_pages; ?>" style="
    display: flex;
    align-items: center;
    gap: 16px;
    background: #636363;
    color: #fff;
    padding: 5px 19px 5px 20px;
    border-radius: 24px;
    text-decoration: none;
    font-size: 21px;
    font-weight: 600;
    transition: all .3s ease;
    box-shadow: 0 4px 8px rgba(0, 0, 0, .2);
    border: 2px solid #fff;
    margin: 30px auto;
">
    Cargar más
  </button>
</div>
  
</section>
<?php endif; wp_reset_postdata();?>
<?php get_footer(); ?>