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
    wp_enqueue_script('jquery');
    wp_enqueue_style('ajax-cpt-loader-css', plugin_dir_url(__FILE__) . 'assets/style.css');
    wp_enqueue_script('ajax-cpt-loader-js', plugin_dir_url(__FILE__) . 'assets/script.js', array('jquery'), null, true);

    wp_localize_script('ajax-cpt-loader-js', 'ajaxCPT', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'ajax_cpt_loader_enqueue_scripts');
add_action('admin_enqueue_scripts', 'ajax_cpt_loader_enqueue_scripts'); 

function custom_api_book_details() {
    register_rest_route('custom/v1', '/book/(?P<id>\d+)', [
        'methods'  => 'GET',
        'callback' => 'get_book_details',
        'permission_callback' => '__return_true'
    ]);
}
add_action('rest_api_init', 'custom_api_book_details');

function get_book_details($request) {
    $book_id = $request['id'];
    $book = get_post($book_id);

    if (!$book || $book->post_type !== 'book') {
        return new WP_Error('no_book', 'Book not found', ['status' => 404]);
    }

    return [
        'id'      => $book->ID,
        'title'   => get_the_title($book_id),
        'content' => apply_filters('the_content', $book->post_content),
        'genre'   => wp_get_post_terms($book_id, 'genre', ['fields' => 'names']),
        'thumbnail' => get_the_post_thumbnail_url($book_id, 'full')
    ];
}

function create_custom_role() {
    add_role('Book_manager', 'Book Manager', array(
        'read' => true,
        'edit_posts' => true, 
        'delete_posts' => true, 
        'publish_posts' => true, 
        'edit_pages' => true,
        'upload_files' => true,
    ));
}
add_action('init', 'create_custom_role');

?>
