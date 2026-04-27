<?php

/**
 * situr-helpers.php
 * Funciones compartidas para consultar y renderizar establecimientos SITUR.
 * Incluir desde functions.php con require_once.
 */

// ─── Mapa: slug tipo-turismo → filtros SITUR ──────────────────────────────────
if ( ! defined( 'SITUR_CATEGORY_MAP' ) ) {
    define( 'SITUR_CATEGORY_MAP', array(

        'alojamiento' => array(
            'categorias_rnt' => array(
                // Keys del backend
                'alojamiento',
                'viviendas',
                'tiempo_compartido',
                'companias_intercambio_vacacional',
                // Labels del backend
                'establecimientos de alojamiento turistico',
                'establecimientos de alojamiento turístico',
                'viviendas turisticas',
                'viviendas turísticas',
                'empresas de tiempo compartido',
                'compañias de intercambio vacacional',
            ),
            'campo_dinamico' => array( 'alojamiento', 'hoteles', 'hostal', 'cabaña', 'cabanas', 'camping', 'glamping', 'apartahotel', 'finca', 'refugio' ),
        ),

        'gastronomico' => array(
            'categorias_rnt' => array(
                // Keys del backend
                'establecimientos_gastronomia',
                'restaurantes',
                'bares',
                // Labels del backend
                'establecimientos de gastronomia',
                'establecimientos de gastronomía',
                'restaurantes turisticos',
                'restaurantes turísticos',
                'bares y negocios similares',
            ),
            'campo_dinamico' => array( 'gastronomico', 'gastron', 'restaurante', 'bares', 'cafe', 'comida', 'piqueteadero', 'heladeria', 'gastrobar', 'discoteca' ),
        ),

        'parques-tematicos' => array(
            'categorias_rnt' => array(
                // Keys del backend
                'parques',
                'concesionarios_parque',
                // Labels del backend
                'parques tematicos',
                'parques temáticos',
                'concesionarios de servicios turisticos',
                'concesionarios de servicios turísticos',
            ),
            'campo_dinamico' => array( 'parques', 'tematicos', 'ecoturismo', 'agroturismo', 'temático' ),
        ),

        'empresarial' => array(
            'categorias_rnt' => array(
                // Keys del backend
                'operador_pc_fc',
                'operadores',
                'empresas_transporte',
                'arrendadores',
                'usuarios_zonas_francas',
                // Labels del backend
                'operadores profesionales de congresos',
                'operador profesional de congresos',
                'empresas de transporte terrestre automotor',
                'arrendadores de vehiculos',
                'arrendadores de vehículos',
                'zonas francas',
            ),
            'campo_dinamico' => array( 'negocios', 'eventos', 'congresos', 'ferias', 'convenciones', 'transporte', 'vehiculos', 'chivas' ),
        ),

        'romance' => array(
            'categorias_rnt' => array(
                // Keys del backend
                'organizadores_boda_destino',
                // Labels del backend
                'organizadores de boda destino',
            ),
            'campo_dinamico' => array( 'boda', 'romance', 'bodas' ),
        ),

        'agencias-de-viajes' => array(
            'categorias_rnt' => array(
                // Keys del backend
                'agencias',
                'oficinas_representacion',
                'operadores_plataformas',
                'captadoras_ahorro_viajes',
                // Labels del backend
                'agencias de viajes',
                'oficinas de representacion turistica',
                'oficinas de representación turística',
                'operadores de plataformas electronicas',
                'operadores de plataformas electrónicas',
                'empresas captadoras de ahorro',
            ),
            'campo_dinamico' => array( 'agencia', 'viajes', 'operadora', 'mayorista', 'representacion', 'plataforma' ),
        ),

        'guias-turisticos' => array(
            'categorias_rnt' => array(
                // Keys del backend
                'guias',
                // Labels del backend
                'guias de turismo',
                'guías de turismo',
                'guia de turismo',
                'guía de turismo',
            ),
            'campo_dinamico' => array( 'guia', 'guias', 'guía', 'guías', 'guianza' ),
        ),

    ) );
}

// ─── Normaliza un valor que puede venir como JSON string o array ───────────────
if ( ! function_exists( 'situr_normalize_json' ) ) {
    function situr_normalize_json( $value ) {
        if ( is_string( $value ) ) {
            $decoded = json_decode( $value, true );
            return ( json_last_error() === JSON_ERROR_NONE ) ? (array) $decoded : array();
        }
        return is_array( $value ) ? $value : array();
    }
}

// ─── Extrae la primera imagen disponible de un ítem ───────────────────────────
if ( ! function_exists( 'situr_get_imagen' ) ) {
    function situr_get_imagen( $item, $datos ) {
        $imagenes = situr_normalize_json( isset( $item['imagenes'] ) ? $item['imagenes'] : array() );
        if ( ! empty( $imagenes[0]['url_imagen'] ) ) {
            return 'https://apisitur.visitatenjo.com' . $imagenes[0]['url_imagen'];
        }
        $fotos = situr_normalize_json( isset( $datos['fotos'] ) ? $datos['fotos'] : array() );
        foreach ( $fotos as $foto ) {
            if ( is_array( $foto ) && ! empty( $foto['url'] ) ) return $foto['url'];
            if ( is_string( $foto ) && $foto )                  return $foto;
        }
        return 'https://placehold.co/1080x1920';
    }
}

// ─── Renderiza una card de establecimiento ────────────────────────────────────
if ( ! function_exists( 'situr_render_card' ) ) {
    function situr_render_card( $nombre, $img_url, $id ) {
        $alias = sanitize_title( $nombre );
        echo '<a href="/establecimiento/' . $alias . '/' .  $id  . '" class="restaurante-card">';
        echo '<img src="' . esc_url( $img_url ) . '" alt="' . esc_attr( $nombre ) . '" class="restaurante-card__image" />';
        echo '<div class="restaurante-card__overlay">';
        echo '<h3 class="restaurante-card__title">' . esc_html( $nombre ) . '</h3>';
        echo '</div>';
        echo '</a>';
    }
}

// ─── Evalúa si un establecimiento coincide con un slug de tipo-turismo ─────────
if ( ! function_exists( 'situr_match_establecimiento' ) ) {
     function situr_match_establecimiento( $datos, $data_interna, $tipo_slug ) {
        $tipos = is_array($tipo_slug) ? $tipo_slug : array($tipo_slug);

        foreach ($tipos as $slug) {
            $map_all = defined( 'SITUR_CATEGORY_MAP' ) ? SITUR_CATEGORY_MAP : array();
            $map     = isset( $map_all[ $slug ] ) ? $map_all[ $slug ] : null;

            if ( ! $map ) continue;

            $categorias = situr_normalize_json(
                isset( $datos['categoria_rnt'] ) ? $datos['categoria_rnt'] : array()
            );

            foreach ( $categorias as $cat ) {
                $cat = strtolower( trim( $cat ) );

                foreach ( $map['categorias_rnt'] as $permitida ) {
                    if ( strpos( $cat, $permitida ) !== false ) {
                        return true;
                    }
                }
            }

            $campo = isset( $data_interna['field_1766013834262'] )
                ? $data_interna['field_1766013834262']
                : array();

            if ( ! is_array( $campo ) ) $campo = array();

            foreach ( $campo as $valor ) {
                foreach ( $map['campo_dinamico'] as $buscar ) {
                    if ( stripos( (string) $valor, $buscar ) !== false ) {
                        return true;
                    }
                }
            }
        }

        return false;
    }
}

// ─── Consulta la API SITUR y renderiza cards filtradas por tipo ────────────────
if ( ! function_exists( 'situr_render_establecimientos' ) ) {
    function situr_render_establecimientos( $tipo_slug ) {

        $items = situr_get_api_data();

        if (empty($items)) return;

        foreach ( $items as $item ) {

            $datos        = situr_normalize_json( $item['datos'] ?? [] );
            $data_interna = situr_normalize_json( $datos['data'] ?? [] );

            if ( ! situr_match_establecimiento( $datos, $data_interna, $tipo_slug ) ) continue;

            $nombre  = strtoupper( $datos['nombre'] ?? 'SIN NOMBRE' );
            $img_url = situr_get_imagen( $item, $datos );

            situr_render_card( $nombre, $img_url, $item['id'] );
        }
    }
}

// ─── Renderiza posts del CPT recorridos-visit como cards ──────────────────────
if ( ! function_exists( 'situr_render_recorridos_visit' ) ) {
    function situr_render_recorridos_visit() {
        $query = new WP_Query( array(
            'post_type'      => 'recorridos-visit',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
            'post_status'    => 'publish',
        ) );

        if ( ! $query->have_posts() ) {
            echo '<p>No hay recorridos disponibles.</p>';
            wp_reset_postdata();
            return;
        }

        while ( $query->have_posts() ) {
            $query->the_post();
            $img_url = get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : 'https://placehold.co/1080x1920';
            $nombre  = strtoupper( get_the_title() );
            $link    = get_permalink();

            echo '<a href="' . esc_url( $link ) . '" class="restaurante-card">';
            echo '<img src="' . esc_url( $img_url ) . '" alt="' . esc_attr( $nombre ) . '" class="restaurante-card__image" />';
            echo '<div class="restaurante-card__overlay">';
            echo '<h3 class="restaurante-card__title">' . esc_html( $nombre ) . '</h3>';
            echo '</div>';
            echo '</a>';
        }

        wp_reset_postdata();
    }
}

if ( ! function_exists( 'situr_get_conteo_filtros' ) ) {
    function situr_get_conteo_filtros($slugs = []) {

        $items = situr_get_api_data();

        if (empty($items)) return [];

        $conteo = array_fill_keys($slugs, 0);

        foreach ($items as $item) {

            $datos = situr_normalize_json($item['datos'] ?? []);
            $data_interna = situr_normalize_json($datos['data'] ?? []);

            foreach ($slugs as $slug) {
                if (situr_match_establecimiento($datos, $data_interna, $slug)) {
                    $conteo[$slug]++;
                }
            }
        }

        return $conteo;
    }
}
if ( ! function_exists( 'situr_get_api_data' ) ) {
    function situr_get_api_data() {

        $cache = get_transient('situr_api_data');

        if ($cache !== false) {
            return $cache;
        }

        $response = wp_remote_get(
            'https://apisitur.visitatenjo.com/establecimientos/aprobados',
            [
                'headers' => [
                    'X-API-KEY' => 'd96e31d732b5329a5bfffaf30d8da427821693107aae19c1344eae7fe3446bd5'
                ],
                'timeout' => 20
            ]
        );

        if (is_wp_error($response)) return [];

        $data = json_decode(wp_remote_retrieve_body($response), true);

        if (empty($data['success']) || empty($data['data'])) {
            return [];
        }

        set_transient('situr_api_data', $data['data'], 60 * 10); // solo guardas data

        return $data['data'];
    }
}