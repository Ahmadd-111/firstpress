<?php
function ajax_cpt_loader_register_cpt() {
    register_post_type('book', [
        'labels'      => [
            'name'          => 'Books',
            'singular_name' => 'Book',
        ],
        'public'      => true,
        'has_archive' => true,
        'supports'    => ['title', 'editor'],
        'show_in_menu' => false,
    ]);
}
add_action('init', 'ajax_cpt_loader_register_cpt');

// Register a Taxonomy
function ajax_cpt_loader_register_taxonomy() {
    register_taxonomy('genre', 'book', [
        'label'        => 'Genres',
        'rewrite'      => ['slug' => 'genre'],
        'hierarchical' => true,
    ]);
}
add_action('init', 'ajax_cpt_loader_register_taxonomy');
