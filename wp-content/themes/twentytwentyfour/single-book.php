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
?>
        <div class="single-book">
            <h1><?php the_title(); ?></h1>
            <div><?php the_content(); ?></div>
            
            <!-- Add Edit Button -->
            <!-- <button id="edit-book" data-slug="<?php echo esc_attr($book_slug); ?>">Edit</button> -->
            <button class="edit-book" data-slug="<?php echo esc_attr($book_slug); ?>">Edit</button>

        </div>
<?php
    endwhile;
endif;
?>
<footer class="wp-block-template-part">
    <?php echo do_blocks('<!-- wp:template-part {"slug":"footer","theme":"twentytwentyfour","tagName":"footer"} /-->'); ?>
</footer>

<?php wp_footer(); ?>
