<?php
defined('ABSPATH') || exit;

/**
 * Hide specific admin menu items for external_contributor role
 */
function scl_restrict_admin_menus_for_external_contributor() {
    $user = wp_get_current_user();
    if (empty($user->roles) || !in_array('external_contributor', $user->roles)) {
        return;
    }

    // Remove top-level menus by slug
    remove_menu_page('jetpack');
    remove_menu_page('quillt');
    remove_menu_page('edit-tags.php?taxonomy=category&post_type=page');

    // Remove custom post types
    remove_menu_page('edit.php?post_type=social');
    remove_menu_page('edit.php?post_type=affiliate_product');
    remove_menu_page('edit.php?post_type=vice_section');  
    remove_menu_page('edit.php?post_type=sp_product');  
    remove_menu_page('edit.php?post_type=profile'); 

    // Remove StockPack settings
    remove_submenu_page('options-general.php', 'stockpack');
}
add_action('admin_menu', 'scl_restrict_admin_menus_for_external_contributor', 999);

/**
 * Remove "+ New" menu from admin bar for external_contributor
 */
function scl_remove_new_content_menu_for_external_contributor($wp_admin_bar) {
    $user = wp_get_current_user();
    if (empty($user->roles) || !in_array('external_contributor', $user->roles)) {
        return;
    }

    $wp_admin_bar->remove_node('new-content');
    $wp_admin_bar->remove_node('wpseo-menu');
    $wp_admin_bar->remove_node('query-monitor');
    $wp_admin_bar->remove_node('query-monitor-placeholder');
}
add_action('admin_bar_menu', 'scl_remove_new_content_menu_for_external_contributor', 9999);

/**
 * Completely disable Query Monitor for external_contributor users.
 */
add_action('plugins_loaded', function () {
    if (!is_user_logged_in()) {
        return;
    }

    $user = wp_get_current_user();
    if (empty($user->roles) || !in_array('external_contributor', $user->roles)) {
        return;
    }
    remove_action('init', ['QueryMonitor', 'init'], 0);
    remove_all_actions('plugins_loaded', 1);
    add_filter('qm/collectors', '__return_empty_array', PHP_INT_MAX);
}, 0);