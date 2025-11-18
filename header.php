<?php
// Redirigir si el usuario no ha iniciado sesión
if ( !is_user_logged_in() ) {
    // Redirige a la página de login de WordPress
    auth_redirect();
}
?>
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
    <header class="site-header">
  <div class="header-container">
    <div class="site-branding">
      <?php
      if (has_custom_logo()) {
          the_custom_logo();
      } else {
          echo '<a href="' . esc_url(home_url('/')) . '" class="site-title">' . get_bloginfo('name') . '</a>';
      }
      ?>
    </div>
   <nav class="main-navigation">
  <button class="menu-toggle" aria-label="Abrir menú">
    <span class="hamburger"></span>
  </button>

  <?php
  wp_nav_menu(
    array(
      'menu' => 'primary',
      'container' => '',
      'theme_location' => 'primary',
      'items_wrap' => '<ul class="menu">%3$s</ul>'
    )
  );
  ?>
</nav>

  </div>
</header>