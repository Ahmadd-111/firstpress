<?php
/*
Template Name: Search Test Page
*/
get_header();
?>

<main style="padding: 2rem;">
    <h2>Test Search Form</h2>
    <?php get_search_form(); ?>

    <?php if ( have_posts() ) : ?>
        <h3>Search Results:</h3>
        <ul>
        <?php while ( have_posts() ) : the_post(); ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
        <?php endwhile; ?>
        </ul>
    <?php elseif ( is_search() ) : ?>
        <p>No results found.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
