<style>
  .gastronomia-grid__container {
  min-height: 300px;
}
  .loader {
  width: 40px;
  height: 40px;
  border: 4px solid #eee;
  border-top: 4px solid #d32f2f;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin: 40px auto;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}
  .turismo-layout {
  display: grid;
  grid-template-columns: 280px 1fr;
  gap: 32px;
  max-width: 1200px;
  margin: 0 auto;
  padding: 40px 20px;
}
  .filtros {
  background: #f5f5f5;
  border-radius: 12px;
  padding: 20px;
  position: sticky;
  top: 120px;
  height: fit-content;
}
.filtros h3 {
  font-size: 16px;
  font-weight: 700;
  margin-bottom: 15px;
}

.filtros label {
  padding: 6px 0;
  border-bottom: 1px solid #e0e0e0;
}

.filtros label:last-child {
  border-bottom: none;
}
.filtros label {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 10px;
  cursor: pointer;
  font-size: 14px;
}

.filtros input[type="checkbox"] {
  accent-color: #d32f2f;
  cursor: pointer;
}

.filtros button {
  margin-top: 15px;
  width: 100%;
  padding: 10px;
  background: #d32f2f;
  color: #fff;
  border: none;
  border-radius: 8px;
  cursor: pointer;
}
.gastronomia-grid__container {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 25px;
}
.restaurante-card {
  position: relative;
  display: block;
  border-radius: 14px;
  overflow: hidden;
  text-decoration: none;
  height: 260px;
}

.restaurante-card__image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.4s ease;
}

.restaurante-card:hover .restaurante-card__image {
  transform: scale(1.08);
}
.restaurante-card__overlay {
  position: absolute;
  inset: 0;
  display: flex;
  align-items: flex-end;
  padding: 15px;
  background: linear-gradient(
    to top,
    rgba(0,0,0,0.7),
    rgba(0,0,0,0.2),
    transparent
  );
}

.restaurante-card__title {
  color: #fff;
  font-size: 16px;
  font-weight: 600;
  line-height: 1.2;
}
@media (max-width: 1024px) {
  .gastronomia-grid__container {
    grid-template-columns: repeat(2, 1fr);
  }

  .turismo-layout {
    grid-template-columns: 220px 1fr;
  }
}

@media (max-width: 768px) {
  .turismo-layout {
    grid-template-columns: 1fr;
  }

  .filtros {
    position: relative;
    top: auto;
    margin-bottom: 20px;
  }

  .gastronomia-grid__container {
    grid-template-columns: 1fr;
  }
}
</style>
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
<section class="hero hero--turismo-cultural" style="background-image: url(<?= $imagen_fondo ?>)">
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
$filtros = $_GET['filtro'] ?? [];
$pantallas = get_field('pantalla_relacionada');

$subcategorias = [];

if ($pantallas) {
    foreach ($pantallas as $id) {
        $post = get_post($id);
        $slug = $post->post_name; // 👈 CLAVE (coincide con helper)
        $label = $post->post_title;

        $subcategorias[$slug] = $label;
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
if (empty($filtros) && !empty($subcategorias)) {
    $filtros = array_keys($subcategorias);
}

situr_render_establecimientos($filtros);
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

  fetch(ajaxData.url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: new URLSearchParams({
      action: 'filtrar_establecimientos',
      filtros: filtros
    })
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