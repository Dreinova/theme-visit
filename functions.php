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
    // Add thumbnails support
    add_theme_support('post-thumbnails');
    // Add custom Logo support
    add_theme_support('custom-logo');
}
add_action('after_setup_theme', 'gymsonline_theme_support');

include get_template_directory() . '/includes/cleanup.php';
include get_template_directory() . '/includes/enqueue.php';
include get_template_directory() . '/includes/custom-posts.php';



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

function custom_seo_meta_tags() {
    if (is_singular()) {
        global $post;
        $title = get_the_title($post->ID);
        $description = get_the_excerpt($post->ID);
        $url = get_permalink($post->ID);
        $image = get_the_post_thumbnail_url($post->ID, 'full') ?: get_site_icon_url();

        echo "<title>$title | " . get_bloginfo('name') . "</title>\n";
        echo '<meta name="description" content="' . esc_attr(wp_strip_all_tags($description)) . '">' . "\n";
        echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";
        echo '<meta property="og:image" content="' . esc_url($image) . '">' . "\n";
        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    } else {
        // Meta genérica para homepage o archivos
        echo "<title>" . get_bloginfo('name') . " | " . get_bloginfo('description') . "</title>\n";
        echo '<meta name="description" content="' . esc_attr(get_bloginfo('description')) . '">' . "\n";
    }
}
add_action('wp_head', 'custom_seo_meta_tags');

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
    if (get_query_var('sitemap')) {
        header('Content-Type: application/xml; charset=utf-8');
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $posts = get_posts(['post_type' => 'post', 'post_status' => 'publish', 'numberposts' => -1]);
        foreach ($posts as $post) {
            echo '<url>';
            echo '<loc>' . get_permalink($post) . '</loc>';
            echo '<lastmod>' . get_the_modified_date('c', $post) . '</lastmod>';
            echo '</url>';
        }
        echo '</urlset>';
        exit;
    }
}
add_action('template_redirect', 'custom_sitemap_template');

function auto_alt_images($content) {
    return preg_replace_callback(
        '/<img([^>]+)>/i',
        function ($matches) {
            $tag = $matches[0];
            if (!preg_match('/alt=/', $tag)) {
                preg_match('/src="([^"]+)"/', $tag, $src);
                $alt = basename($src[1], '.jpg');
                $alt = str_replace(['-', '_'], ' ', $alt);
                $tag = str_replace('<img', '<img alt="' . esc_attr($alt) . '"', $tag);
            }
            return $tag;
        },
        $content
    );
}
add_filter('the_content', 'auto_alt_images');


function custom_robots_txt($output, $public) {
    $output .= "User-agent: *\n";
    $output .= "Disallow: /wp-admin/\n";
    $output .= "Allow: /wp-admin/admin-ajax.php\n";
    $output .= "Sitemap: " . home_url('/sitemap.xml') . "\n";
    return $output;
}
add_filter('robots_txt', 'custom_robots_txt', 10, 2);

function visit_theme_customize_register($wp_customize) {

  // 🗂️ Sección: Información General
  $wp_customize->add_section('visit_info_general', array(
    'title'       => __('Información General', 'visit-theme'),
    'priority'    => 30,
    'description' => 'Configura la información general del sitio.',
  ));

  // Campo: Teléfono
  $wp_customize->add_setting('visit_telefono', array(
    'default' => '',
    'transport' => 'refresh',
  ));
  $wp_customize->add_control('visit_telefono', array(
    'label'   => __('Teléfono', 'visit-theme'),
    'section' => 'visit_info_general',
    'type'    => 'text',
  ));

  // Campo: Correo electrónico
  $wp_customize->add_setting('visit_email', array(
    'default' => '',
    'transport' => 'refresh',
  ));
  $wp_customize->add_control('visit_email', array(
    'label'   => __('Correo electrónico', 'visit-theme'),
    'section' => 'visit_info_general',
    'type'    => 'email',
  ));

  // 🌐 Sección: Redes Sociales
  $wp_customize->add_section('visit_redes_sociales', array(
    'title'       => __('Redes Sociales', 'visit-theme'),
    'priority'    => 31,
    'description' => 'Agrega los enlaces de tus redes sociales.',
  ));

  $redes = ['facebook', 'instagram', 'twitter', 'youtube'];

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
