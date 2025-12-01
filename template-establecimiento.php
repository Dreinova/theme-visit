<?php
/* Template Name: Establecimiento Interno */
get_header();

// OBTENER ID desde URL /establecimiento/{id}
$est_id = get_query_var('est_id');
if (!$est_id) {
    echo "<h2>No se encontró el establecimiento.</h2>";
    get_footer();
    exit;
}

// ─────────────────────────────────────────────
// 1. CONSULTAR INFORMACIÓN DEL ESTABLECIMIENTO
// ─────────────────────────────────────────────
$api_response = wp_remote_get("https://apisitur.visitatenjo.com/establecimientos/publico/$est_id", [
    "headers" => [
        "X-API-KEY" => "d96e31d732b5329a5bfffaf30d8da427821693107aae19c1344eae7fe3446bd5"
    ]
]);

if (is_wp_error($api_response)) {
    echo "<h2>Error consultando la API.</h2>";
    get_footer();
    exit;
}

$api_body = json_decode(wp_remote_retrieve_body($api_response), true);
if (!$api_body["success"]) {
    echo "<h2>Establecimiento no encontrado.</h2>";
    get_footer();
    exit;
}

$datos = json_decode($api_body["data"]["datos"], true);

// ─────────────────────────────────────────────
// 2. USAR FOTOS DEL CAMPO "fotos"
// ─────────────────────────────────────────────
$imagenes = [];
if (!empty($datos["fotos"])) {
    foreach ($datos["fotos"] as $foto) {
        if ($foto) { // ignorar null
            $imagenes[] = [
                "full" => $foto,
                "thumb" => $foto
            ];
        }
    }
}
// Imagen fallback si no hay imágenes
$hero_img = $imagenes[0]["full"] ?? "https://placehold.co/1600x900";


// Título dinámico
$titulo = strtoupper($datos["nombre"]);

// Palabra resaltada (puede ser configurable)
$palabra_resaltada = $datos["categoria_rnt"] ?? "";
$titulo_sin_resaltar = trim(str_replace($palabra_resaltada, "", $titulo));
?>

<!-- HERO -->
<section class="hero hero--parque-tenjo" style="background-image:url('<?= $hero_img ?>');">
  <div class="hero__overlay"></div>
  <div class="hero__content" data-aos="fade-right">
    <div class="hero__left">
      <h1 class="hero__title">
        <span class="hero__title--red"><?= esc_html($palabra_resaltada) ?></span>
        <span class="hero__title--white"><?= esc_html($titulo_sin_resaltar) ?></span>
      </h1>
    </div>
  </div>
</section>

<!-- GALERÍA -->
<section class="parque-galeria" data-aos="fade-down">
  <div class="parque-galeria__container">

    <!-- Imagen principal -->
    <div class="parque-galeria__main">
      <img src="<?= esc_url($hero_img) ?>" id="mainImage" class="parque-galeria__main-image" />
    </div>

    <!-- Thumbnails -->
    <div class="parque-galeria__thumbnails">
      <?php foreach ($imagenes as $img): ?>
        <button class="parque-galeria__thumbnail"
          onclick="changeImage('<?= esc_url($img['full']) ?>')">
          <img src="<?= esc_url($img['thumb']) ?>" />
        </button>
      <?php endforeach; ?>
    </div>

  </div>

  <!-- Descripción -->
  <div class="parque-galeria__description" data-aos="zoom-in" style="max-width:768px;margin:50px auto 0">
    <?= wpautop($datos["descripcion"] ?? "Sin descripción disponible.") ?>
  </div>
</section>

<!-- UBICACIÓN Y CONTACTO -->
<section class="parque-ubicacion">
  <div class="parque-ubicacion__container">

    <!-- MAPA -->
    <div class="parque-ubicacion__mapa" data-aos="fade-right">
      <iframe
        src="https://www.google.com/maps?q=<?= $datos['coordenadas_y'] ?? 0 ?>,<?= $datos['coordenadas_x'] ?? 0 ?>&z=15&output=embed"
        width="100%" height="100%" style="border:0" loading="lazy"></iframe>
    </div>

    <div class="parque-ubicacion__info" data-aos="fade-left">

    <?php if(!empty($datos["horario"])): ?>
    <div class="parque-ubicacion__item">
        <div class="parque-ubicacion__icon"><img src="/wp-content/uploads/2025/11/reloj.png"></div>
        <div class="parque-ubicacion__details">
            <h4>Horario</h4>
            <?= $datos["horario"] ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if(!empty($datos["correo"])): ?>
    <div class="parque-ubicacion__item">
        <div class="parque-ubicacion__icon"><img src="/wp-content/uploads/2025/11/email.png"></div>
        <div class="parque-ubicacion__details">
            <h4>Correo</h4>
            <p><a href="mailto:<?= $datos['correo'] ?>"><?= $datos['correo'] ?></a></p>
        </div>
    </div>
    <?php endif; ?>

    <?php if(!empty($datos["telefono"])): ?>
    <div class="parque-ubicacion__item">
        <div class="parque-ubicacion__icon"><img src="/wp-content/uploads/2025/11/telefono.png"></div>
        <div class="parque-ubicacion__details">
            <h4>Teléfono</h4>
            <p><a href="tel:<?= $datos['telefono'] ?>"><?= $datos['telefono'] ?></a></p>
        </div>
    </div>
    <?php endif; ?>

    <?php if(!empty($datos["direccion_establecimiento"])): ?>
    <div class="parque-ubicacion__item">
        <div class="parque-ubicacion__icon"><img src="/wp-content/uploads/2025/11/ubicacion.png"></div>
        <div class="parque-ubicacion__details">
            <h4>Dirección</h4>
            <p><?= $datos['direccion_establecimiento'] ?></p>
        </div>
    </div>
    <?php endif; ?>

</div>

  </div>
</section>

<script>
function changeImage(newSrc) {
  const mainImage = document.getElementById("mainImage");
  mainImage.style.opacity = "0";
  setTimeout(() => {
    mainImage.src = newSrc;
    mainImage.style.opacity = "1";
  }, 200);
}
</script>

<?php get_footer(); ?>
