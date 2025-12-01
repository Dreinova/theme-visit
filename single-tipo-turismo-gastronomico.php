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

            // --- Traer imágenes ---
            $img_response = wp_remote_get("https://apisitur.visitatenjo.com/imagenes/por-est/" . $item["id"], [
                "headers" => [
                    "X-API-KEY" => "d96e31d732b5329a5bfffaf30d8da427821693107aae19c1344eae7fe3446bd5"
                ],
                "timeout" => 20
            ]);

            $img_url = 'https://placehold.co/1080x1920';
            if (!is_wp_error($img_response)) {
                $img_data = json_decode(wp_remote_retrieve_body($img_response), true);
                if ($img_data["success"] && !empty($img_data["data"])) {
                    $img_url = $img_data["data"][0]["url_imagen"]; // Primera imagen
                    // Quitar "/api-situr" si existe y anteponer dominio
                    $img_url = preg_replace('#^/api-situr#', '', $img_url);
                    $img_url = 'https://apisitur.visitatenjo.com' . $img_url;
                }
            }

            // Nombre a mostrar en el overlay
            $nombre = strtoupper($datos["subcategoria_rnt"] ?? "SIN NOMBRE");

            echo '<a href="/establecimiento/' . $item["id"] . '" class="restaurante-card">';
            if ($img_url) {
                echo '<img src="' . esc_url($img_url) . '" alt="' . esc_attr($nombre) . '" class="restaurante-card__image" />';
            }
            echo '<div class="restaurante-card__overlay">';
            echo '<h3 class="restaurante-card__title">' . $nombre . '</h3>';
            echo '</div>';
            echo '</a>';
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
