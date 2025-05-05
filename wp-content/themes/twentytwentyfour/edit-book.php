<?php
/* Template Name: Edit Book */

wp_head();
?>
<header class="wp-block-template-part">
    <?php echo do_blocks('<!-- wp:template-part {"slug":"header","theme":"twentytwentyfour","tagName":"header"} /-->'); ?>
</header>
<?php

if (isset($_GET['book'])) {
    $book_slug = sanitize_text_field($_GET['book']);
    $book = get_page_by_path($book_slug, OBJECT, 'book');

    if ($book) {
        $book_id = $book->ID;
        $title = esc_attr($book->post_title);
        $content = esc_textarea(html_entity_decode($book->post_content));

        $selected_genres = wp_get_post_terms($book_id, 'genre', array('fields' => 'ids'));
        $all_genres = get_terms(array('taxonomy' => 'genre', 'hide_empty' => false));
        $single_book_url = get_permalink($book_id);
        $listing_page = get_page_by_path('book-listings');
        $listing_page_url = $listing_page ? get_permalink($listing_page->ID) : home_url('/');
?>
        <div id="ajax-notification" class="hidden"></div>

        <div class="edit-book-wrapper">
            <div class="edit-book-header">
                <button class="back-button" onclick="window.location.href='<?php echo esc_url($single_book_url); ?>'">Back</button>
                <h1 class="edit-book-title">Edit Book</h1>
                <button class="listing-button" onclick="window.location.href='<?php echo esc_url($listing_page_url); ?>'">Back to Listing</button>
            </div>
            <div class="edit-book-container">
                <form id="edit-book-form">
                    <input type="hidden" id="book-id" value="<?php echo $book_id; ?>">

                    <label>Title:</label>
                    <input type="text" id="book-title" value="<?php echo $title; ?>">

                    <label>Content:</label>
                    <textarea id="book-content"><?php echo $content; ?></textarea>

                    <label>Genre:</label>
                    <select id="book-genre">
                        <?php foreach ($all_genres as $genre) { ?>
                            <option value="<?php echo $genre->term_id; ?>" 
                                <?php echo in_array($genre->term_id, $selected_genres) ? 'selected' : ''; ?>>
                                <?php echo esc_html($genre->name); ?>
                            </option>
                        <?php } ?>
                    </select>

                    <button type="submit">Update Book</button>
                </form>
            </div>
        </div>
<?php
    } else {
        ?>
        <!-- // echo "<p>Book not found.</p>"; -->
        <div class="error-container"><p>Book not found.</p></div>
        <?php
    }
} else {
    ?>
    <!-- echo "<p>No book specified.</p>"; -->
    <div class="error-container"><p>No book specified.</p></div>
    <?php
}
?>
<footer class="wp-block-template-part">
    <?php echo do_blocks('<!-- wp:template-part {"slug":"footer","theme":"twentytwentyfour","tagName":"footer"} /-->'); ?>
</footer>

<?php wp_footer(); ?>

