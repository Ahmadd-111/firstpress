<?php
/**
 * Plugin Name: AJAX CPT Loader
 * Description: A plugin to dynamically load custom post type (CPT) posts using AJAX.
 * Version: 1.0
 * Author: Ahmad Raza
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'includes/cpt.php';
require_once plugin_dir_path(__FILE__) . 'includes/admin-page.php';
require_once plugin_dir_path(__FILE__) . 'includes/ajax-handlers.php';

function ajax_cpt_loader_enqueue_scripts($hook) {
    if ($hook !== 'toplevel_page_ajax_cpt_loader') {
        return;
    }

    wp_enqueue_script('ajax-cpt-loader-script', plugin_dir_url(__FILE__) . 'assets/script.js', ['jquery'], null, true);
    wp_localize_script('ajax-cpt-loader-script', 'ajaxCPT', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('ajax_cpt_nonce'),
    ]);
}
add_action('admin_enqueue_scripts', 'ajax_cpt_loader_enqueue_scripts');
