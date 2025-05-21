<?php
defined('ABSPATH') || exit;

/**
 * Register settings page under Settings menu
 */
function scl_add_contributor_notification_settings_page() {
    add_options_page(
        'Contributors Post Notifications',
        'Contributors Post Notifications',
        'manage_options',
        'contributors-post-notifications',
        'scl_render_contributor_notifications_settings_page'
    );
}
add_action('admin_menu', 'scl_add_contributor_notification_settings_page');

/**
 * Register setting
 */
function scl_register_contributor_notifications_setting() {
    register_setting('scl_contributor_notifications_group', 'contributor_post_notification_emails', [
        'type'              => 'string',
        'sanitize_callback' => 'scl_sanitize_email_string',
        'default'           => ''
    ]);
}
add_action('admin_init', 'scl_register_contributor_notifications_setting');

/**
 * Sanitize input and set transient if invalid emails are skipped
 */
function scl_sanitize_email_string($input) {
    $emails = explode(',', $input);
    $clean_emails = [];
    $invalid_emails = [];

    foreach ($emails as $email) {
        $email = trim($email);
        if ($email === '') {
            continue;
        }
        if (is_email($email)) {
            $clean_emails[] = $email;
        } else {
            $invalid_emails[] = $email;
        }
    }

    if (!empty($invalid_emails)) {
        // Store notice for one-time display
        set_transient('scl_invalid_email_notice', implode(', ', $invalid_emails), 10);
    }

    return implode(', ', $clean_emails);
}

/**
 * Show admin notice for invalid emails
 */
function scl_invalid_email_admin_notice() {
    if ($invalid = get_transient('scl_invalid_email_notice')) {
        delete_transient('scl_invalid_email_notice');
        ?>
        <div class="notice notice-warning is-dismissible">
            <p><strong>Warning:</strong> The following emails were invalid and not saved: <?php echo esc_html($invalid); ?></p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'scl_invalid_email_admin_notice');

/**
 * Render settings page
 */
function scl_render_contributor_notifications_settings_page() {
    ?>
    <div class="wrap">
        <h1>Contributors Post Review Email Setting</h1>
        <p style="font-size: 15px; margin-bottom: 30px ;margin-top: 30px;">
            <strong>Enter the email addresses (comma-separated) of senior editors who should receive notifications when an External Contributor submits a post for review.</strong>
        </p>
        <form method="post" action="options.php">
            <?php
            settings_fields('scl_contributor_notifications_group');
            do_settings_sections('scl_contributor_notifications_group');
            $emails = esc_attr(get_option('contributor_post_notification_emails', ''));
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Notification Emails</th>
                    <td>
                        <input
                            type="text"
                            name="contributor_post_notification_emails"
                            value="<?php echo $emails; ?>"
                            class="regular-text"
                            style="width: 800px; margin-top: 8px;"
                        />
                        <p class="description" style="font-size: 14px;">
                            Separate multiple emails with commas (e.g., editor@example.com, reviewer@example.com)
                        </p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
