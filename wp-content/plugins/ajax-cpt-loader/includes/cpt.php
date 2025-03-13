<?php
function create_books_cpt() {
    register_post_type('book', array(
        'labels' => array(
            'name' => 'Books',
            'singular_name' => 'Book',
            'add_new' => 'Add New Book',
            'add_new_item' => 'Add New Book',
            'edit_item' => 'Edit Book',
            'new_item' => 'New Book',
            'view_item' => 'View Book',
            'all_items' => 'All Books',
            'search_items' => 'Search Books',
            'not_found' => 'No books found.',
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-book', // Icon for better UI
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'custom-fields'),
        'rewrite' => array('slug' => 'book', 'with_front' => false),
        'show_in_rest' => true, // Enable Gutenberg support
    ));

    // Register Genre Taxonomy
    register_taxonomy('genre', 'book', array(
        'label' => 'Genre',
        'rewrite' => array('slug' => 'genre'),
        'hierarchical' => true,
        'show_admin_column' => true, // Display in book editor sidebar
        'show_in_rest' => true,
    ));
}
add_action('init', 'create_books_cpt');

?>
