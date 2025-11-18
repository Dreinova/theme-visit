<?php
/*
Template Name: Página de About
*/
get_header(); ?>
<div
  class="page-content <?php echo 'page-' . get_post_field('post_name', get_post()); ?>"
>
  <?php get_template_part( 'template-parts/section', 'banner' ); ?>
  <div class="description">
    <?php get_template_part( 'template-parts/section', 'videos', array( 'category' => 'acerca-de' )  ); ?>
    <?php $description = get_the_content($post->ID); ?>
    <?= $description ?>
  </div>
  <section class="section-enfoque">
    <div class="enfoque-top">
      <div class="left">
<?php get_template_part( 'template-parts/section', 'videos', array( 'category' => 'nuestro-enfoque' )  ); ?>
      </div>
      <div class="right">
        <h2>Nuestro <strong>enfoque</strong></h2>
        <div class="enfoque-items">
          <div class="enfoque-item">
            <h3>Captación</h3>
            <p>Atracción de eventos de talla mundial a Bogotá</p>
          </div>
          <div class="enfoque-item">
            <h3>Apoyo</h3>
            <p>Apoyo a eventos que ya eligieron Bogotá como sede</p>
          </div>
        </div>
        <a href="#" class="btn-negro">Haz tu evento en Bogotá</a>
      </div>
    </div>

    <div class="enfoque-bottom">
      <div class="enfoque-texto">
        <h3>Lo que Bureau de Convenciones <strong>hace por ti:</strong></h3>
        <ul>
          <li><strong>Asesoría experta:</strong> inteligencia de destino, apoyo a candidaturas, visitas de inspección entre otros.</li>
          <li>
            <strong>Conexión y beneficios:</strong> red de aliados, beneficios no tributarios, tarifas preferentes.</li>
          <li><strong>Impacto y legado:</strong> sostenibilidad, medición/compensación, programas sociales.
          </li>
          <li>Actuamos con total confidencialidad y compromiso en cada etapa del proceso.</li>
        </ul>
      </div>
      <div class="enfoque-imagen">
        <?php get_template_part( 'template-parts/section', 'videos', array( 'category' => 'hace-por-ti' )  ); ?>
      </div>
    </div>
  </section>

  <?php get_template_part( 'template-parts/section', 'team' ); ?>
</div>

<?php get_footer(); ?>
