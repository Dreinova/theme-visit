
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="<?php bloginfo('charset'); ?>">
    <?php if (is_singular() && pings_open(get_queried_object())) : ?>
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php endif; ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
      <!-- Header estático -->
    <header class="header">
      <div class="header__container">
        <div class="header__content">
          <!-- Logo -->
          <?php
          if (has_custom_logo()) {
              the_custom_logo();
          } else {
              echo '<a href="' . esc_url(home_url('/')) . '" class="site-title">' . get_bloginfo('name') . '</a>';
          }
          ?>

          <!-- Menú de navegación -->
          <nav class="header__nav">
            <ul class="header__menu">
              <li class="header__menu-item">
                <a href="#" class="header__menu-link">Qué hacer en tenjo</a>
              </li>
              <li class="header__menu-item">
                <a href="#" class="header__menu-link">Donde dormir</a>
              </li>
              <li class="header__menu-item">
                <a href="#" class="header__menu-link">Donde comer</a>
              </li>
              <li class="header__menu-item">
                <a href="agenda.html" class="header__menu-link"
                  >Agenda de eventos</a
                >
              </li>
              <li class="header__menu-item">
                <a href="faq.html" class="header__menu-link"
                  >Preguntas frecuentes</a
                >
              </li>
            </ul>
          </nav>

          <!-- Botón menú móvil (hamburguesa) -->
          <button class="header__toggle" aria-label="Abrir menú">
            <span class="header__toggle-line"></span>
            <span class="header__toggle-line"></span>
            <span class="header__toggle-line"></span>
          </button>

          <!-- Línea horizontal (debajo del logo hasta el final del menú) -->
          <div class="header__line"></div>
        </div>
      </div>
    </header>
