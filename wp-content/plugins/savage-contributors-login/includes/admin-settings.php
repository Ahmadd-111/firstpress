<?php
defined('ABSPATH') || exit;

// Add admin menu
add_action('admin_menu', function() {
    add_menu_page(
        __('Contributors Login', 'savage-contributors-login'),
        __('Contributors Login', 'savage-contributors-login'),
        'manage_options',
        'scl-settings',
        'scl_settings_page',
        'dashicons-admin-users',
        80
    );
});

add_action('admin_enqueue_scripts', function($hook) {
    if ($hook !== 'toplevel_page_scl-settings') {
        return;
    }
    wp_enqueue_style('select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', [], '4.1.0');
    wp_enqueue_script('select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', ['jquery'], '4.1.0', true);
    wp_add_inline_script('select2', 'jQuery(document).ready(function($) { $("#contributors_roles").select2({ placeholder: "' . esc_js(__('Select roles', 'savage-contributors-login')) . '", allowClear: true }); });');
    wp_add_inline_style('select2', '
        #scl_shortcode_message {
            width: 800px;
            background: #f1f1f1;
            padding: 15px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            text-align: left;
        }
        #scl_shortcode_message p {
            margin: 0;
            font-size: 14px;
        }
        #contributors_usernames {
            width: 800px;
            padding: 10px;
            font-size: 14px;
            line-height: 1.5;
            height: 40px;
        }
        .select2-container {
            width: 800px !important;
        }
        .select2-selection--multiple {
            padding: 8px;
            font-size: 14px;
            line-height: 1.5;
            min-height: 40px;
        }
        .select2-selection__choice {
            margin-top: 4px;
        }
    ');
});

function scl_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Contributors Login Settings', 'savage-contributors-login'); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('scl_settings_group');
            do_settings_sections('scl-settings');
            submit_button();
            ?>
        </form>
        <h2><?php _e('Stored Values (For Testing)', 'savage-contributors-login'); ?></h2>
        <p><strong><?php _e('Usernames:', 'savage-contributors-login'); ?></strong> 
            <?php
            $usernames = get_option('contributors_usernames', '');
            echo !empty($usernames) ? esc_html($usernames) : 'None';
            ?>
        </p>
        <p><strong><?php _e('Roles:', 'savage-contributors-login'); ?></strong> 
            <?php
            $roles = get_option('contributors_roles', []);
            echo !empty($roles) ? esc_html(implode(', ', array_map(function($role) {
                return wp_roles()->get_names()[$role] ?? $role;
            }, $roles))) : 'None';
            ?>
        </p>
    </div>
    <?php
}

add_action('admin_init', function() {
    register_setting('scl_settings_group', 'contributors_usernames', [
        'sanitize_callback' => function($input) {
            // Sanitize full comma-separated string
            if (!is_string($input)) return '';
            $usernames = array_filter(array_map('sanitize_user', array_map('trim', explode(',', $input))));
            return implode(',', $usernames); // Store as string
        },
        'default' => '',
    ]);

    register_setting('scl_settings_group', 'contributors_roles', [
        'sanitize_callback' => function($input) {
            // Store roles as an array, ensuring valid input
            return is_array($input) ? array_map('sanitize_text_field', array_filter($input)) : [];
        },
        'default' => []
    ]);

    add_settings_section(
        'scl_main_section',
        '',
        null,
        'scl-settings'
    );

    add_settings_field(
        'scl_shortcode_message',
        '',
        function() {
            ?>
            <div id="scl_shortcode_message">
                <p>
                    <?php _e('Use this shortcode for creating the login page: <code>[contributor_login_form]</code>', 'savage-contributors-login'); ?>
                </p>
            </div>
            <?php
        },
        'scl-settings',
        'scl_main_section'
    );

    add_settings_field(
        'contributors_usernames',
        __('Usernames', 'savage-contributors-login'),
        function() {
            $usernames = get_option('contributors_usernames', '');
            ?>
            <input type="text" name="contributors_usernames" id="contributors_usernames" value="<?php echo esc_attr($usernames); ?>" placeholder="user1,user2,user3">
            <p class="description"><?php _e('Enter usernames separated by commas.', 'savage-contributors-login'); ?></p>
            <?php
        },
        'scl-settings',
        'scl_main_section'
    );

    add_settings_field(
        'contributors_roles',
        __('Roles', 'savage-contributors-login'),
        function() {
            $selected_roles = get_option('contributors_roles', []);
            $roles = wp_roles()->get_names();
            ?>
            <select name="contributors_roles[]" id="contributors_roles" multiple>
                <?php foreach ($roles as $role_value => $role_name): ?>
                    <option value="<?php echo esc_attr($role_value); ?>" <?php echo in_array($role_value, $selected_roles) ? 'selected' : ''; ?>>
                        <?php echo esc_html($role_name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <p class="description"><?php _e('Select one or more roles.', 'savage-contributors-login'); ?></p>
            <?php
        },
        'scl-settings',
        'scl_main_section'
    );
});