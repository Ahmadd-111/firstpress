<?php
// Shortcode to Display Book List
function ajax_books_list_shortcode() {
    ob_start();
    ?>
    <div id="book-listing">
        <button id="load-books">Load Books</button>
        <div id="books-container"></div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('ajax_books_list', 'ajax_books_list_shortcode');
?>
