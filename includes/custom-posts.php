<?php

function myPostTypes(){
    create_post_types('Banners Principales', 'Banner', 'dashicons-slides', 'banners-visit');
    create_post_types('Imperdibles', 'Imperdible', 'dashicons-admin-multisite', 'imperdibles-visit');
    create_post_types('Qué hacer?', 'Hacer', 'dashicons-art', 'hacer-visit');
    create_post_types('Dónde comer?', 'Comer', 'dashicons-food', 'comer-visit');
    create_post_types('Dónde dormir?', 'Dormir', 'dashicons-admin-home', 'dormir-visit');
    create_post_types('Agenda', 'Evento', 'dashicons-calendar-alt', 'eventos-visit');
}

function create_post_types($name, $singularName, $icon, $slug, $showUI = true, $show_in_menu = true)
{
    register_post_type($slug, array(
        'exclude_from_search' => true,
        'has_archive' => false,
        'rest_controller_class' => 'WP_REST_Posts_Controller',
        'rest_base' => $slug,
        'labels' => array(
            'name' => ($name),
            'singular_name' => ($singularName),
            'add_new' => ('Agregar ' . $singularName),
            'add_new_item' => ('Agregar ' . $singularName),
            'edit_item' => ('Editar ' . $singularName),
            'new_item' => ('Agregar ' . $singularName),
            'view_item' => ('Ver ' . $singularName),
            'not_found' => ('No se encontraron ' . $name)
        ),
        'menu_icon' => $icon,
        'public' => true,
        'publicly_queryable' => true,
        'show_in_rest' => true,
        'hierarchical' => false,
        'show_ui' => $showUI,
        'show_in_menu' => $show_in_menu,
        'capability_type' => 'post',
        'rewrite' => array('slug' => $slug),
        'rest_controller_class' => 'WP_REST_Posts_Controller',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions'),
    ));
}

// Agregar los submenús debajo de los CPTs principales
function add_custom_submenus()
{
    // add_submenu_page(
    //     'edit.php?post_type=services', // Parent: Servicios
    //     'Atributos Servicio', // Título de página
    //     'Atributos Servicio', // Título del menú
    //     'manage_options',
    //     'edit.php?post_type=atserv-bcct' // Slug del post type
    // );
}

add_action('init', 'myPostTypes');
add_action('admin_menu', 'add_custom_submenus');

// Registrar taxonomía exclusiva para Noticias
// function create_noticias_taxonomy() {
//     $labels = array(
//         'name'              => 'Categorías de Noticias',
//         'singular_name'     => 'Categoría de Noticia',
//         'search_items'      => 'Buscar Categorías',
//         'all_items'         => 'Todas las Categorías',
//         'parent_item'       => 'Categoría superior',
//         'parent_item_colon' => 'Categoría superior:',
//         'edit_item'         => 'Editar Categoría',
//         'update_item'       => 'Actualizar Categoría',
//         'add_new_item'      => 'Agregar nueva Categoría',
//         'new_item_name'     => 'Nombre de nueva Categoría',
//         'menu_name'         => 'Categorías',
//     );

//     $args = array(
//         'hierarchical'      => true, // como las categorías (si fuera false, serían como etiquetas)
//         'labels'            => $labels,
//         'show_ui'           => true,
//         'show_admin_column' => true,
//         'show_in_rest'      => true, // para que funcione con el editor de bloques
//         'query_var'         => true,
//         'rewrite'           => array('slug' => 'categoria-noticia'),
//     );

//     register_taxonomy('categoria-noticia', array('noticias-bureau'), $args);
// }
// add_action('init', 'create_noticias_taxonomy');