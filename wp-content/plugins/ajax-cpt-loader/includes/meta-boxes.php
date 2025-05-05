<?php
// Add Custom Meta Box for Book Details
function book_meta_boxes() {
    add_meta_box('book_details', 'Book Details', 'book_meta_callback', 'book', 'normal', 'high');
}
add_action('add_meta_boxes', 'book_meta_boxes');

// Callback Function to Show Fields
function book_meta_callback($post) {
    wp_nonce_field('save_book_meta', 'book_meta_nonce');
    $author = get_post_meta($post->ID, 'book_author', true);
    ?>
    <p>
        <label for="book_author">Author Name:</label>
        <input type="text" id="book_author" name="book_author" value="<?php echo esc_attr($author); ?>" style="width:100%;" />
    </p>
    <?php
}

// Save Meta Box Data
function save_book_meta($post_id) {
    if (!isset($_POST['book_meta_nonce']) || !wp_verify_nonce($_POST['book_meta_nonce'], 'save_book_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (isset($_POST['book_author'])) {
        update_post_meta($post_id, 'book_author', sanitize_text_field($_POST['book_author']));
    }
}
add_action('save_post', 'save_book_meta');
