<?php
get_header();

$imagen_fondo = get_field('imagen_banner');
$titulo = get_the_title();
$palabra_resaltada = get_field('palabra_resaltada');

// Quitar la palabra resaltada del título
$titulo_sin_resaltar = str_replace($palabra_resaltada, '', $titulo);
$titulo_sin_resaltar = trim($titulo_sin_resaltar);

// Campos ACF del evento
$fecha_evento = get_field('fecha');
$hora_evento = get_field('hora');
$direccion = get_field('direccion');
$correo = get_field('correo');
$telefono = get_field('telefono');
$whatsapp = get_field('whatsapp');

// Formatear fecha del evento
$fecha_legible = '';
if (!empty($fecha_evento)) {
    if (preg_match('/^\d{8}$/', $fecha_evento)) {
        $date_obj = DateTime::createFromFormat('Ymd', $fecha_evento);
        if ($date_obj) {
            $fecha_legible = date_i18n('l d \\d\\e F \\d\\e Y', $date_obj->getTimestamp());
        }
    } else {
        $timestamp = strtotime($fecha_evento);
        if ($timestamp) {
            $fecha_legible = date_i18n('l d \\d\\e F \\d\\e Y', $timestamp);
        }
    }
}

// Galería
$imagenes = [];
for ($i = 1; $i <= 10; $i++) {
    $img = get_field("imagen_$i");
    if ($img) {
        $imagenes[] = $img;
    }
}
?>

<!-- Hero con imagen de fondo -->
<section class="hero hero--parque-tenjo" style="background-image: url('<?= esc_url($imagen_fondo); ?>');">
  <div class="hero__overlay"></div>
  <div class="hero__content" data-aos="fade-right">
    <div class="hero__left">
      <h1 class="hero__title">
        <?php if (!empty($palabra_resaltada)): ?>
          <span class="hero__title--red"><?= esc_html($palabra_resaltada); ?></span>
        <?php endif; ?>
        <span class="hero__title--white"><?= esc_html($titulo_sin_resaltar ?: $titulo); ?></span>
      </h1>
    </div>
  </div>
</section>

<?php if (!empty($imagenes)): ?>
<!-- Sección de galería con imagen principal y thumbnails -->
<section class="parque-galeria" data-aos="fade-down">
  <div class="parque-galeria__container">

    <!-- Imagen principal -->
    <div class="parque-galeria__main">
      <img
        src="<?= esc_url($imagenes[0]['url']); ?>"
        alt="<?= esc_attr($imagenes[0]['alt'] ?: $titulo); ?>"
        class="parque-galeria__main-image"
        id="mainImage" />
    </div>

    <!-- Thumbnails -->
    <div class="parque-galeria__thumbnails">
      <?php foreach ($imagenes as $img): ?>
        <button
          class="parque-galeria__thumbnail"
          type="button"
          onclick="changeImage('<?= esc_url($img['url']); ?>')">
          <img
            src="<?= esc_url($img['sizes']['thumbnail'] ?? $img['url']); ?>"
            alt="<?= esc_attr($img['alt'] ?: $titulo); ?>" />
        </button>
      <?php endforeach; ?>
    </div>

  </div>

  <?php if (get_the_content()): ?>
    <div class="parque-galeria__description" data-aos="zoom-in" style="max-width: 768px; margin: 50px auto 0 auto;">
      <?= apply_filters('the_content', get_the_content()); ?>
    </div>
  <?php endif; ?>
</section>
<?php elseif (get_the_content()): ?>
<section class="parque-galeria" data-aos="fade-down">
  <div class="parque-galeria__description" data-aos="zoom-in" style="max-width: 768px; margin: 50px auto;">
    <?= apply_filters('the_content', get_the_content()); ?>
  </div>
</section>
<?php endif; ?>

<!-- Sección de mapa e información -->
<section class="parque-ubicacion">
  <div class="parque-ubicacion__container">

    <!-- Mapa -->
    <div class="parque-ubicacion__mapa" data-aos="fade-right">
      <?php
      $titulo_mapa = $titulo_sin_resaltar ?: $titulo;

      if (!empty($direccion) && trim($direccion) !== '') {
          $busqueda_completa = $titulo_mapa . ', ' . $direccion;
      } else {
          $busqueda_completa = $titulo_mapa . ', Tenjo, Cundinamarca';
      }

      $busqueda_encoded = urlencode($busqueda_completa);
      $map_url = "https://www.google.com/maps?q=" . $busqueda_encoded . "&output=embed";
      ?>
      <iframe
        src="<?= esc_url($map_url); ?>"
        width="100%"
        height="100%"
        style="border: 0"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>

    <!-- Información -->
    <div class="parque-ubicacion__info" data-aos="fade-left">

      <?php if (!empty($fecha_legible)): ?>
        <div class="parque-ubicacion__item">
          <div class="parque-ubicacion__icon">
            <img src="/wp-content/uploads/2025/11/reloj.png" alt="icono de calendario" />
          </div>
          <div class="parque-ubicacion__details">
            <h4>Fecha del evento</h4>
            <p><?= esc_html($fecha_legible); ?></p>
          </div>
        </div>
      <?php endif; ?>

      <div class="parque-ubicacion__item">
        <div class="parque-ubicacion__icon">
          <img src="/wp-content/uploads/2025/11/reloj.png" alt="icono de horario" />
        </div>
        <div class="parque-ubicacion__details">
          <h4>Horario del evento</h4>
          <p>
            <?php
            if (!empty($hora_evento) && trim($hora_evento) !== '') {
                echo esc_html($hora_evento);
            } else {
                echo 'Por ser anunciados';
            }
            ?>
          </p>
        </div>
      </div>

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

      <div class="parque-ubicacion__item">
        <div class="parque-ubicacion__icon">
          <img src="/wp-content/uploads/2025/11/ubicacion.png" alt="icono de ubicación" />
        </div>
        <div class="parque-ubicacion__details">
          <h4>Dirección</h4>
          <p><?= !empty($direccion) ? esc_html($direccion) : 'Tenjo, Cundinamarca'; ?></p>
        </div>
      </div>

    </div>
  </div>
</section>

<script>
  function changeImage(newSrc) {
    const mainImage = document.getElementById("mainImage");
    if (!mainImage) return;

    mainImage.style.opacity = "0";
    setTimeout(() => {
      mainImage.src = newSrc;
      mainImage.style.opacity = "1";
    }, 200);
  }
</script>

<?php get_footer(); ?>