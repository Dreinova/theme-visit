<?php
get_header();
$imagen_fondo = get_field('imagen_banner');
$titulo = get_the_title(); // Texto completo
$palabra_resaltada = get_field('palabra_resaltada');

// Quitar la palabra resaltada del título
$titulo_sin_resaltar = str_replace($palabra_resaltada, '', $titulo);
$titulo_sin_resaltar = trim($titulo_sin_resaltar); // Limpia espacios dobles

?>

<!-- Hero con imagen de fondo -->
<section class="hero hero--turismo-cultural">
  <?php visit_render_hero_image($imagen_fondo, $titulo); ?>
  <div class="hero__overlay"></div>
  <div class="hero__content" data-aos="fade-right">
    <div class="hero__left">
      <h1 class="hero__title">
        <span class="hero__title--red"><?= $palabra_resaltada ?></span>
        <span class="hero__title--white"><?= $titulo_sin_resaltar ?></span>
      </h1>

    </div>
  </div>
</section>

<!-- Sección de introducción -->
<section class="turismo-intro">
  <div class="turismo-intro__container">
    <?= get_the_content() ?>
  </div>
</section>
<?php
$current_slug = get_post_field('post_name', get_post());
// Corrección: Leer desde el CSV mapeado, no desde el JSON
$config = situr_get_screen_config($current_slug);

$subcategorias = [];
if ($config && !empty($config['subcategorias'])) {
    foreach ($config['subcategorias'] as $sub) {
        if (!empty($sub)) {
            $subcategorias[$sub] = ucwords(str_replace('_', ' ', $sub));
        }
    }
}

// Corrección: Definir $filtros para evitar warnings en el HTML
$filtros = $_GET['filtro'] ?? [];
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
