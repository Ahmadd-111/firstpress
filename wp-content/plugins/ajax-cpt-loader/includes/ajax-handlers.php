<?php
function ajax_cpt_loader_fetch_books() {
    check_ajax_referer('ajax_cpt_nonce', 'security');

    $query = new WP_Query(['post_type' => 'book', 'posts_per_page' => -1]);
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            echo '<div class="book-item" data-id="' . get_the_ID() . '">';
            echo '<h3>' . get_the_title() . '</h3>';
            echo '<button class="edit-book">Edit</button>';
            echo '</div>';
        }
    } else {
        echo 'No books found.';
    }
    wp_die();
}
add_action('wp_ajax_ajax_cpt_loader_fetch_books', 'ajax_cpt_loader_fetch_books');

function ajax_cpt_loader_update_book() {
    check_ajax_referer('ajax_cpt_nonce', 'security');

    $book_id = intval($_POST['book_id']);
    $new_title = sanitize_text_field($_POST['new_title']);

    if ($book_id && $new_title) {
        wp_update_post([
            'ID'         => $book_id,
            'post_title' => $new_title,
        ]);
        echo 'Book updated!';
    } else {
        echo 'Failed to update.';
    }
    wp_die();
}
add_action('wp_ajax_ajax_cpt_loader_update_book', 'ajax_cpt_loader_update_book');

