<?php
defined('ABSPATH') || exit;

function scl_contributor_login_shortcode($atts) {
    if (defined('REST_REQUEST') && REST_REQUEST) {
        return '';
    }
    if (is_user_logged_in() && !is_admin()) {
        wp_redirect(admin_url());
        exit;
    }

    $errors = ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wp-submit'])) ? (get_transient('scl_login_errors') ?: []) : [];
    delete_transient('scl_login_errors');

    ob_start();
    ?>
    <div id="scl-login" class="scl-login-form">
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo esc_html($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form id="scl-loginform" method="post" action="">
            <p>
                <label for="scl_user_login"><?php _e('Username or Email Address', 'savage-contributors-login'); ?></label>
                <input type="text" name="username" id="scl_user_login" class="input" value="<?php echo esc_attr($_POST['username'] ?? ''); ?>" size="20" autocapitalize="off">
            </p>
            <p class="password-wrapper">
                <label for="scl_user_pass"><?php _e('Password', 'savage-contributors-login'); ?></label>
                <input type="password" name="password" id="scl_user_pass" class="input" value="" size="20">
                <span class="toggle-password" onclick="togglePasswordVisibility('scl_user_pass')">
                    <svg class="eye" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg>
                    <svg class="eye-slash" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM262.3 149.7C286.6 125.5 320 112 320 112s53.4 13.5 77.7 37.7c24.2 24.2 37.7 57.6 37.7 77.7s-13.5 53.4-37.7 77.7L262.3 149.7zm-44.6-44.6l134 134.4c24.2-24.2 37.7-57.6 37.7-77.7s-13.5-53.4-37.7-77.7c-24.2-24.2-57.6-37.7-77.7-37.7s-53.4 13.5-77.7 37.7c6 6 12.1 12.1 21.4 21.4zm186.9 346.2L289.4 336c-24.2 24.2-57.6 37.7-77.7 37.7s-53.4-13.5-77.7-37.7c-24.2-24.2-37.7-57.6-37.7-77.7s13.5-53.4 37.7-77.7L23 68.8c-44.2 34.5-81.1 76.5-103.2 110.8c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C65.5 379.2 130.2 416 211 416c68.2 0 125-26.3 169.3-60.8z"/></svg>
                </span>
            </p>
            <p class="submit">
                <input type="submit" name="wp-submit" id="scl_wp-submit" value="<?php _e('Log In', 'savage-contributors-login'); ?>">
                <?php wp_nonce_field('scl_contributor_login', 'scl_login_nonce'); ?>
            </p>
        </form>
    </div>

    <style>
        .scl-login-form {
            width: 340px;
            margin: 40px auto;
            padding: 30px 28px 50px;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,.15);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
        }
        .scl-login-form h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .scl-login-form p {
            margin-bottom: 20px;
        }
        .scl-login-form label {
            display: block;
            margin-bottom: 6px;
            color: #333;
            font-size: 14px;
        }
        .scl-login-form input[type="text"],
        .scl-login-form input[type="password"] {
            width: 100%;
            padding: 8px 10px;
            font-size: 16px;
            border: 1px solid #ccd0d4;
            border-radius: 4px;
            box-shadow: inset 0 1px 2px rgba(0,0,0,.05);
            box-sizing: border-box;
        }
        .scl-login-form input[type="text"]:focus,
        .scl-login-form input[type="password"]:focus {    
            outline: 1px solid #2271b1;
        }
        .scl-login-form .password-wrapper {
            position: relative;
        }
        .scl-login-form .toggle-password {
            position: absolute;
            right: 10px;
            top: 38px;
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        .scl-login-form .toggle-password .eye {
            display: block;
            width: 20px;
            height: 20px;
            fill: #777;
        }
        .scl-login-form .toggle-password .eye-slash {
            display: none;
            width: 20px;
            height: 20px;
            fill: #777;
        }
        .scl-login-form .toggle-password.show .eye {
            display: none;
        }
        .scl-login-form .toggle-password.show .eye-slash {
            display: block;
        }
        .scl-login-form input[type="checkbox"] {
            margin-right: 6px;
        }
        .scl-login-form .submit {
            text-align: right;
        }
        .scl-login-form input[type="submit"] {
            background: #2271b1;
            color: #fff;
            border: none;
            padding: 8px 20px;
            font-size: 14px;
            border-radius: 3px;
            cursor: pointer;
        }
        .scl-login-form input[type="submit"]:hover {
            background: #135e96;
        }
        .scl-login-form .error {
            padding: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #d63638;
            background: #fff;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
            font-size: 13px;
        }
        .scl-login-form .error p {
            margin: 0 0 8px;
        }
        .scl-login-form .error p:last-child {
            margin-bottom: 0;
        }
    </style>
    <script>
        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            const toggle = input.nextElementSibling;
            if (input.type === 'password') {
                input.type = 'text';
                toggle.classList.add('show');
            } else {
                input.type = 'password';
                toggle.classList.remove('show');
            }
        }
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('contributor_login_form', 'scl_contributor_login_shortcode');