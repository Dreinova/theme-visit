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

function gamedugg_load_assets() {

    // CSS
    wp_enqueue_style(
        'splide-css',
        'https://cdn.jsdelivr.net/npm/@splidejs/splide@4/dist/css/splide.min.css',
        [],
        null
    );

    wp_enqueue_style(
        'aos-css',
        'https://unpkg.com/aos@2.3.1/dist/aos.css',
        [],
        null
    );

    wp_enqueue_style(
        'bureau-google-fonts',
        'https://fonts.googleapis.com/css2?family=Gabarito:wght@400..900&display=swap',
        [],
        null
    );

    wp_enqueue_style(
        'bureau-style',
        get_stylesheet_uri(),
        ['bureau-google-fonts','aos-css'],
        filemtime(get_template_directory() . '/style.css')
    );


    // JS
    wp_enqueue_script(
        'splide-js',
        'https://cdn.jsdelivr.net/npm/@splidejs/splide@4/dist/js/splide.min.js',
        [],
        null,
        true
    );

    wp_enqueue_script(
        'splide-auto-scroll-js',
        'https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-auto-scroll@0.5.3/dist/js/splide-extension-auto-scroll.min.js',
        ['splide-js'],
        null,
        true
    );

    wp_enqueue_script(
        'aos-js',
        'https://unpkg.com/aos@2.3.1/dist/aos.js',
        [],
        null,
        true
    );

    wp_enqueue_script(
        'front-script',
        get_template_directory_uri() . '/js/custom.js',
        ['aos-js','splide-js','splide-auto-scroll-js'],
        filemtime(get_template_directory() . '/js/custom.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'gamedugg_load_assets');
