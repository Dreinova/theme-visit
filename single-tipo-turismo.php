<?php 
get_header(); 
$imagen_fondo      = get_field('imagen_banner');
$titulo             = get_the_title(); // Texto completo
$palabra_resaltada  = get_field('palabra_resaltada');
$id_relacion  = get_field('id_relacion');

// Quitar la palabra resaltada del título
$titulo_sin_resaltar = str_replace($palabra_resaltada, '', $titulo);
$titulo_sin_resaltar = trim($titulo_sin_resaltar); // Limpia espacios dobles

?>

 <!-- Hero con imagen de fondo -->
    <section
      class="hero hero--turismo-cultural"
      style="background-image: url(<?=$imagen_fondo?>)"
    >
      <div class="hero__overlay"></div>
      <div class="hero__content" data-aos="fade-right">
        <div class="hero__left">
          <h1 class="hero__title">
    <span class="hero__title--red">Turismo</span>
    <span class="hero__title--white"><?= $titulo_sin_resaltar ?></span>
</h1>

        </div>
      </div>
    </section>

    <!-- Sección de introducción -->
    <section class="turismo-intro">
      <div class="turismo-intro__container">
        <?=get_the_content()?>
      </div>
    </section>
<?php $valor_turismo = $id_relacion ?? null; ?>
    
<!-- Grid de restaurantes gastronómicos -->
<section class="gastronomia-grid">
  <div class="gastronomia-grid__container">
   <?php
$response = wp_remote_get("https://apisitur.visitatenjo.com/establecimientos/aprobados", [
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
            $datos     = is_string($item["datos"]) ? (json_decode($item["datos"], true) ?: []) : ($item["datos"] ?? []);
            $datosData = is_string($datos['data'] ?? null) ? (json_decode($datos['data'], true) ?: []) : ($datos['data'] ?? []);

           if (isset($datosData['field_1766013834262'])) {

            if( $valor_turismo &&
    isset($datosData['field_1766013834262']) &&
    is_array($datosData['field_1766013834262']) &&
    in_array($valor_turismo, $datosData['field_1766013834262'], true)){
              // --- Traer imágenes desde $datos['fotos'] ---
             $img_url = 'https://placehold.co/1080x1920';
            $imagenes_api = $item["imagenes"] ?? [];
            if (is_string($imagenes_api)) $imagenes_api = json_decode($imagenes_api, true);
            if (!empty($imagenes_api[0]["url_imagen"])) {
                $img_url = "https://apisitur.visitatenjo.com" . $imagenes_api[0]["url_imagen"];
            } else {
                $fotos = is_array($datos["fotos"]) ? $datos["fotos"] : (json_decode($datos["fotos"] ?? '[]', true) ?: []);
                foreach ($fotos as $foto) {
                    if (is_array($foto) && !empty($foto["url"])) { $img_url = $foto["url"]; break; }
                    if (is_string($foto) && $foto)               { $img_url = $foto; break; }
                }
            }
    
              // Nombre a mostrar en el overlay
              $nombre = strtoupper($datos["nombre"] ?? "SIN NOMBRE");
                                    $alias = sanitize_title($nombre);
                  echo '<a href="/establecimiento/' . $alias  .'/' . $item["id"] . '" class="restaurante-card">';
                  echo '<img src="' . esc_url($img_url) . '" alt="' . esc_attr($nombre) . '" class="restaurante-card__image" />';
                  echo '<div class="restaurante-card__overlay">';
                  echo '<h3 class="restaurante-card__title">' . $nombre . '</h3>';
                  echo '</div>';
                  echo '</a>';
            }
          }

        }
    } else {?>
  

    <?php
        echo "No hay establecimientos disponibles.";
    }
} else {
    echo "Error en la API: " . $response->get_error_message();
}
?>

  </div>
</section>
   <section class="situr-banner">
  <div class="situr-banner__content">
    <h2 class="situr-banner__title">
      ¿Quieres ver aquí tu establecimiento?
    </h2>
    <p class="situr-banner__text">
       <strong>Visitatenjo.com</strong> muestra los establecimientos turísticos de Tenjo pertenecientes al Sistema de Información Turística SITUR del municpio."  ¿Quieres ver aquí tu establecimiento? Registralo en minutos a través de
    </p>
    <a href="https://situr.visitatenjo.com" target="_blank" class="situr-banner__button">
      Regístralo en minutos
    </a>
  </div>
</section>

<?php get_footer(); ?>
