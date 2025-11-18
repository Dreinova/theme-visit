<?php

function myPostTypes(){

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
    register_taxonomy('tipo_turismo', 'lugares', array(
        'label' => 'Tipo de Turismo',
        'hierarchical' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'tipo-turismo')
    ));

    // Categoría funcional (Qué hacer, Dónde comer, etc.)
    register_taxonomy('categoria_funcional', 'lugares', array(
        'label' => 'Categoría funcional',
        'hierarchical' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'categoria')
    ));
}

function create_post_types($name, $singularName, $icon, $slug){
    register_post_type($slug, array(
        'labels' => array(
            'name' => $name,
            'singular_name' => $singularName,
        ),
        'menu_icon' => $icon,
        'public' => true,
        'show_in_rest' => true,
        'supports' => array('title','editor','thumbnail','excerpt'),
        'rewrite' => array('slug'=>$slug)
    ));
}

add_action('init', 'myPostTypes');

