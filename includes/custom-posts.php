<?php

function myPostTypes()
{

    // 1. Banners principales 
    create_post_types('Banners Principales', 'Banner', 'dashicons-slides', 'banners-visit');

    // 2. Nuevo único post type para SITUR
    create_post_types('Lugares', 'Lugar', 'dashicons-location-alt', 'lugares-visit');

    // 3. Agenda 
    create_post_types('Agenda', 'Evento', 'dashicons-calendar-alt', 'eventos-visit');

    // 4. Recorridos
    create_post_types('Recorridos', 'Recorrido', 'dashicons-groups', 'recorridos-visit');

    //5.Paquetes
    create_post_types('Paquetes', 'Pauqete', 'dashicons-tickets', 'paquetes-visit');

    //6. Preguntas Frecuentes
    create_post_types('Preguntas Frecuentes', 'Pregunta Frecuente', 'dashicons-editor-help', 'preguntas-visit');

    // ============================
    // TAXONOMÍAS PARA EL CPT SITUR
    // ============================

    // Tipo de turismo
    register_taxonomy('tipo_turismo', 'lugares-visit', array(
        'label' => 'Tipo de Turismo',
        'hierarchical' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'tipo-turismo')
    ));

    // Categoría funcional
    register_taxonomy('categoria_funcional', 'lugares-visit', array(
        'label' => 'Categoría funcional',
        'hierarchical' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'categoria')
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

