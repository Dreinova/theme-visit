<?php
/**
 * situr-helpers.php
 * Helpers optimizados para SITUR (sin loops innecesarios + sync con front)
 */

function situr_get_screen_map() {

    $cache = get_transient('situr_screen_map_v2');

    if ($cache !== false) return $cache;

    $file = get_stylesheet_directory() . '/data/situr-mapping.csv';

    if (!file_exists($file)) return [];

    $rows = array_map('str_getcsv', file($file));
    $header = array_shift($rows);

    $map = [];

   foreach ($rows as $row) {

        // Aseguramos que la fila tenga el mismo número de elementos que la cabecera
        if (count($header) !== count($row)) continue;

        $data = array_combine($header, $row);

        $pantalla = sanitize_title($data['pantalla']);
        // Corrección: Usar las llaves correctas del CSV
        $cat = trim($data['rnt_categoria'] ?? '');
        $cat = ($cat === '') ? null : $cat;
        
        $sub = trim($data['rnt_subcategoria'] ?? '');

        if (!isset($map[$pantalla])) {
            $map[$pantalla] = [
                'categorias' => [],
                'subcategorias' => []
            ];
        }
        if ($cat) {
            $map[$pantalla]['categorias'][] = $cat;
        }
        if ($sub) {
            $map[$pantalla]['subcategorias'][] = $sub;
        }
    }

    // limpiar duplicados
    foreach ($map as $slug => $conf) {
        $map[$slug]['categorias'] = array_values(array_unique($conf['categorias']));
        $map[$slug]['subcategorias'] = array_values(array_unique($conf['subcategorias']));
    }

    set_transient('situr_screen_map_v2', $map, 600);

    return $map;
}

function situr_get_screen_config($slug) {
    $map = situr_get_screen_map();
    return $map[$slug] ?? null;
}
/* ──────────────────────────────────────────────
   🔹 NORMALIZADOR GLOBAL
────────────────────────────────────────────── */
if ( ! function_exists( 'situr_normalize_text' ) ) {
    function situr_normalize_text( $text ) {
        $text = strtolower(trim((string)$text));
        $text = str_replace(['á','é','í','ó','ú','ñ'], ['a','e','i','o','u','n'], $text);
        return $text;
    }
}

/* ──────────────────────────────────────────────
   🔹 GENERAR MAPA DESDE JSON (FRONT SOURCE OF TRUTH)
────────────────────────────────────────────── */
if ( ! function_exists( 'situr_generate_category_map' ) ) {
    function situr_generate_category_map() {

        $file = get_stylesheet_directory() . '/data/situr-categorias.json';

        if ( ! file_exists( $file ) ) return [];

        $json = file_get_contents( $file );
        $data = json_decode( $json, true );

        if ( empty( $data['categoriasRNT'] ) ) return [];

        $map = [];

        // opcional: mapper manual de slugs
        $slug_map = [
            'restaurantes' => 'gastronomico',
            'bares'        => 'gastronomico',
            'agencias'     => 'agencias-de-viajes',
        ];

        foreach ( $data['categoriasRNT'] as $cat ) {

            $value = $cat['value'];
            $slug  = $slug_map[$value] ?? sanitize_title($value);

            // categorias exactas (OJO: SOLO values)
            $categorias_rnt = [ $value ];

            // subcategorías → dinámicos
            $campo_dinamico = [];

            if ( ! empty( $data['subcategoriasRNT'][ $value ] ) ) {
                foreach ( $data['subcategoriasRNT'][ $value ] as $sub ) {
                    if ( ! empty( $sub['value'] ) ) {
                        $campo_dinamico[] = $sub['value'];
                    }
                }
            }

            // fallback
            $campo_dinamico[] = $value;

            // merge si varios values caen en mismo slug
            if ( isset($map[$slug]) ) {
                $map[$slug]['categorias_rnt'] = array_merge($map[$slug]['categorias_rnt'], $categorias_rnt);
                $map[$slug]['campo_dinamico'] = array_merge($map[$slug]['campo_dinamico'], $campo_dinamico);
            } else {
                $map[$slug] = [
                    'categorias_rnt' => $categorias_rnt,
                    'campo_dinamico' => $campo_dinamico,
                ];
            }
        }

        // limpiar duplicados
        foreach ($map as $slug => $conf) {
            $map[$slug]['categorias_rnt'] = array_values(array_unique($conf['categorias_rnt']));
            $map[$slug]['campo_dinamico'] = array_values(array_unique($conf['campo_dinamico']));
        }

        return $map;
    }
}

/* ──────────────────────────────────────────────
   🔹 DEFINIR MAPA GLOBAL
────────────────────────────────────────────── */
if ( ! defined( 'SITUR_CATEGORY_MAP' ) ) {
    define( 'SITUR_CATEGORY_MAP', situr_generate_category_map() );
}

/* ──────────────────────────────────────────────
   🔹 COMPILAR MAPA → HASHES (O(1))
────────────────────────────────────────────── */
if ( ! function_exists( 'situr_compile_category_map' ) ) {
    function situr_compile_category_map( $map ) {

        $compiled = [];

        foreach ($map as $slug => $config) {

            $cat_set = [];
            foreach ($config['categorias_rnt'] as $c) {
                $cat_set[ situr_normalize_text($c) ] = true;
            }

            $dyn_set = [];
            foreach ($config['campo_dinamico'] as $d) {
                $dyn_set[ situr_normalize_text($d) ] = true;
            }

            $compiled[$slug] = [
                'categorias_rnt' => $cat_set,
                'campo_dinamico' => $dyn_set,
            ];
        }

        return $compiled;
    }
}

/* ──────────────────────────────────────────────
   🔹 CACHE DEL MAPA COMPILADO
────────────────────────────────────────────── */
if ( ! function_exists( 'situr_get_compiled_map' ) ) {
    function situr_get_compiled_map() {

        static $compiled = null;

        if ($compiled === null) {
            $compiled = situr_compile_category_map(SITUR_CATEGORY_MAP);
        }

        return $compiled;
    }
}

/* ────────
/* ──────────────────────────────────────────────
   🔹 NORMALIZAR JSON
────────────────────────────────────────────── */
if ( ! function_exists( 'situr_normalize_json' ) ) {
    function situr_normalize_json( $value ) {
        if ( is_string( $value ) ) {
            $decoded = json_decode( $value, true );
            return ( json_last_error() === JSON_ERROR_NONE ) ? (array) $decoded : [];
        }
        return is_array( $value ) ? $value : [];
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
   function situr_render_card( $nombre, $img_url, $id, $datos = [] ) {

    $alias = sanitize_title( $nombre );

    $categoria = $datos['categoria_rnt'] ?? '';
    $subcategoria = $datos['subcategoria_rnt'] ?? '';

echo '<a 
    href="/establecimiento/' . $alias . '/?est=' .  $id  . '" 
    class="restaurante-card"
    data-categoria="' . esc_attr($categoria) . '"
    data-subcategoria="' . esc_attr($subcategoria) . '"
    data-debug="' . esc_attr(json_encode([
        'cat' => $categoria,
        'sub' => $subcategoria
    ])) . '"
>';

    echo '<img src="' . esc_url( $img_url ) . '" alt="' . esc_attr( $nombre ) . '" class="restaurante-card__image" />';
    
    echo '<div class="restaurante-card__overlay">';
    echo '<h3 class="restaurante-card__title">' . esc_html( $nombre ) . '</h3>';
    echo '</div>';
    
    echo '</a>';
}
}


/* ──────────────────────────────────────────────
   🔹 MATCH OPTIMIZADO
────────────────────────────────────────────── */
if ( ! function_exists( 'situr_match_establecimiento' ) ) {
function situr_match_establecimiento( $datos, $data_interna, $tipo_slug ) {

    $tipos = is_array($tipo_slug) ? $tipo_slug : [$tipo_slug];
    $map   = situr_get_compiled_map();

    // 🔹 categorias normalizadas
    $categorias_raw = $datos['categoria_rnt'] ?? [];
    $categorias = is_array($categorias_raw) ? $categorias_raw : [$categorias_raw];

    $cat_set = [];
    foreach ($categorias as $c) {
        $cat_set[ situr_normalize_text($c) ] = true;
    }

    // 🔹 dinámicos normalizados
    $val_set = [];

    // 🔹 1. data interna
    if (is_array($data_interna)) {
        foreach ($data_interna as $vals) {
            if (!is_array($vals)) continue;

            foreach ($vals as $v) {
                if (!is_string($v)) continue;
                $val_set[ situr_normalize_text($v) ] = true;
            }
        }
    }

    // 🔥 2. SUBCATEGORÍAS (CLAVE)
    $subcats = $datos['subcategoria_rnt'] ?? [];
    $subcats = is_array($subcats) ? $subcats : [$subcats];
$tipos_norm = array_map('situr_normalize_text', $tipos);

    foreach ($subcats as $sub) {
    if (in_array(situr_normalize_text($sub), $tipos_norm)) {
        return true;
    }
}
    foreach ($tipos as $slug) {

    $slug_norm = situr_normalize_text($slug);

    // 🔥 1. MATCH DIRECTO POR SUBCATEGORÍA
    if (isset($val_set[$slug_norm])) {
        return true;
    }

    // 🔹 2. MATCH POR CATEGORÍA (si existe)
    $slug_key = situr_normalize_text(str_replace('-', '_', $slug));

    if (!empty($map[$slug_key])) {

        $conf = $map[$slug_key];

        if (array_intersect_key($cat_set, $conf['categorias_rnt'])) {
            return true;
        }

        if (array_intersect_key($val_set, $conf['campo_dinamico'])) {
            return true;
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

    if (empty($items)) {
        echo '<p>No hay datos</p>';
        return;
    }

    $count = 0;

    foreach ( $items as $item ) {

        $datos        = situr_normalize_json( $item['datos'] ?? [] );
        $data_interna = situr_normalize_json( $datos['data'] ?? [] );

        if ( ! situr_match_establecimiento( $datos, $data_interna, $tipo_slug ) ) continue;

        $nombre  = strtoupper( $datos['nombre'] ?? 'SIN NOMBRE' );
        $img_url = situr_get_imagen( $item, $datos );

        situr_render_card( $nombre, $img_url, $item['id'], $datos );

        $count++;
    }

    if ($count === 0) {
        echo '<p>No se encontraron resultados</p>';
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
/* ──────────────────────────────────────────────
   🔹 API CACHE
────────────────────────────────────────────── */
if ( ! function_exists( 'situr_get_api_data' ) ) {
    function situr_get_api_data() {

        // $cache = get_transient('situr_api_data_v2');

        // if ($cache !== false) {
        //     return $cache;
        // }

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

        if (empty($data['data'])) return [];

        set_transient('situr_api_data_v2', $data['data'], 600);

        return $data['data'];
    }
}

add_action('init', function () {
    add_rewrite_rule('sitemap-situr\.xml$', 'index.php?situr_sitemap=1', 'top');
});

add_filter('query_vars', function ($vars) {
    $vars[] = 'situr_sitemap';
    return $vars;
});

add_action('template_redirect', function () {

    if (get_query_var('situr_sitemap') != 1) return;

    header('Content-Type: application/xml; charset=UTF-8');

    $items = situr_get_api_data();

    echo '<?xml version="1.0" encoding="UTF-8"?>';
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    foreach ($items as $item) {

        $datos = situr_normalize_json($item['datos'] ?? []);
        $nombre = $datos['nombre'] ?? '';
        $slug = sanitize_title($nombre);

        $url = home_url("/establecimiento/$slug/?est=" . $item['id']);

        echo "<url>";
        echo "<loc>" . esc_url($url) . "</loc>";
        echo "<changefreq>weekly</changefreq>";
        echo "<priority>0.7</priority>";
        echo "</url>";
    }

    echo '</urlset>';
    exit;
});