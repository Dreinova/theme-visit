<?php
/*
Template Name: Página de FAQ
*/
$args = array(
    'post_type'      => 'eventos-visit',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
);

$events_query = new WP_Query($args);
if ($events_query->have_posts()) :
?>
<?php get_header(); ?>
<!-- Hero con imagen de fondo -->
    <section
      class="hero hero--agenda"
      style="background-image: url('/wp-content/uploads/2025/11/juegos-bg.png')"
    >
      <div class="hero__overlay"></div>
      <div class="hero__content">
        <div class="hero__left">
          <h1 class="hero__title">
            <span class="hero__title--red">AGENDA</span>
            <span class="hero__title--white">DE EVENTOS</span>
          </h1>
        </div>
      </div>
    </section>

    <!-- Filtros de búsqueda -->
    <section class="filtros-eventos">
      <div class="filtros-eventos__container">
        <!-- Buscar -->
        <div class="filtros-eventos__group">
          <label for="buscar" class="filtros-eventos__label">Buscar</label>
          <input
            type="text"
            id="buscar"
            class="filtros-eventos__input"
            placeholder="Buscar eventos..."
          />
        </div>

        <!-- Categoría del evento -->
        <div class="filtros-eventos__group">
          <label for="categoria" class="filtros-eventos__label"
            >Categoría del evento</label
          >
          <select id="categoria" class="filtros-eventos__select">
            <option value="">Seleccione una opción</option>
            <option value="Cultural">Cultural</option>
            <option value="Música y entretenimiento">Música y entretenimiento</option>
            <option value="Turismo y naturaleza">Turismo y naturaleza</option>
            <option value="Gastronómico">Gastronómico</option>
            <option value="Familia y comunidad">Familia y comunidad</option>
            <option value="Evento especial">Evento especial</option>
            <option value="Patrimonio y tradición">Patrimonio y tradición</option>
            <option value="Deportivo y recreativo">Deportivo y recreativo</option>
            <option value="Educativo">Educativo</option>
            <option value="Pet Friendly">Pet Friendly</option>
          </select>
        </div>

        <!-- Seleccionar fecha desde -->
        <div class="filtros-eventos__group">
          <label for="fecha-desde" class="filtros-eventos__label"
            >Seleccionar fecha desde</label
          >
          <input
            type="date"
            id="fecha-desde"
            class="filtros-eventos__input filtros-eventos__input--date"
          />
        </div>

        <!-- Seleccionar fecha hasta -->
        <div class="filtros-eventos__group">
          <label for="fecha-hasta" class="filtros-eventos__label"
            >Seleccionar fecha hasta</label
          >
          <input
            type="date"
            id="fecha-hasta"
            class="filtros-eventos__input filtros-eventos__input--date"
          />
        </div>
      </div>
    </section>
    

    <!-- Sección de eventos -->
    <section class="agenda-eventos">
      <div class="agenda-eventos__container">
        <!-- Fila 1 de eventos -->
        <div class="agenda-eventos__row">
          

<?php while ($events_query->have_posts()) : $events_query->the_post(); ?>

    <?php
    // Campos principales
    $title       = get_the_title();
    $content     = get_the_content();
    $image       = get_the_post_thumbnail_url();
    $tipo_values = get_field('tipo_de_evento');

    $tipo = "";
    if (!empty($tipo_values) && is_array($tipo_values)) {
        $tipo = implode(", ", $tipo_values);
    }


    $descripcion = get_field('descripcion');
    $fecha       = get_field('fecha');        // formato: 2025-08-20
    $hora        = get_field('hora');         // Ej: 8:00 p.m. a 5:00 a.m.
    $direccion   = get_field('direccion');
    $link        = get_permalink();

    // Formatos de fecha
    $timestamp   = strtotime($fecha);
    $mes         = date_i18n('M', $timestamp); // Ago, Sep, Ene...
    $dia         = date('d', $timestamp);
    ?>

    <article class="evento-card" data-fecha="<?= esc_attr($fecha); ?>"
  data-titulo="<?= esc_attr(strtolower($title)); ?>"
  data-tipo="<?= esc_attr(strtolower($tipo)); ?>"
    >

        <div class="evento-card__image">
            <img src="<?= esc_url($image); ?>" alt="<?= esc_attr($title); ?>" />

            <div class="evento-card__date">
                <span class="evento-card__month"><?= $mes; ?></span>
                <span class="evento-card__day"><?= $dia; ?></span>
            </div>
        </div>

        <div class="evento-card__content">

            <span class="evento-card__category"><?= esc_html($tipo); ?></span>


            <h3 class="evento-card__title"><?= esc_html($title); ?></h3>

            <?php if ($hora): ?>
            <div class="evento-card__time">
                <img src="https://visitatenjo.com/wp-content/uploads/2025/11/reloj.png" alt="Hora" class="evento-card__time-icon" />
                <span><?= esc_html($hora); ?></span>
            </div>
            <?php endif; ?>

            <a href="<?= esc_url($link); ?>" class="evento-card__btn">Conoce más</a>

        </div>

    </article>

<?php endwhile; ?>

        </div>
      </div>
    </section>
<?php
    endif;
    wp_reset_postdata();
?>
</div>
  
<script>
document.addEventListener("DOMContentLoaded", () => {
  const searchInput = document.getElementById("buscar");
  const categorySelect = document.getElementById("categoria");
  const fechaDesde = document.getElementById("fecha-desde");
  const fechaHasta = document.getElementById("fecha-hasta");
  const eventos = document.querySelectorAll(".evento-card");

  const filtrarEventos = () => {
    const texto = searchInput.value.toLowerCase().trim();
    const categoria = categorySelect.value.toLowerCase().trim();
    const desde = fechaDesde.value ? new Date(fechaDesde.value) : null;
    const hasta = fechaHasta.value ? new Date(fechaHasta.value) : null;

    eventos.forEach(evento => {
      const titulo = evento.dataset.titulo;
      const tipo = evento.dataset.tipo;
      const fecha = new Date(evento.dataset.fecha);

      let mostrar = true;

      if (texto && !titulo.includes(texto)) mostrar = false;
      if (categoria && !tipo.includes(categoria)) mostrar = false;
      if (desde && fecha < desde) mostrar = false;
      if (hasta && fecha > hasta) mostrar = false;

      if (mostrar) {
        evento.classList.remove("hide");
      } else {
        evento.classList.add("hide");
      }
    });
  };

  searchInput.addEventListener("input", filtrarEventos);
  categorySelect.addEventListener("change", filtrarEventos);
  fechaDesde.addEventListener("change", filtrarEventos);
  fechaHasta.addEventListener("change", filtrarEventos);
});
</script>


<?php get_footer(); ?>

