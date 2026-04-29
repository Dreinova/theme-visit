<?php
function ns_function_encrypt_passwords($value, $post_id, $field)
{
    $value = wp_hash_password($value);

    return $value;
}
add_filter('acf/update_value/type=password', 'ns_function_encrypt_passwords', 10, 3);
// Función para validar el encabezado de autorización
function validate_authorization_header()
{
    $headers = apache_request_headers();
    if (isset($headers['Authorization'])) {
        $wc_header = 'Basic ' . base64_encode(WP_CONSUMER_KEY . ':' . WP_CONSUMER_SECRET);
        if ($headers['Authorization'] == $wc_header) {
            return true;
        }
    }
    return false;
}

function my_custom_login()
{
    echo '<link rel="stylesheet" href="' . get_bloginfo('stylesheet_directory') . '/login/custom-login-style.css" />';
}
add_action('login_head', 'my_custom_login');
function gymsonline_theme_support()
{
    // Add dynamic title tag support
    add_theme_support('title-tag');
    // Add custom Logo support
    add_theme_support('custom-logo');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style'));
}
add_action('after_setup_theme', 'gymsonline_theme_support');

include get_template_directory() . '/includes/cleanup.php';
include get_template_directory() . '/includes/enqueue.php';
include get_template_directory() . '/includes/custom-posts.php';
require_once get_template_directory() . '/includes/situr-helpers.php';

add_action('init', function () {
    add_rewrite_rule(
        '^establecimiento/([^/]+)/?$',
        'index.php?pagename=establecimiento',
        'top'
    );
});

add_filter('query_vars', function ($vars) {
    $vars[] = 'est';
    return $vars;
});


function acfFilt($type)
{
    add_filter('rest_' . $type . '_query', function ($args) {
        if (isset($_GET['value'])) {

            $fields = explode(",", $_GET['field']);
            $vals = explode(",", $_GET['value']);
            $completeQuery = array();
            if (count($fields) > 0) {
                for ($i = 0; $i < count($fields); $i++) {
                    $thear = array(
                        'key' => $fields[$i],
                        'value' => esc_sql($vals[$i]),
                        'compare' => 'LIKE'
                    );
                    array_push($completeQuery, $thear);
                }

                $args['meta_query'] = $completeQuery; // Agrega la cláusula meta_query aquí
            }
        }

        if (isset($_GET['pp'])) {
            $args['posts_per_page'] = $_GET['pp'];
        }

        if (isset($_GET['orderby'])) {
            $args['orderby'] = $_GET['orderby'];
        }

        if (isset($_GET['order'])) {
            $args['order'] = $_GET['order'];
        }


        return $args;
    });
}

if (isset($_GET['field']) || isset($_GET['oby'])) {
    // acfFilt("banners-bureau");
}

function custom_meta_query()
{
    if (isset($_GET['meta_query'])) {
        $query = $_GET['meta_query'];
        // Set the arguments based on our get parameters
        $args = array(
            'relation' => $query[0]['relation'],
            array(
                'key' => $query[0]['key'],
                'value' => $query[0]['value'],
                'compare' => '=',
            ),
        );
        // Run a custom query
        $meta_query = new WP_Query($args);
        if ($meta_query->have_posts()) {
            //Define and empty array
            $data = array();
            // Store each post's title in the array
            while ($meta_query->have_posts()) {
                $meta_query->the_post();
                $data[] = get_the_title();
            }
            // Return the data
            return $data;
        } else {
            // If there is no post
            return 'No post to show';
        }
    }
}
// Allow SVG
add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {

    global $wp_version;
    if ($wp_version !== '4.7.1') {
        return $data;
    }

    $filetype = wp_check_filetype($filename, $mimes);

    return [
        'ext' => $filetype['ext'],
        'type' => $filetype['type'],
        'proper_filename' => $data['proper_filename']
    ];
}, 10, 4);

function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');
function fix_svg()
{
    echo '<style type="text/css">
          .attachment-266x266, .thumbnail img {
               width: 100% !important;
               height: auto !important;
          }
          </style>';
}
add_action('admin_head', 'fix_svg');

// Registrar ubicaciones de menú
function visit_register_menus() {
    register_nav_menus(array(
        'primary' => __('Menú principal', 'visit'),
        'footer'  => __('Menú del pie de página', 'visit'),
        'footer_menu_1' => __('Menú principal del footer', 'visit'),
        'footer_menu_2' => __('¿Por qué Bogotá?', 'visit'),
        'footer_menu_3' => __('Haz tu evento en Bogotá', 'visit'),
    ));
}
add_action('after_setup_theme', 'visit_register_menus');

add_action('wp_head', function () {

    if (current_user_can('administrator')) {
        global $template;
        echo '<!-- TEMPLATE ACTIVO: ' . basename($template) . ' -->';
    }

}, 1);
add_action('wp_head', function () {
    if (!is_page_template('template-establecimiento.php')) {
        return;
    }

    global $establecimiento_meta;

    if (empty($establecimiento_meta)) {
        return;
    }

    $title       = esc_attr($establecimiento_meta['titulo'] ?? '');
    $description = esc_attr(wp_trim_words($establecimiento_meta['descripcion'] ?? '', 30));
    $image       = esc_url($establecimiento_meta['imagen'] ?? '');
    $url         = esc_url(home_url($_SERVER['REQUEST_URI'] ?? ''));

    // META DESCRIPTION
    if ($description) {
        echo "<meta name=\"description\" content=\"{$description}\" />\n";
    }

    // CANONICAL
    echo "<link rel=\"canonical\" href=\"{$url}\" />\n";

    // META KEYWORDS (opcional)
    if (!empty($establecimiento_meta['keywords'])) {
        $keywords = esc_attr($establecimiento_meta['keywords']);
        echo "<meta name=\"keywords\" content=\"{$keywords}\" />\n";
    }

    // OPEN GRAPH
    echo "<meta property=\"og:title\" content=\"{$title}\" />\n";
    if ($description) {
        echo "<meta property=\"og:description\" content=\"{$description}\" />\n";
    }
    if ($image) {
        echo "<meta property=\"og:image\" content=\"{$image}\" />\n";
    }
    echo "<meta property=\"og:url\" content=\"{$url}\" />\n";
    echo "<meta property=\"og:type\" content=\"article\" />\n";
    echo "<meta property=\"og:site_name\" content=\"" . esc_attr(get_bloginfo('name')) . "\" />\n";

    // TWITTER
    echo "<meta name=\"twitter:card\" content=\"summary_large_image\" />\n";
    echo "<meta name=\"twitter:title\" content=\"{$title}\" />\n";
    if ($description) {
        echo "<meta name=\"twitter:description\" content=\"{$description}\" />\n";
    }
    if ($image) {
        echo "<meta name=\"twitter:image\" content=\"{$image}\" />\n";
    }
}, 1);
// En functions.php
function custom_sitemap_rewrite() {
    add_rewrite_rule('^sitemap\.xml$', 'index.php?sitemap=1', 'top');
}
add_action('init', 'custom_sitemap_rewrite');

function custom_sitemap_query_vars($vars) {
    $vars[] = 'sitemap';
    return $vars;
}
add_filter('query_vars', 'custom_sitemap_query_vars');

function custom_sitemap_template() {
    if (!get_query_var('sitemap')) {
        return;
    }

    header('Content-Type: application/xml; charset=utf-8');
    echo '<?xml version="1.0" encoding="UTF-8"?>';
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    // Home
    echo '<url><loc>' . esc_url(home_url('/')) . '</loc><changefreq>daily</changefreq><priority>1.0</priority></url>';

    $sitemap_post_types = apply_filters('visit_sitemap_post_types', array(
        'post',
        'page',
        'lugares-visit',
        'eventos-visit',
        'recorridos-visit',
        'paquetes-visit',
        'preguntas-visit',
        'imagenes-visit',
        'tipo-turismo',
        'pantalla',
        'proyectos',
    ));

    $posts = get_posts(array(
        'post_type'      => $sitemap_post_types,
        'post_status'    => 'publish',
        'numberposts'    => -1,
        'orderby'        => 'modified',
        'order'          => 'DESC',
        'no_found_rows'  => true,
        'suppress_filters' => true,
    ));

    foreach ($posts as $p) {
        $url = get_permalink($p);
        if (!$url) continue;
        echo '<url>';
        echo '<loc>' . esc_url($url) . '</loc>';
        echo '<lastmod>' . esc_html(get_the_modified_date('c', $p)) . '</lastmod>';
        echo '</url>';
    }
    echo '</urlset>';
    exit;
}
add_action('template_redirect', 'custom_sitemap_template');

function auto_alt_images($content) {
    return preg_replace_callback(
        '/<img([^>]+)>/i',
        function ($matches) {
            $tag = $matches[0];
            // Respeta alt existente (incluso vacío para imágenes decorativas)
            if (preg_match('/\salt=/i', $tag)) {
                return $tag;
            }
            if (!preg_match('/src=["\']([^"\']+)["\']/i', $tag, $src)) {
                return $tag;
            }
            $filename = basename(parse_url($src[1], PHP_URL_PATH));
            $alt = preg_replace('/\.(jpe?g|png|webp|gif|svg)$/i', '', $filename);
            $alt = str_replace(array('-', '_'), ' ', $alt);
            $alt = trim(preg_replace('/\d+/', '', $alt));
            return str_replace('<img', '<img alt="' . esc_attr(ucfirst($alt)) . '"', $tag);
        },
        $content
    );
}
add_filter('the_content', 'auto_alt_images');

function visit_theme_customize_register($wp_customize) {

  // 🗂️ Sección: Información General
  $wp_customize->add_section('visit_info_general', array(
    'title'       => __('Información General', 'visit-theme'),
    'priority'    => 30,
    'description' => 'Configura la información general del sitio.',
  ));
   $wp_customize->add_setting('visit_direccion', array(
    'default' => '',
    'transport' => 'refresh',
  ));
  $wp_customize->add_control('visit_direccion', array(
    'label'   => __('Dirección', 'visit-theme'),
    'section' => 'visit_info_general',
    'type'    => 'text',
  ));
   $wp_customize->add_setting('visit_subCulTel', array(
    'default' => '',
    'transport' => 'refresh',
  ));
  $wp_customize->add_control('visit_subCulTel', array(
    'label'   => __('Subdirección de Cultura', 'visit-theme'),
    'section' => 'visit_info_general',
    'type'    => 'text',
  ));
   $wp_customize->add_setting('visit_subTur', array(
    'default' => '',
    'transport' => 'refresh',
  ));
  $wp_customize->add_control('visit_subTur', array(
    'label'   => __('Subdirección de Turismo', 'visit-theme'),
    'section' => 'visit_info_general',
    'type'    => 'text',
  ));
   $wp_customize->add_setting('visit_lineaCorr', array(
    'default' => '',
    'transport' => 'refresh',
  ));
  $wp_customize->add_control('visit_lineaCorr', array(
    'label'   => __('Línea anticorrupción', 'visit-theme'),
    'section' => 'visit_info_general',
    'type'    => 'text',
  ));

  // 🌐 Sección: Redes Sociales
  $wp_customize->add_section('visit_redes_sociales', array(
    'title'       => __('Redes Sociales', 'visit-theme'),
    'priority'    => 31,
    'description' => 'Agrega los enlaces de tus redes sociales.',
  ));

  $redes = ['facebook', 'instagram', 'twitter', 'youtube', 'whatsapp'];

  foreach ($redes as $red) {
    $wp_customize->add_setting("visit_{$red}_url", array(
      'default' => '',
      'transport' => 'refresh',
    ));
    $wp_customize->add_control("visit_{$red}_url", array(
      'label'   => ucfirst($red) . ' URL',
      'section' => 'visit_redes_sociales',
      'type'    => 'url',
    ));
  }
}
add_action('customize_register', 'visit_theme_customize_register');


function add_menu_item_classes($classes, $item, $args) {
    if ($args->theme_location === 'primary') {
        $classes[] = 'header__menu-item';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_menu_item_classes', 10, 3);

function add_menu_link_classes($atts, $item, $args) {
    if ($args->theme_location === 'primary') {
        $atts['class'] = 'header__menu-link';
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'add_menu_link_classes', 10, 3);

function aos_library() {
  wp_enqueue_style(
    'aos-css',
    'https://unpkg.com/aos@2.3.1/dist/aos.css'
  );

  wp_enqueue_script(
    'aos-js',
    'https://unpkg.com/aos@2.3.1/dist/aos.js',
    array(),
    null,
    true
  );

  wp_enqueue_script(
    'aos-init',
    get_stylesheet_directory_uri() . '/js/aos-init.js',
    array('aos-js'),
    null,
    true
  );
}
add_action('wp_enqueue_scripts', 'aos_library');

register_post_type('proyectos', array(
    'label' => 'Proyectos',
    'public' => true,
    'capability_type' => 'proyecto',
    'map_meta_cap' => true,
    'capabilities' => array(
        'edit_post'             => 'edit_proyecto',
        'read_post'             => 'read_proyecto',
        'delete_post'           => 'delete_proyecto',

        'edit_posts'            => 'edit_proyectos',
        'edit_others_posts'     => 'edit_others_proyectos',
        'publish_posts'         => 'publish_proyectos',
        'read_private_posts'    => 'read_private_proyectos',

        'delete_posts'              => 'delete_proyectos',
        'delete_others_posts'       => 'delete_others_proyectos',
        'edit_published_posts'      => 'edit_published_proyectos',
        'delete_published_posts'    => 'delete_published_proyectos',
    ),
));


add_role('gestor_proyectos', 'Gestor de Proyectos', [
    'read' => true,

    'edit_proyecto' => true,
    'read_proyecto' => true,
    'edit_proyectos' => true,
    'publish_proyectos' => true,
    'read_private_proyectos' => true,
]);

add_action('init', function() {
    $admin = get_role('administrator');

    if ($admin) {
        $caps = [
            'edit_proyecto',
            'read_proyecto',
            'delete_proyecto',

            'edit_proyectos',
            'edit_others_proyectos',
            'publish_proyectos',
            'read_private_proyectos',

            'delete_proyectos',
            'delete_others_proyectos',
            'edit_published_proyectos',
            'delete_published_proyectos',
        ];

        foreach ($caps as $cap) {
            $admin->add_cap($cap);
        }
    }
});



// SITUR
add_action('init', function() {

    if (!get_page_by_path('panel-situr')) {
        wp_insert_post([
            'post_title'   => 'Panel SITUR',
            'post_name'    => 'panel-situr',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '[situr_profile_form]', // shortcode por defecto
        ]);
    }

});

add_action('init', function() {

    if (!isset($_POST['_wpnonce'])) return;
    if (!wp_verify_nonce($_POST['_wpnonce'], 'situr_save_profile')) return;
    if (!is_user_logged_in()) return;

    $user_id = get_current_user_id();

    $fields = [
        'nombre_comercial',
        'nit',
        'telefono',
        'direccion'
    ];

    foreach ($fields as $f) {
        if (isset($_POST[$f])) {
            update_field($f, sanitize_text_field($_POST[$f]), 'user_' . $user_id);
        }
    }
});



add_action('admin_init', function() {
    if (current_user_can('situr_user') && !defined('DOING_AJAX')) {
        wp_redirect(home_url('/panel-situr/'));
        exit;
    }
});

add_filter('login_redirect', function($redirect, $req, $user) {

    if (!is_wp_error($user) && isset($user->roles) && in_array('situr_user', $user->roles)) {
        return home_url('/panel-situr/');
    }

    return $redirect;

}, 10, 3);

add_action('admin_bar_menu', 'custom_admin_bar_link', 999);

function custom_admin_bar_link($wp_admin_bar) {
    $args = array(
        'id'    => 'custom-situr-link',
        'title' => 'Ir a SITUR',
        'href'  => 'https://situr.visitatenjo.com/',
        'meta'  => array(
            'target' => '_blank',
            'class'  => 'custom-situr-link-class'
        )
    );

    $wp_admin_bar->add_node($args);
}

function cargar_fontawesome() {
  wp_enqueue_style('fontawesome', get_template_directory_uri() . '/assets/fontawesome/css/all.min.css', [], '6.5.1');
}
add_action('wp_enqueue_scripts', 'cargar_fontawesome');

add_theme_support('post-thumbnails');
add_image_size('galeria_thumb', 400, 300, true);
add_filter('pre_get_document_title', function ($title) {
  global $establecimiento_meta;

  if (!empty($establecimiento_meta['titulo'])) {
    return $establecimiento_meta['titulo'];
  }

  return $title;
});
remove_action('wp_head', 'wp_generator');

// Meta description para página Agenda de Eventos
add_action('wp_head', function () {
  if (!is_page('agenda-de-eventos')) {
    return;
  }

  $meta_desc = get_field('meta_description');

  // Fallback si el campo ACF está vacío
  if (empty($meta_desc)) {
    $meta_desc = 'Agenda de eventos culturales, gastronómicos, deportivos y más en Tenjo, Cundinamarca. Consulta fechas, horarios y categorías.';
  }

  $meta_desc = esc_attr(wp_trim_words($meta_desc, 25));
  $url       = esc_url(home_url($_SERVER['REQUEST_URI']));
  $title     = esc_attr(get_the_title());

  echo "<meta name='description' content='{$meta_desc}' />\n";
  echo "<meta property='og:title' content='{$title}' />\n";
  echo "<meta property='og:description' content='{$meta_desc}' />\n";
  echo "<meta property='og:url' content='{$url}' />\n";
  echo "<meta property='og:type' content='website' />\n";
}, 1);

add_action('wp_ajax_filtrar_establecimientos', 'situr_ajax_filtrar_establecimientos');
add_action('wp_ajax_nopriv_filtrar_establecimientos', 'situr_ajax_filtrar_establecimientos');

function situr_ajax_filtrar_establecimientos() {

    $filtros = isset($_POST['filtros']) ? $_POST['filtros'] : [];

    if (!is_array($filtros)) {
        $filtros = [$filtros];
    }

    ob_start();

    // 👇 reutilizas tu helper
    situr_render_establecimientos($filtros);

    $html = ob_get_clean();

    wp_send_json_success($html);
}
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_script('filtros-ajax', get_template_directory_uri() . '/js/filtros.js', [], null, true);

    wp_localize_script('filtros-ajax', 'ajaxData', [
        'url' => admin_url('admin-ajax.php')
    ]);
    wp_enqueue_script(
    'situr-load-more',
    get_stylesheet_directory_uri() . '/js/load-more.js',
    ['jquery'],
    null,
    true
  );

  wp_localize_script('situr-load-more', 'situr_ajax', [
    'ajax_url' => admin_url('admin-ajax.php')
  ]);
});

/**
 * Imprime la imagen LCP de un hero como <img>/<picture> con dimensiones y fetchpriority.
 * Acepta URL string, array ACF (con 'url' y 'sizes') o ID de attachment.
 * Reemplaza el patrón antiguo <section style="background-image:url(...)">.
 */
function visit_render_hero_image($source, $alt = '', $width = 1920, $height = 1080) {
    $url = '';
    $srcset = '';
    $sizes = '(max-width: 768px) 100vw, 100vw';

    if (is_numeric($source)) {
        $url    = wp_get_attachment_image_url($source, 'full');
        $srcset = wp_get_attachment_image_srcset($source, 'full');
    } elseif (is_array($source)) {
        $url = $source['url'] ?? '';
        if (!empty($source['ID'])) {
            $srcset = wp_get_attachment_image_srcset($source['ID'], 'full');
        }
        if (!empty($source['width']))  $width  = (int) $source['width'];
        if (!empty($source['height'])) $height = (int) $source['height'];
        if (empty($alt) && !empty($source['alt'])) $alt = $source['alt'];
    } else {
        $url = (string) $source;
        // Si la URL es de la propia media library, intentar resolver attachment para srcset
        $att_id = function_exists('attachment_url_to_postid') ? attachment_url_to_postid($url) : 0;
        if ($att_id) {
            $srcset = wp_get_attachment_image_srcset($att_id, 'full');
            $meta   = wp_get_attachment_metadata($att_id);
            if (!empty($meta['width']))  $width  = (int) $meta['width'];
            if (!empty($meta['height'])) $height = (int) $meta['height'];
        }
    }

    if (!$url) return;

    printf(
        '<img class="hero__media" src="%1$s"%2$s sizes="%3$s" width="%4$d" height="%5$d" alt="%6$s" fetchpriority="high" decoding="async" />',
        esc_url($url),
        $srcset ? ' srcset="' . esc_attr($srcset) . '"' : '',
        esc_attr($sizes),
        $width,
        $height,
        esc_attr($alt)
    );
}

/**
 * SEO global: canonical, meta description y Open Graph para Home/page/single/archive.
 * No emite nada en template-establecimiento.php (ese template tiene su propio bloque de meta).
 */
add_action('wp_head', function () {
    if (is_page_template('template-establecimiento.php')) {
        return;
    }

    $title = wp_get_document_title();
    $url   = '';
    $desc  = '';
    $image = '';
    $type  = 'website';

    if (is_singular()) {
        $url  = get_permalink();
        $type = is_single() ? 'article' : 'website';

        $raw_desc = get_post_field('post_excerpt', get_queried_object_id());
        if (empty($raw_desc)) {
            $raw_desc = get_post_field('post_content', get_queried_object_id());
        }
        $desc = wp_strip_all_tags(strip_shortcodes($raw_desc));
        $desc = wp_trim_words($desc, 30, '');

        if (has_post_thumbnail(get_queried_object_id())) {
            $image = get_the_post_thumbnail_url(get_queried_object_id(), 'full');
        }
    } elseif (is_home() || is_front_page()) {
        $url  = home_url('/');
        $desc = get_bloginfo('description');
    } elseif (is_archive()) {
        $url  = home_url(add_query_arg([], $_SERVER['REQUEST_URI'] ?? ''));
        $desc = wp_strip_all_tags(get_the_archive_description());
        $desc = wp_trim_words($desc, 30, '');
    } else {
        $url = home_url(add_query_arg([], $_SERVER['REQUEST_URI'] ?? ''));
    }

    if ($url) {
        echo '<link rel="canonical" href="' . esc_url($url) . '" />' . "\n";
    }
    if ($desc) {
        echo '<meta name="description" content="' . esc_attr($desc) . '" />' . "\n";
    }

    // Open Graph
    echo '<meta property="og:locale" content="' . esc_attr(get_locale()) . '" />' . "\n";
    echo '<meta property="og:type" content="' . esc_attr($type) . '" />' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($title) . '" />' . "\n";
    if ($desc) {
        echo '<meta property="og:description" content="' . esc_attr($desc) . '" />' . "\n";
    }
    if ($url) {
        echo '<meta property="og:url" content="' . esc_url($url) . '" />' . "\n";
    }
    echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '" />' . "\n";
    if ($image) {
        echo '<meta property="og:image" content="' . esc_url($image) . '" />' . "\n";
    }

    // Twitter Card
    echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($title) . '" />' . "\n";
    if ($desc) {
        echo '<meta name="twitter:description" content="' . esc_attr($desc) . '" />' . "\n";
    }
    if ($image) {
        echo '<meta name="twitter:image" content="' . esc_url($image) . '" />' . "\n";
    }
}, 2);

/**
 * Schema.org JSON-LD básico (Organization en home + LocalBusiness en singles tipo "lugares-visit").
 */
add_action('wp_head', function () {
    if (is_front_page()) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type'    => 'Organization',
            'name'     => get_bloginfo('name'),
            'url'      => home_url('/'),
            'logo'     => function_exists('get_custom_logo') && has_custom_logo()
                ? wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full')
                : '',
            'sameAs'   => array_values(array_filter(array(
                get_theme_mod('visit_facebook_url'),
                get_theme_mod('visit_instagram_url'),
                get_theme_mod('visit_twitter_url'),
                get_theme_mod('visit_youtube_url'),
            ))),
        );
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }

    if (is_singular(array('lugares-visit', 'eventos-visit', 'recorridos-visit'))) {
        $post_id = get_queried_object_id();
        $schema  = array(
            '@context'    => 'https://schema.org',
            '@type'       => is_singular('eventos-visit') ? 'Event' : 'TouristAttraction',
            'name'        => get_the_title($post_id),
            'url'         => get_permalink($post_id),
            'description' => wp_trim_words(wp_strip_all_tags(get_post_field('post_content', $post_id)), 30, ''),
        );
        if (has_post_thumbnail($post_id)) {
            $schema['image'] = get_the_post_thumbnail_url($post_id, 'full');
        }
        if (is_singular('eventos-visit') && function_exists('get_field')) {
            $fecha = get_field('fecha', $post_id);
            if ($fecha) {
                $schema['startDate'] = $fecha;
            }
            $direccion = get_field('direccion', $post_id);
            if ($direccion) {
                $schema['location'] = array(
                    '@type'   => 'Place',
                    'name'    => 'Tenjo',
                    'address' => $direccion,
                );
            }
        }
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
}, 3);


add_action('wp_ajax_load_more_images', 'load_more_images');
add_action('wp_ajax_nopriv_load_more_images', 'load_more_images');

function load_more_images() {

  $paged = isset($_POST['page']) ? intval($_POST['page']) + 1 : 1;

  $args = [
    'post_type'      => 'imagenes-visit',
    'posts_per_page' => 12,
    'paged'          => $paged,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
  ];

  $query = new WP_Query($args);

  ob_start();

  if ($query->have_posts()):
    while ($query->have_posts()): $query->the_post();
      ?>
      <div class="galeria__item">
        <a href="<?php the_permalink(); ?>" class="galeria__image-wrapper">
          <?php
            echo wp_get_attachment_image(
              get_post_thumbnail_id(get_the_ID()),
              'galeria_thumb',
              false,
              [
                'class' => 'galeria__image',
                'loading' => 'lazy',
                'decoding' => 'async'
              ]
            );
          ?>
        </a>
      </div>
      <?php
    endwhile;
  endif;

  wp_reset_postdata();

  echo ob_get_clean();
  wp_die();
}