<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta charset="<?php bloginfo('charset'); ?>">
  <?php if (is_singular() && pings_open(get_queried_object())): ?>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
  <?php endif; ?>
  <?php wp_head(); ?>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const header = document.querySelector(".header");

      if (!header) return;

      window.addEventListener("scroll", function () {
        if (window.scrollY > 90) {
          header.classList.add("is-scrolled");
        } else {
          header.classList.remove("is-scrolled");
        }
      });
    });
  </script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KHQ9TBWZ');</script>
<!-- End Google Tag Manager -->
</head>

<body <?php body_class(); ?>>
  <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KHQ9TBWZ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
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
          <?php
          wp_nav_menu(array(
            'theme_location' => 'primary',
            'container' => false,
            'menu_class' => 'header__menu', // ul
            'items_wrap' => '<ul class="%2$s">%3$s</ul>', // usa tu clase
            'fallback_cb' => false
          ));
          ?>
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