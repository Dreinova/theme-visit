<?php

function myPostTypes()
{

    // 1. Banners principales 
    create_post_types('Banners Principales', 'Banner', 'dashicons-slides', 'banners-visit');

    // 2. Nuevo único post type para SITUR
    create_post_types('Lugares', 'Lugar', 'dashicons-location-alt', 'lugares-visit');
    create_post_types('Tipo de turismo', 'tipos', 'dashicons-location-alt', 'tipo-turismo',true,false);
    create_post_types('Pantallas', 'Pantalla', 'dashicons-location-alt', 'pantalla',true,false);

    // 3. Agenda 
    create_post_types('Agenda', 'Evento', 'dashicons-calendar-alt', 'eventos-visit');

    // 4. Recorridos
    create_post_types('Recorridos', 'Recorrido', 'dashicons-groups', 'recorridos-visit');

    //5.Paquetes
    create_post_types('Paquetes', 'Pauqete', 'dashicons-tickets', 'paquetes-visit');

    //6. Preguntas Frecuentes
    create_post_types('Preguntas Frecuentes', 'Pregunta Frecuente', 'dashicons-editor-help', 'preguntas-visit');
}

// Agregar los submenús debajo de los CPTs principales


function add_custom_submenus() {
    $submenus = array(
        array('parent' => 'lugares-visit','page_title' => 'Tipo de turismo','menu_title' => 'Tipo de turismo','capability' => 'edit_posts','menu_slug' => 'tipo-turismo'),
        array('parent' => 'lugares-visit','page_title' => 'Pantalla','menu_title' => 'Pantalla','capability' => 'edit_posts','menu_slug' => 'pantalla'),
    );
    
    // Add submenus recursively
    foreach ($submenus as $submenu) {
        add_custom_submenu_recursive($parent_menu_slug, $submenu);
    }
}

function add_custom_submenu_recursive($parent_menu_slug, $submenu) {
    add_submenu_page(
        "edit.php?post_type=".$submenu['parent'],
        $submenu['page_title'],
        $submenu['menu_title'],
        $submenu['capability'],
        "edit.php?post_type=".$submenu['menu_slug']
    );
    if (isset($submenu['submenus']) && is_array($submenu['submenus'])) {
        foreach ($submenu['submenus'] as $sub_submenu) {
            add_custom_submenu_recursive($submenu['menu_slug'], $sub_submenu);
        }
    }
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