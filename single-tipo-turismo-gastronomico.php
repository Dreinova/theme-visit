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
   <?php $description = get_the_content($post->ID); ?>
            <?= $description ?>
  </div>
</section>

<!-- Grid de restaurantes gastronómicos -->
<section class="gastronomia-grid">
  <div class="gastronomia-grid__container">
   <?php
$response = wp_remote_get("https://apisitur.visitatenjo.com/establecimientos/publico", [
    "headers" => [
        "X-API-KEY" => "d96e31d732b5329a5bfffaf30d8da427821693107aae19c1344eae7fe3446bd5"
    ],
    "timeout" => 20
]);

if (!is_wp_error($response)) {
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if ($data["success"] && !empty($data["data"])) {
        foreach ($data["data"] as $item) {
            $datos = json_decode($item["datos"], true);
           if (isset($datos['data']['field_1766013834262']) || $datos['categoria_rnt'] == 'restaurantes' || $datos["categoria_rnt"] == "bares") {
            if($datos['data']['field_1766013834262'][0] == 'turismo_gastronómico'){
              // --- Traer imágenes desde $datos['fotos'] ---
              $img_url = 'https://placehold.co/1080x1920'; // fallback
              if (!empty($datos["fotos"])) {
                  foreach ($datos["fotos"] as $foto) {
                      if ($foto) {
                          $img_url = $foto; // tomar la primera imagen no nula
                          break;
                      }
                  }
              }
    
              // Nombre a mostrar en el overlay
              $nombre = strtoupper($datos["nombre"] ?? "SIN NOMBRE");
                  echo '<a href="/establecimiento/' . $item["id"] . '" class="restaurante-card">';
                  echo '<img src="' . esc_url($img_url) . '" alt="' . esc_attr($nombre) . '" class="restaurante-card__image" />';
                  echo '<div class="restaurante-card__overlay">';
                  echo '<h3 class="restaurante-card__title">' . $nombre . '</h3>';
                  echo '</div>';
                  echo '</a>';
            }
          }

        }
    } else {
        echo "No hay establecimientos disponibles.";
    }
} else {
    echo "Error en la API: " . $response->get_error_message();
}
?>

  </div>
</section>
<?php get_footer(); ?>
