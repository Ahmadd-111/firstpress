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
        $content = esc_textarea($book->post_content);

        // Get selected genres
        $selected_genres = wp_get_post_terms($book_id, 'genre', array('fields' => 'ids'));
        $all_genres = get_terms(array('taxonomy' => 'genre', 'hide_empty' => false));
?>
        <div id="ajax-notification" class="hidden"></div>

        <div class="edit-book">
            <h1>Edit Book</h1>
            <form id="edit-book-form">
                <input type="hidden" id="book-id" value="<?php echo $book_id; ?>">

                <label>Title:</label>
                <input type="text" id="book-title" value="<?php echo $title; ?>">

                <label>Content:</label>
                <textarea id="book-content"><?php echo $content; ?></textarea>

                <label>Genre:</label>
                <select id="book-genre" multiple>
                    <?php foreach ($all_genres as $genre) { ?>
                        <option value="<?php echo $genre->term_id; ?>" <?php echo in_array($genre->term_id, $selected_genres) ? 'selected' : ''; ?>>
                            <?php echo esc_html($genre->name); ?>
                        </option>
                    <?php } ?>
                </select>

                <button type="submit">Update Book</button>
            </form>
        </div>
<?php
    } else {
        echo "<p>Book not found.</p>";
    }
} else {
    echo "<p>No book specified.</p>";
}
?>
<footer class="wp-block-template-part">
    <?php echo do_blocks('<!-- wp:template-part {"slug":"footer","theme":"twentytwentyfour","tagName":"footer"} /-->'); ?>
</footer>

<?php wp_footer(); ?>

