<?php
/*
Template Name: Agencias de Viajes y Operadoras de Turismo
*/
get_header();
?>

<section class="hero hero--agencias">
  <?php visit_render_hero_image(get_field('imagen_banner') ?: '/wp-content/uploads/2025/11/recorridos_bg.png', 'Agencias de viajes y operadoras de turismo en Tenjo'); ?>
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

<?php
$current_slug = get_post_field('post_name', get_post());
$config = situr_get_screen_config($current_slug);

if (!$config) {
    $subcategorias = [];
} else {
    $subcategorias = [];

    foreach ($config['subcategorias'] as $sub) {
        $subcategorias[$sub] = ucwords(str_replace('_', ' ', $sub));
    }
}
?>
<div class="turismo-layout">
  <!-- FILTROS -->
  <aside class="filtros">
  <form method="GET">
    <h3>Tipo de experiencia</h3>

    <?php
$conteos = situr_get_conteo_filtros(array_keys($subcategorias));
?>

<?php foreach ($subcategorias as $slug => $label): ?>

  <?php if (!empty($conteos[$slug])): // 👈 SOLO mostrar si tiene resultados ?>

    <label>
      <input
        type="checkbox"
        name="filtro[]"
        value="<?= $slug ?>"
        <?= in_array($slug, $filtros) ? 'checked' : '' ?>
      >
      <?= $label ?> (<?= $conteos[$slug] ?>)
    </label>

  <?php endif; ?>

<?php endforeach; ?>

    <!-- <button type="submit">Filtrar</button> -->
  </form>
</aside>

  <!-- RESULTADOS -->
  <div class="resultados">
    <section class="gastronomia-grid">
      <div class="gastronomia-grid__container">
   <?php
$filtros_activos = $_GET['filtro'] ?? [];

$current_slug = get_post_field('post_name', get_post());
$config = situr_get_screen_config($current_slug);



if (!$config) {
    echo '<p>No hay configuración</p>';
    return;
}

// 👇 BASE de la pantalla
$filtros_base = array_merge(
    $config['categorias'],
    $config['subcategorias']
);

// 👇 SI el usuario no selecciona nada → usar base
$filtros_finales = !empty($filtros_activos)
    ? $filtros_activos
    : $filtros_base;

situr_render_establecimientos($filtros_finales);
?>
      </div>
    </section>
  </div>

</div>

<?php get_footer(); ?>

<script>
  document.addEventListener('DOMContentLoaded', () => {

  const checkboxes = document.querySelectorAll('.filtros input[type="checkbox"]');
  const container = document.querySelector('.gastronomia-grid__container');

  function obtenerFiltros() {
    let valores = [];
    checkboxes.forEach(cb => {
      if (cb.checked) valores.push(cb.value);
    });
    return valores;
  }

  function cargarEstablecimientos() {

  let filtros = obtenerFiltros();

  // 👇 si no hay filtros, mandar TODOS
  if (filtros.length === 0) {
    filtros = Array.from(checkboxes).map(cb => cb.value);
  }

  container.innerHTML = '<div class="loader"></div>';

 const params = new URLSearchParams();
params.append('action', 'filtrar_establecimientos');

filtros.forEach(f => params.append('filtros[]', f));

fetch(ajaxData.url, {
  method: 'POST',
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded'
  },
  body: params
})
  .then(res => res.json())
  .then(data => {
    container.innerHTML = data.success ? data.data : '<p>Error</p>';
  });
}

  // Evento en checkboxes
  checkboxes.forEach(cb => {
    cb.addEventListener('change', cargarEstablecimientos);
  });

});
</script>
