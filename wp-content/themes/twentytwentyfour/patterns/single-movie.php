<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <h1><?php the_title(); ?></h1>
    <p>Director: <?php echo get_post_meta(get_the_ID(), 'movie_director', true); ?></p>
    <p>Release Year: <?php echo get_post_meta(get_the_ID(), 'movie_release_year', true); ?></p>

    <!-- Display Movie Categories -->
    <p>Categories: 
        <?php 
        $categories = get_the_terms(get_the_ID(), 'movie_category'); 
        if ($categories) {
            foreach ($categories as $category) {
                echo '<a href="' . get_term_link($category) . '">' . $category->name . '</a> ';
            }
        }
        ?>
    </p>

    <p><?php the_content(); ?></p>
    <?php if (has_post_thumbnail()) { the_post_thumbnail('large'); } ?>
<?php endwhile; endif; ?>
<?php get_footer(); ?>