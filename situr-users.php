<?php
/**
 * Plugin Name: SITUR Users
 * Description: Rol SITUR, campos extra en perfil, bloqueo admin y shortcodes para registro/edición.
 * Version: 1.0
 * Author: Tu Nombre
 * Text Domain: situr-users
 */

add_action('init', function() {
    error_log("SITUR PLUGIN CARGANDO...");
});

// Evitar acceso directo
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 1) Crear rol SITUR al activar el plugin
 */
register_activation_hook( __FILE__, function() {
    // Crear rol si no existe
    if ( ! get_role('situr_user') ) {
        add_role('situr_user', 'Usuario SITUR', [
            'read' => true,
        ]);
    }
});

add_shortcode('situr_profile_form', 'situr_profile_form_fn');
function situr_profile_form_fn() {
    if (!is_user_logged_in()) {
        return '<p>Debes iniciar sesión para editar tu perfil.</p>';
    }

    $user_id = get_current_user_id();

    ob_start();
    ?>
    <div class="situr-dashboard">
        <h2 class="situr-title">Editar mi Perfil SITUR</h2>

        <form class="situr-form" method="post">
            <?php wp_nonce_field('situr_save_profile'); ?>

            <div class="situr-field">
                <label>Nombre comercial</label>
                <input type="text" name="nombre_comercial"
                       value="<?php echo esc_attr(get_field('nombre_comercial', 'user_'.$user_id)); ?>">
            </div>

            <div class="situr-field">
                <label>NIT</label>
                <input type="text" name="nit"
                       value="<?php echo esc_attr(get_field('nit', 'user_'.$user_id)); ?>">
            </div>

            <div class="situr-field">
                <label>Teléfono</label>
                <input type="text" name="telefono"
                       value="<?php echo esc_attr(get_field('telefono', 'user_'.$user_id)); ?>">
            </div>

            <div class="situr-field">
                <label>Dirección</label>
                <input type="text" name="direccion"
                       value="<?php echo esc_attr(get_field('direccion', 'user_'.$user_id)); ?>">
            </div>

            <button type="submit" class="situr-btn">Guardar cambios</button>
        </form>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * 2) Mostrar campos extra en el perfil (backend)
 */
function situr_show_extra_user_fields($user) {
    // Mostrar solo si el usuario es SITUR o si lo está editando un admin
    $is_situr = in_array('situr_user', (array) $user->roles);
    $current_is_admin = current_user_can('administrator');

    if ( ! $is_situr && ! $current_is_admin ) {
        return;
    }

    // Obtener valores
    $documento = esc_attr( get_user_meta($user->ID, 'documento_situr', true) );
    $telefono  = esc_attr( get_user_meta($user->ID, 'telefono_situr', true) );
    $empresa   = esc_attr( get_user_meta($user->ID, 'empresa_situr', true) );
    $codigo    = esc_attr( get_user_meta($user->ID, 'codigo_situr', true) );
    ?>
    <h2><?php _e('Información SITUR', 'situr-users'); ?></h2>
    <table class="form-table">
        <tr>
            <th><label for="documento_situr"><?php _e('Documento', 'situr-users'); ?></label></th>
            <td>
                <input type="text" name="documento_situr" id="documento_situr" value="<?php echo $documento; ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="telefono_situr"><?php _e('Teléfono', 'situr-users'); ?></label></th>
            <td>
                <input type="text" name="telefono_situr" id="telefono_situr" value="<?php echo $telefono; ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="empresa_situr"><?php _e('Empresa', 'situr-users'); ?></label></th>
            <td>
                <input type="text" name="empresa_situr" id="empresa_situr" value="<?php echo $empresa; ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="codigo_situr"><?php _e('Código SITUR', 'situr-users'); ?></label></th>
            <td>
                <input type="text" name="codigo_situr" id="codigo_situr" value="<?php echo $codigo; ?>" class="regular-text" />
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'situr_show_extra_user_fields');
add_action('edit_user_profile', 'situr_show_extra_user_fields');

/**
 * 3) Guardar los campos del perfil (backend)
 */
function situr_save_extra_user_fields($user_id) {
    // Verificaciones de permisos
    if ( ! current_user_can('edit_user', $user_id) ) {
        return false;
    }

    if ( isset( $_POST['documento_situr'] ) ) {
        update_user_meta( $user_id, 'documento_situr', sanitize_text_field( $_POST['documento_situr'] ) );
    }

    if ( isset( $_POST['telefono_situr'] ) ) {
        update_user_meta( $user_id, 'telefono_situr', sanitize_text_field( $_POST['telefono_situr'] ) );
    }

    if ( isset( $_POST['empresa_situr'] ) ) {
        update_user_meta( $user_id, 'empresa_situr', sanitize_text_field( $_POST['empresa_situr'] ) );
    }

    if ( isset( $_POST['codigo_situr'] ) ) {
        update_user_meta( $user_id, 'codigo_situr', sanitize_text_field( $_POST['codigo_situr'] ) );
    }
}
add_action('personal_options_update', 'situr_save_extra_user_fields');
add_action('edit_user_profile_update', 'situr_save_extra_user_fields');

/**
 * 4) Bloquear admin para usuarios SITUR y redirigir al panel SITUR
 *    Cambia '/panel-situr/' por la URL real de tu panel frontend.
 */
function situr_block_admin_for_situr() {
    if ( is_admin() && ! defined('DOING_AJAX') && current_user_can('situr_user') ) {
        // permitir acceso al perfil propio (editar perfil) si prefieres:
        // $p = $_SERVER['REQUEST_URI'];
        // if ( strpos($p, 'profile.php') !== false ) return;

        wp_safe_redirect( home_url('/panel-situr/') );
        exit;
    }
}
add_action('admin_init', 'situr_block_admin_for_situr');

/**
 * 5) Redirección post-login para usuarios SITUR
 */
function situr_login_redirect($redirect_to, $request, $user) {
    if ( is_wp_error( $user ) ) {
        return $redirect_to;
    }

    if ( isset($user->roles) && in_array('situr_user', (array)$user->roles) ) {
        return home_url('/panel-situr/');
    }

    return $redirect_to;
}
add_filter('login_redirect', 'situr_login_redirect', 10, 3);

/**
 * 7) Shortcode: formulario público de registro para crear usuarios SITUR
 *    Uso: [situr_register_form]
 *    Campos mínimos: user_login, user_email, password (opcional -> WP genera)
 */
function situr_register_form_shortcode() {
    if ( is_user_logged_in() ) {
        return '<p>' . __('Ya has iniciado sesión.', 'situr-users') . '</p>';
    }

    $errors = [];
    $success = '';

    if ( isset($_POST['situr_register_nonce']) && wp_verify_nonce($_POST['situr_register_nonce'], 'situr_register_action') ) {

        $username = isset($_POST['situr_user_login']) ? sanitize_user($_POST['situr_user_login']) : '';
        $email    = isset($_POST['situr_user_email']) ? sanitize_email($_POST['situr_user_email']) : '';
        $password = isset($_POST['situr_user_pass']) ? $_POST['situr_user_pass'] : '';

        // Validaciones básicas
        if ( empty($username) ) $errors[] = __('El usuario es obligatorio.', 'situr-users');
        if ( empty($email) || ! is_email($email) ) $errors[] = __('Correo inválido.', 'situr-users');

        if ( username_exists($username) ) $errors[] = __('El nombre de usuario ya existe.', 'situr-users');
        if ( email_exists($email) ) $errors[] = __('El correo ya está registrado.', 'situr-users');

        if ( empty($errors) ) {
            // Crear password si no viene
            if ( empty($password) ) {
                $password = wp_generate_password( 12, false );
            }

            $userdata = [
                'user_login' => $username,
                'user_email' => $email,
                'user_pass'  => $password,
                'role'       => 'situr_user',
            ];

            $user_id = wp_insert_user( $userdata );

            if ( is_wp_error($user_id) ) {
                $errors[] = $user_id->get_error_message();
            } else {
                // Campos extra opcionales
                if ( isset($_POST['documento_situr']) ) update_user_meta($user_id, 'documento_situr', sanitize_text_field($_POST['documento_situr']));
                if ( isset($_POST['telefono_situr']) )  update_user_meta($user_id, 'telefono_situr', sanitize_text_field($_POST['telefono_situr']));
                if ( isset($_POST['empresa_situr']) )   update_user_meta($user_id, 'empresa_situr', sanitize_text_field($_POST['empresa_situr']));
                if ( isset($_POST['codigo_situr']) )    update_user_meta($user_id, 'codigo_situr', sanitize_text_field($_POST['codigo_situr']));

                // Enviar correo de bienvenida (opcional)
                $sit_msg  = sprintf(__('Hola %s, tu usuario SITUR ha sido creado. Accede con: %s', 'situr-users'), $username, wp_login_url());
                wp_mail($email, __('Bienvenido a SITUR', 'situr-users'), $sit_msg);

                $success = '<div class="situr-success">'.__('Registro completado. Revisa tu correo.', 'situr-users').'</div>';
            }
        }
    }

    ob_start();
    if ( ! empty($errors) ) {
        echo '<div class="situr-errors"><ul>';
        foreach ($errors as $e) echo '<li>' . esc_html($e) . '</li>';
        echo '</ul></div>';
    }

    echo $success;
    ?>
    <form method="post" class="situr-register-form">
        <?php wp_nonce_field('situr_register_action', 'situr_register_nonce'); ?>

        <p>
            <label for="situr_user_login"><?php _e('Usuario', 'situr-users'); ?></label><br/>
            <input type="text" name="situr_user_login" id="situr_user_login" value="<?php echo isset($_POST['situr_user_login']) ? esc_attr($_POST['situr_user_login']) : ''; ?>" />
        </p>

        <p>
            <label for="situr_user_email"><?php _e('Correo', 'situr-users'); ?></label><br/>
            <input type="email" name="situr_user_email" id="situr_user_email" value="<?php echo isset($_POST['situr_user_email']) ? esc_attr($_POST['situr_user_email']) : ''; ?>" />
        </p>

        <p>
            <label for="situr_user_pass"><?php _e('Contraseña (opcional)', 'situr-users'); ?></label><br/>
            <input type="password" name="situr_user_pass" id="situr_user_pass" />
            <br/><small><?php _e('Si no ingresas contraseña, se generará una automáticamente y se enviará por correo.', 'situr-users'); ?></small>
        </p>

        <hr/>

        <p>
            <label for="documento_situr"><?php _e('Documento (opcional)', 'situr-users'); ?></label><br/>
            <input type="text" name="documento_situr" id="documento_situr" value="<?php echo isset($_POST['documento_situr']) ? esc_attr($_POST['documento_situr']) : ''; ?>" />
        </p>

        <p>
            <label for="telefono_situr"><?php _e('Teléfono (opcional)', 'situr-users'); ?></label><br/>
            <input type="text" name="telefono_situr" id="telefono_situr" value="<?php echo isset($_POST['telefono_situr']) ? esc_attr($_POST['telefono_situr']) : ''; ?>" />
        </p>

        <p>
            <label for="empresa_situr"><?php _e('Empresa (opcional)', 'situr-users'); ?></label><br/>
            <input type="text" name="empresa_situr" id="empresa_situr" value="<?php echo isset($_POST['empresa_situr']) ? esc_attr($_POST['empresa_situr']) : ''; ?>" />
        </p>

        <p>
            <label for="codigo_situr"><?php _e('Código SITUR (opcional)', 'situr-users'); ?></label><br/>
            <input type="text" name="codigo_situr" id="codigo_situr" value="<?php echo isset($_POST['codigo_situr']) ? esc_attr($_POST['codigo_situr']) : ''; ?>" />
        </p>

        <p>
            <button type="submit"><?php _e('Crear cuenta SITUR', 'situr-users'); ?></button>
        </p>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('situr_register_form', 'situr_register_form_shortcode');

/**
 * Shortcode: Dashboard SITUR
 * Uso: [situr_users]
 */
add_shortcode('situr_users', function() {
    ob_start();

    $file = plugin_dir_path(__FILE__) . 'situr-users.php';

    if (file_exists($file)) {
        include $file;
    } else {
        echo "<p>No se encontró el archivo situr-users.php</p>";
    }

    return ob_get_clean();
});
