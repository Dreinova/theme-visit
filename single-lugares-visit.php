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
<section class="hero hero--parque-tenjo" style="
    background-image: url('<?= $imagen_fondo ?>');
  ">
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
<?php
$imagenes = [];

for ($i = 1; $i <= 10; $i++) {
  $img = get_field("imagen_$i");
  if ($img) {
    $imagenes[] = $img;
  }
}
?>

<!-- Sección de galería con imagen principal y thumbnails -->
<section class="parque-galeria" data-aos="fade-down">
  <div class="parque-galeria__container">

    <!-- Imagen principal -->
    <div class="parque-galeria__main">
      <img src="<?= esc_url($imagenes[0]['url']) ?>" alt="<?= esc_attr($imagenes[0]['alt']) ?>"
        class="parque-galeria__main-image" id="mainImage" />

    </div>

    <!-- Thumbnails -->
    <div class="parque-galeria__thumbnails">
      <?php foreach ($imagenes as $img): ?>
        <button class="parque-galeria__thumbnail" onclick="changeImage('<?= esc_url($img['url']) ?>')">
          <img src="<?= esc_url($img['sizes']['thumbnail']) ?>" alt="<?= esc_attr($img['alt']) ?>" />
        </button>
      <?php endforeach; ?>
    </div>

  </div>
  <div class="parque-galeria__description" data-aos="zoom-in" style="
    max-width: 768px;
    margin: 50px auto 0 auto;
">
    <?= get_the_content() ?>
  </div>
</section>


<!-- Sección de mapa y contacto -->
<section class="parque-ubicacion">
  <div class="parque-ubicacion__container">
    <!-- Mapa -->
    <div class="parque-ubicacion__mapa" data-aos="fade-right">
      <?php
      $direccion = get_field("direccion");
      $titulo = $titulo_sin_resaltar;

      // Verificar si existe la dirección
      if (!empty($direccion) && trim($direccion) != '') {
        // Si existe dirección, combinar con el título
        $busqueda_completa = $titulo . ", " . $direccion;
      } else {
        // Si no existe dirección, usar ubicación genérica
        $busqueda_completa = $titulo . ", Tenjo, Cundinamarca";
      }

      // Codificar la búsqueda completa para URL
      $busqueda_encoded = urlencode($busqueda_completa);

      // Crear URL de Google Maps embed
      $map_url = "https://www.google.com/maps?q=" . $busqueda_encoded . "&output=embed";
      ?>
      <iframe src="<?= $map_url ?>" width="100%" height="100%" style="border: 0" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
    <?php
      $horario   = get_field('horario');
      $correo    = get_field('correo');
      $telefono  = get_field('telefono');
      $whatsapp  = get_field('whatsapp');
      $direccion = !empty($direccion) ? $direccion : get_field('direccion');
    ?>


    <!-- Información de contacto -->
    <?php if ($horario || $correo || $telefono || $whatsapp || $direccion): ?>
<div class="parque-ubicacion__info" data-aos="fade-left">

  <?php if (!empty($horario)): ?>
  <div class="parque-ubicacion__item">
    <div class="parque-ubicacion__icon">
      <img src="/wp-content/uploads/2025/11/reloj.png" alt="icono de horario" />
    </div>
    <div class="parque-ubicacion__details">
      <h4>Horario</h4>
      <p><?= esc_html($horario); ?></p>
    </div>
  </div>
  <?php endif; ?>

  <?php if (!empty($correo)): ?>
  <div class="parque-ubicacion__item">
    <div class="parque-ubicacion__icon">
      <img src="/wp-content/uploads/2025/11/email.png" alt="icono de correo" />
    </div>
    <div class="parque-ubicacion__details">
      <h4>Correo</h4>
      <p><a href="mailto:<?= esc_attr($correo); ?>"><?= esc_html($correo); ?></a></p>
    </div>
  </div>
  <?php endif; ?>

  <?php if (!empty($telefono)): ?>
  <div class="parque-ubicacion__item">
    <div class="parque-ubicacion__icon">
      <img src="/wp-content/uploads/2025/11/telefono.png" alt="icono de teléfono" />
    </div>
    <div class="parque-ubicacion__details">
      <h4>Teléfono</h4>
      <p><a href="tel:<?= esc_attr($telefono); ?>"><?= esc_html($telefono); ?></a></p>
    </div>
  </div>
  <?php endif; ?>

  <?php if (!empty($whatsapp)): ?>
  <div class="parque-ubicacion__item">
    <div class="parque-ubicacion__icon">
      <img src="/wp-content/uploads/2025/11/whatsapp.png" alt="icono de whatsapp" />
    </div>
    <div class="parque-ubicacion__details">
      <h4>WhatsApp</h4>
      <p><?= esc_html($whatsapp); ?></p>
    </div>
  </div>
  <?php endif; ?>

  <?php if (!empty($direccion)): ?>
  <div class="parque-ubicacion__item">
    <div class="parque-ubicacion__icon">
      <img src="/wp-content/uploads/2025/11/ubicacion.png" alt="icono de ubicación" />
    </div>
    <div class="parque-ubicacion__details">
      <h4>Dirección</h4>
      <p><?= esc_html($direccion); ?></p>
    </div>
  </div>
  <?php endif; ?>

</div>
<?php endif; ?>

  </div>
</section>
<script>
  // Función para cambiar la imagen principal
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