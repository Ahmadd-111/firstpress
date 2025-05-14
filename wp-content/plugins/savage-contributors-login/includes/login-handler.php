<?php
defined('ABSPATH') || exit;

function scl_process_contributor_login() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['scl_login_nonce'])) {
        return;
    }

    // Verify nonce
    if (!wp_verify_nonce($_POST['scl_login_nonce'], 'scl_contributor_login')) {
        wp_die('Security check failed.');
    }

    $errors = [];

    // Get form data
    $username = sanitize_text_field($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    // $remember = isset($_POST['rememberme']) ? true : false;

    $contributor_usernames = get_option('contributors_usernames', '');
    $contributor_roles = get_option('contributors_roles', []);

    // Validate inputs
    if (empty($username)) {
        $errors[] = 'Username is required.';
    }
    if (empty($password)) {
        $errors[] = 'Password is required.';
    }

    $allowed_usernames = explode(',', $contributor_usernames);
    if (!in_array($username, $allowed_usernames)) {
        $user = get_user_by('login', $username);
        if ($user && !array_intersect($contributor_roles, $user->roles)) {
            $errors[] = 'You do not have permission to log in here.';
        }
    }

    if (empty($errors)) {
        // Attempt to log in
        $creds = [
            'user_login' => $username,
            'user_password' => $password,
            // 'remember' => $remember,
        ];

        $user = wp_signon($creds, is_ssl());

        if (is_wp_error($user)) {
            $errors[] = 'Invalid username or password.';
        } else {
            wp_redirect(admin_url());
            exit;
        }
    }

    set_transient('scl_login_errors', $errors, 30);
}
add_action('init', 'scl_process_contributor_login');