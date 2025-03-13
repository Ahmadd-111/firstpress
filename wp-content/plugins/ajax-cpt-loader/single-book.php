<?php
get_header();
if (have_posts()) : while (have_posts()) : the_post();
    $book_id = get_the_ID();
?>
    <div class="single-book">
        <h1><?php the_title(); ?></h1>
        <p><?php the_content(); ?></p>
        <p><strong>Genre:</strong> <?php echo get_the_term_list($book_id, 'genre', '', ', '); ?></p>

        <button id="back-to-list">Back to Listing</button>
        <button id="edit-book" data-id="<?php echo $book_id; ?>">Edit Book</button>

        <div id="edit-form" style="display:none;">
            <input type="text" id="edit-title" value="<?php the_title(); ?>">
            <textarea id="edit-content"><?php the_content(); ?></textarea>
            <button id="save-edit" data-id="<?php echo $book_id; ?>">Save</button>
        </div>
    </div>
<?php
endwhile; endif;
get_footer();
?>
