<?php get_header(); ?>
<!-- Hero con imagen de fondo -->
<section
  class="hero hero--turismo-gastronomico"
  style="background-image: url('/wp-content/uploads/2025/11/turismo_gastronomico_bg.png')"
>
  <div class="hero__overlay"></div>
  <div class="hero__content" data-aos="fade-right">
    <div class="hero__left">
      <h1 class="hero__title">
        <span class="hero__title--red">TURISMO</span>
        <span class="hero__title--white">GASTRONÓMICO</span>
      </h1>
    </div>
  </div>
</section>

<!-- Sección de introducción -->
<section class="gastronomia-intro">
  <div class="gastronomia-intro__container">
   <?php echo apply_filters('the_content', get_post_field('post_content', $post->ID)); ?>
  </div>
</section>

<!-- Grid de restaurantes gastronómicos -->
<section class="gastronomia-grid">
  <div class="gastronomia-grid__container">
<?php

function normalize_json($value) {
    if (is_string($value)) {
        $decoded = json_decode($value, true);
        return json_last_error() === JSON_ERROR_NONE ? $decoded : [];
    }

    return is_array($value) ? $value : [];
}

// 🔹 Categorías permitidas (puedes modificarlas aquí)
$categoriasPermitidas = [
    'gastronomico',
    'gastronómico',
    'turismo_gastronomico',
    'turismo_gastronómico',
    'restaurantes',
    'bares'
];

// 🔹 Valores a buscar en el campo dinámico
$buscarCampo = [
    'gastronomico',
    'gastronómico',
    'turismo_gastronomico',
    'turismo_gastronómico'
];

$response = wp_remote_get("https://apisitur.visitatenjo.com/establecimientos/publico", [
    "headers" => [
         "X-API-KEY" => "d96e31d732b5329a5bfffaf30d8da427821693107aae19c1344eae7fe3446bd5"
    ],
    "timeout" => 20
]);

if (is_wp_error($response)) {
    echo "Error en la API: " . $response->get_error_message();
    return;
}

$body = wp_remote_retrieve_body($response);
$data = json_decode($body, true);
if (empty($data["success"]) || empty($data["data"])) {
    echo "No hay establecimientos disponibles.";
    return;
}

foreach ($data["data"] as $item) {

    $datos = normalize_json($item["datos"]);
    $dataInterna = normalize_json($datos['data'] ?? []);

    // 🔹 Campo dinámico
    $campo = $dataInterna['field_1766013834262'] ?? [];
    if (!is_array($campo)) {
        $campo = [];
    }

    $matchCampo = false;
    foreach ($campo as $valorCampo) {
        foreach ($buscarCampo as $valorBuscar) {
            if (stripos($valorCampo, $valorBuscar) !== false) {
                $matchCampo = true;
                break 2;
            }
        }
    }

    // 🔹 Categoría
    $categoria = strtolower($datos['categoria_rnt'] ?? '');
    $matchCategoria = in_array($categoria, $categoriasPermitidas, true);

    // 🔹 Validación final
    if (!$matchCampo && !$matchCategoria) {
        continue;
    }

    // 🔹 Imagen
  $img_url = 'https://placehold.co/1080x1920';

// Normalizar imagenes (puede venir como string JSON o array)
$imagenes = $item["imagenes"] ?? [];

if (is_string($imagenes)) {
    $imagenes = json_decode($imagenes, true);
}

if (is_array($imagenes) && !empty($imagenes)) {

    $primera = $imagenes[0] ?? null;

    if (!empty($primera["url_imagen"])) {
        $img_url = "https://apisitur.visitatenjo.com" . $primera["url_imagen"];
    }

} else {
   // 🔁 Fallback sistema viejo
$fotos = $datos["fotos"] ?? [];

// Si viene como string JSON → decodificar
if (is_string($fotos)) {
    $decoded = json_decode($fotos, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        $fotos = $decoded;
    }
}

// Ahora sí validar como array real
if (is_array($fotos) && !empty($fotos)) {

    foreach ($fotos as $foto) {

        // Caso 1: array con ['url' => ...]
        if (is_array($foto) && !empty($foto["url"])) {
            $img_url = $foto["url"];
            break;
        }

        // Caso 2: string directo con URL
        if (is_string($foto)) {
            $img_url = $foto;
            break;
        }
    }
}
}

    // 🔹 Nombre
    $nombre = strtoupper($datos["nombre"] ?? "SIN NOMBRE");
    $alias = sanitize_title($nombre);

    // 🔹 Render
    echo '<a href="/establecimiento/' . $alias . '/' . $item["id"] . '" class="restaurante-card">';
    echo '<img src="' . esc_url($img_url) . '" alt="' . esc_attr($nombre) . '" class="restaurante-card__image" />';
    echo '<div class="restaurante-card__overlay">';
    echo '<h3 class="restaurante-card__title">' . esc_html($nombre) . '</h3>';
    echo '</div>';
    echo '</a>';
}

?>

  </div>
</section>
<?php get_footer(); ?>
