<?php
/* Template Name: Establecimiento Interno */
   function normalize_json($value) {
    if (is_string($value)) {
        $decoded = json_decode($value, true);
        return json_last_error() === JSON_ERROR_NONE ? $decoded : [];
    }

    if (is_array($value)) {
        return $value;
    }

    return [];
}

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
$datos = normalize_json($api_body["data"]["datos"]);

$dataNormalizada = normalize_json($datos['data'] ?? []);


// ─────────────────────────────────────────────
// 2. USAR FOTOS DEL CAMPO "fotos"
// ─────────────────────────────────────────────
$imagenes = [];
$fotos = normalize_json($datos["fotos"]);
if (!empty($fotos)) {
  foreach ($fotos as $foto) {
    if (!$foto) continue;
    $url = is_array($foto) ? ($foto["url"] ?? null) : $foto;
    if ($url) $imagenes[] = ["full" => $url, "thumb" => $url];
}
}
// Imagen fallback si no hay imágenes
$hero_img = !empty($imagenes)
    ? ($imagenes[array_rand($imagenes)]['full'] ?? "https://placehold.co/1600x900")
    : "https://placehold.co/1600x900";


// Título dinámico
$titulo = strtoupper($datos["nombre"]);

// Palabra resaltada (puede ser configurable)
$palabra_resaltada = $datos["categoria_rnt"] ?? "";
$titulo_sin_resaltar = trim(str_replace($palabra_resaltada, "", $titulo));
?>
<?php
$iconos = [
    'instagram' => 'fab fa-instagram',
    'tiktok'    => 'fab fa-tiktok',
    'facebook'  => 'fab fa-facebook-f',
    'whatsapp'  => "fa-brands fa-whatsapp",
    'youtube'  => "fa-brands fa-youtube"
    
];
global $establecimiento_meta;


$establecimiento_meta = [
 'titulo'       => $titulo ?? '',
  'descripcion'  => wp_strip_all_tags($datos['descripcion'] ?? ''),
  'imagen'       => $hero_img ?? '',
  'keywords'     => $datos['categoria_rnt'] ?? '',
];
get_header();



?>

<!-- HERO -->
<section class="hero hero--parque-tenjo" style="background-image:url('<?= $hero_img ?>');">
  <div class="hero__overlay"></div>
  <div class="hero__content" data-aos="fade-right">
    <div class="hero__left">
      <h1 class="hero__title">
        <span class="hero__title--white"><?= esc_html($titulo_sin_resaltar) ?></span>
      </h1>
    </div>
  </div>
</section>
<?php

$imagenes = [];
$imagenesRaw = $api_body["data"]["imagenes"] ?? [];

// Si viene como string JSON
if (is_string($imagenesRaw)) {
    $decoded = json_decode($imagenesRaw, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        $imagenesRaw = $decoded;
    }
}

if (is_array($imagenesRaw)) {
    foreach ($imagenesRaw as $img) {

        if (!empty($img["url_imagen"])) {

            $fullUrl = "https://apisitur.visitatenjo.com" . $img["url_imagen"];

            $imagenes[] = [
                "full" => $fullUrl,
                "thumb" => $fullUrl // si no tienes miniaturas, usamos la misma
            ];
        }
    }
}

// 🔁 Fallback viejo si no hay imágenes nuevas
if (empty($imagenes)) {

    $fotos = $datos["fotos"] ?? [];

    if (is_string($fotos)) {
        $decoded = json_decode($fotos, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $fotos = $decoded;
        }
    }

    if (is_array($fotos)) {
        foreach ($fotos as $foto) {

            if (is_array($foto) && !empty($foto["url"])) {
                $imagenes[] = [
                    "full" => $foto["url"],
                    "thumb" => $foto["url"]
                ];
            }

            if (is_string($foto)) {
                $imagenes[] = [
                    "full" => $foto,
                    "thumb" => $foto
                ];
            }
        }
    }
}

// Si aún está vacío → placeholder
if (empty($imagenes)) {
    $imagenes[] = [
        "full" => "https://placehold.co/1080x1920",
        "thumb" => "https://placehold.co/300x300"
    ];
}
?>
<!-- GALERÍA -->
<section class="parque-galeria" data-aos="fade-down">
  <div class="parque-galeria__container">

    <div class="parque-galeria__main">
      <img src="<?= esc_url($imagenes[0]['full']) ?>" 
           id="mainImage" 
           class="parque-galeria__main-image" />
    </div>

    <div class="parque-galeria__thumbnails">
      <?php foreach ($imagenes as $img): ?>
        <button class="parque-galeria__thumbnail"
          onclick="changeImage('<?= esc_url($img['full']) ?>')">
          <img src="<?= esc_url($img['thumb']) ?>" />
        </button>
      <?php endforeach; ?>
    </div>

  </div>

  <div class="parque-galeria__description"
       data-aos="zoom-in"
       style="max-width:768px;margin:50px auto 0">
    <?= wpautop($datos["descripcion"] ?? "Sin descripción disponible.") ?>
  </div>
</section>

<!-- UBICACIÓN Y CONTACTO -->
<section class="parque-ubicacion">
  <div class="parque-ubicacion__container">

    <!-- MAPA -->
    <div class="parque-ubicacion__mapa" data-aos="fade-right">
   <?php
if (!empty($datos['coordenadas_x']) && !empty($datos['coordenadas_y'])) {
    $ubicacion = $datos['coordenadas_x'] . "," . $datos['coordenadas_y'];
} else {
    $ubicacion = urlencode($datos['direccion_establecimiento']);
}
?>
<iframe
    src="https://www.google.com/maps?q=<?= $ubicacion ?>&z=15&output=embed"
    width="100%"
    height="100%"
    style="border:0"
    loading="lazy">
</iframe>
    </div>

    <div class="parque-ubicacion__info" data-aos="fade-left">
   

    <?php 
    if(!empty($dataNormalizada['field_1766259143120'])): ?>
    <div class="parque-ubicacion__item">
        <div class="parque-ubicacion__icon"><img src="/wp-content/uploads/2025/11/reloj.png"></div>
        <div class="parque-ubicacion__details">
            <h4>Horario</h4>
            <?= $dataNormalizada['field_1766259143120'] ?>
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
    <?php 
        $redes_sociales = normalize_json($datos['redes_sociales'] ?? []);
        if (!empty($redes_sociales)):
    ?>
       <div class="parque-ubicacion__item">
        <div class="parque-ubicacion__icon"></div>
        <div class="parque-ubicacion__details">
            <h4>Redes sociales</h4>
             <?php foreach ($redes_sociales as $red): ?>
            <?php
            $nombre = $red['red'] ?? '';
            $url    = $red['url'] ?? '';
            $icono  = $iconos[$nombre] ?? 'fas fa-share-alt'; // icono por defecto
            ?>

            <?php if ($url): ?>
                <a href="<?php echo esc_url($url); ?>"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="red-social red-<?php echo esc_attr($nombre); ?>" style="
    font-size: 26px;
    font-weight: 700;
    color: #222;
    text-decoration:none;
">
                    <i class="<?php echo esc_attr($icono); ?>"></i>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
 </div>
 </div>
<?php endif; ?>
    <?php if(!empty( $datos["pagina_web"])): ?>
    <div class="parque-ubicacion__item">
        <div class="parque-ubicacion__icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path d="M415.9 344L225 344C227.9 408.5 242.2 467.9 262.5 511.4C273.9 535.9 286.2 553.2 297.6 563.8C308.8 574.3 316.5 576 320.5 576C324.5 576 332.2 574.3 343.4 563.8C354.8 553.2 367.1 535.8 378.5 511.4C398.8 467.9 413.1 408.5 416 344zM224.9 296L415.8 296C413 231.5 398.7 172.1 378.4 128.6C367 104.2 354.7 86.8 343.3 76.2C332.1 65.7 324.4 64 320.4 64C316.4 64 308.7 65.7 297.5 76.2C286.1 86.8 273.8 104.2 262.4 128.6C242.1 172.1 227.8 231.5 224.9 296zM176.9 296C180.4 210.4 202.5 130.9 234.8 78.7C142.7 111.3 74.9 195.2 65.5 296L176.9 296zM65.5 344C74.9 444.8 142.7 528.7 234.8 561.3C202.5 509.1 180.4 429.6 176.9 344L65.5 344zM463.9 344C460.4 429.6 438.3 509.1 406 561.3C498.1 528.6 565.9 444.8 575.3 344L463.9 344zM575.3 296C565.9 195.2 498.1 111.3 406 78.7C438.3 130.9 460.4 210.4 463.9 296L575.3 296z" fill="#3c3b3b"/></svg></div>
        <div class="parque-ubicacion__details">
            <h4>Página web</h4>
            <p><a href="<?=  $datos["pagina_web"] ?>" target="_blank" aria-label="Sitio web <?=$titulo?>"><?=  $datos["pagina_web"] ?></a></p>
        </div>
    </div>
    <?php endif; ?>
    <?php if(!empty($dataNormalizada['field_1766259212093'])): ?>
    <div class="parque-ubicacion__item">
        <div class="parque-ubicacion__icon"><img src="/wp-content/uploads/2025/11/telefono.png"></div>
        <div class="parque-ubicacion__details">
            <h4>Teléfono</h4>
            <p><a href="tel:<?= $dataNormalizada['field_1766259212093'] ?>"><?= $dataNormalizada['field_1766259212093'] ?></a></p>
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
