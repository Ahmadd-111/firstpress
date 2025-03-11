<?php get_header(); ?>
<h1>Movies List</h1>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div>
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
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

        <p><?php the_excerpt(); ?></p>
        <?php if (has_post_thumbnail()) { the_post_thumbnail('medium'); } ?>
    </div>
<?php endwhile; endif; ?>
<?php get_footer(); ?>
