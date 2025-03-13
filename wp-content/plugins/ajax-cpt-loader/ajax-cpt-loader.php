<?php
/**
 * Plugin Name: AJAX CPT Loader
 * Description: A plugin to manage Books CPT with AJAX-based listing and editing.
 * Version: 1.0
 * Author: Ahmad Raza
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'includes/cpt.php';
require_once plugin_dir_path(__FILE__) . 'includes/admin-page.php';
require_once plugin_dir_path(__FILE__) . 'includes/ajax-handlers.php';
require_once plugin_dir_path(__FILE__) . 'includes/meta-boxes.php';

function ajax_cpt_loader_enqueue_scripts() {
    wp_enqueue_script('ajax-cpt-loader-js', plugin_dir_url(__FILE__) . 'assets/script.js', array('jquery'), null, true);
    wp_localize_script('ajax-cpt-loader-js', 'ajaxCPT', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'ajax_cpt_loader_enqueue_scripts');
?>
