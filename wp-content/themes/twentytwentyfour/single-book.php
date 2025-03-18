<?php
/**
 * Template Name: Display single book
 */
wp_head();
?>
<header class="wp-block-template-part">
    <?php echo do_blocks('<!-- wp:template-part {"slug":"header","theme":"twentytwentyfour","tagName":"header"} /-->'); ?>
</header>
<?php

if (have_posts()) :
    while (have_posts()) : the_post();
        $book_slug = get_post_field('post_name', get_the_ID());
        $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'large'); // Get large thumbnail
        $genres = wp_get_post_terms(get_the_ID(), 'genre', array('fields' => 'names')); // Get Genre taxonomy
?>
    <div class="single-book-wrapper">
        <div class="single-book-container">
            <div class="book-cover">
                <?php if ($thumbnail_url): ?>
                    <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php the_title_attribute(); ?>">
                <?php endif; ?>
            </div>

            <div class="book-details">
                <div class="book-title-container">
                    <h1 class="book-title"><?php the_title(); ?></h1>
                    <button class="edit-book-btn edit-book" data-slug="<?php echo esc_attr($book_slug); ?>">Edit</button>
                </div>

                <!-- <p class="book-genre"><strong>Genre:</strong> <?php echo (!empty($genres)) ? implode(', ', $genres) : 'No Genre'; ?></p> -->
                <p class="book-genre">
                    <strong>Genre :</strong> 
                    <span><?php echo (!empty($genres)) ? implode(', ', $genres) : 'No Genre';; ?></span>
                </p>


                <div class="book-content"><?php the_content(); ?></div>
            </div>

        </div>
    </div>
<?php
    endwhile;
endif;
?>


<footer class="wp-block-template-part">
    <?php echo do_blocks('<!-- wp:template-part {"slug":"footer","theme":"twentytwentyfour","tagName":"footer"} /-->'); ?>
</footer>

<?php wp_footer(); ?>
