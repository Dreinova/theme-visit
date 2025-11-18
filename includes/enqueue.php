<?php
/*
@package gamedugg
========================
ADMIN ENQUEUE FUNCTIONS
========================
*/

function gamedugg_admin_scripts($hook) {
    wp_register_style('gamedugg_admin', get_template_directory_uri() . '/css/gamedugg.admin.css', array(), '1.0.8', 'all');
    wp_enqueue_style('gamedugg_admin');
    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'gamedugg_admin_scripts');

/*
========================
FRONT-END ENQUEUE FUNCTIONS
========================
*/

function gamedugg_load_scripts() {
    // === CSS externo (AOS) ===
    wp_enqueue_style(
        'aos-css',
        'https://unpkg.com/aos@2.3.1/dist/aos.css',
        array(),
        '2.3.1'
    );

    // === JS externo (AOS) ===
    wp_enqueue_script(
        'aos-js',
        'https://unpkg.com/aos@2.3.1/dist/aos.js',
        array(), // sin dependencias
        '2.3.1',
        true // cargar al final del body
    );

    // === JS personalizado ===
    wp_enqueue_script(
        'front_script',
        get_template_directory_uri() . '/js/custom.js',
        array('aos-js'),
        '1.0.3',
        true
    );
}
add_action('wp_enqueue_scripts', 'gamedugg_load_scripts');


function bureau_enqueue_styles() {
    // Google Fonts
    wp_enqueue_style(
        'bureau-google-fonts',
        'https://fonts.googleapis.com/css2?family=Gabarito:wght@400..900&display=swap',
        false
    );

    // Estilos del tema principal
    wp_enqueue_style(
        'bureau-style',
        get_stylesheet_uri(),
        array('bureau-google-fonts', 'aos-css'), // depende del font y AOS
        filemtime(get_template_directory() . '/style.css')
    );
}
add_action('wp_enqueue_scripts', 'bureau_enqueue_styles');
