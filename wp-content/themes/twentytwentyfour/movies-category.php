<?php
// Ensure styles and scripts load properly
wp_head();
?>
<header class="wp-block-template-part">
    <?php echo do_blocks('<!-- wp:template-part {"slug":"header","theme":"twentytwentyfour","tagName":"header"} /-->'); ?>
</header>

<?php 
$category = get_queried_object(); 
echo "<h1>Movies in Category: " . $category->name . "</h1>";
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div>
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <p>Director: <?php echo get_post_meta(get_the_ID(), 'movie_director', true); ?></p>
        <p>Release Year: <?php echo get_post_meta(get_the_ID(), 'movie_release_year', true); ?></p>
        <p><?php the_excerpt(); ?></p>
        <?php if (has_post_thumbnail()) { the_post_thumbnail('medium'); } ?>
    </div>
<?php endwhile; else: ?>
    <p>No movies found in this category.</p>
<?php endif; ?>

<footer class="wp-block-template-part">
    <?php echo do_blocks('<!-- wp:template-part {"slug":"footer","theme":"twentytwentyfour","tagName":"footer"} /-->'); ?>
</footer>

<?php wp_footer(); ?>
