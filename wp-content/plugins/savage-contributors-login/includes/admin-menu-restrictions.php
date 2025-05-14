<?php
defined('ABSPATH') || exit;

/**
 * Hide specific admin menu items for external_contributor role
 */
function scl_restrict_admin_menus_for_external_contributor() {
    if (!current_user_can('external_contributor')) {
        return;
    }

    // Remove Quillt menu
    remove_menu_page('quillt_feature_settings_affiliate');

    // Remove custom post types
    remove_menu_page('edit.php?post_type=social');        
    remove_menu_page('edit.php?post_type=affiliate_product');

    // Remove StockPack settings
    remove_submenu_page('options-general.php', 'stockpack');
}
add_action('admin_menu', 'scl_restrict_admin_menus_for_external_contributor', 99);

/**
 * Remove "+ New" menu from admin bar for external_contributor
 */
function scl_remove_new_content_menu_for_external_contributor($wp_admin_bar) {
    if (!current_user_can('external_contributor')) {
        return;
    }

    $wp_admin_bar->remove_node('new-content'); // This removes the entire + New dropdown
    $wp_admin_bar->remove_node('wpseo-menu'); // Yoast SEO admin bar menu node
}
add_action('admin_bar_menu', 'scl_remove_new_content_menu_for_external_contributor', 999);

