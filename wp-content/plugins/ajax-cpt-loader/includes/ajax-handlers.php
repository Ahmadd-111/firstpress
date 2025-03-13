<?php
// Fetch Books
// function fetch_books_ajax() {
//     $query = new WP_Query(array('post_type' => 'book', 'posts_per_page' => -1));
//     if ($query->have_posts()) :
//         while ($query->have_posts()) : $query->the_post();
//             $id = get_the_ID();
//             $title = get_the_title();
//             $content = get_the_content();
//             $genre = get_the_terms($id, 'genre') ? wp_list_pluck(get_the_terms($id, 'genre'), 'name') : array();

//             echo "<div class='book-item' data-id='$id'>
//                     <h3>$title</h3>
//                     <p>$content</p>
//                     <p><strong>Genre:</strong> " . implode(', ', $genre) . "</p>
//                     <button class='view-book' data-slug='" . get_post_field('post_name', $id) . "'>View</button>
//                 </div>";
//         endwhile;
//         wp_reset_postdata();
//     else:
//         echo '<p>No books found.</p>';
//     endif;

//     wp_die();
// }

// Fetch Books
function fetch_books_ajax() {
    $query = new WP_Query(array('post_type' => 'book', 'posts_per_page' => -1));
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $id = get_the_ID();
            $title = get_the_title();
            $content = get_the_content();
            $slug = get_post_field('post_name', $id); // Get the slug
            $genre = get_the_terms($id, 'genre') ? wp_list_pluck(get_the_terms($id, 'genre'), 'name') : array();

            echo "<div class='book-item' data-id='$id'>
                    <h3>$title</h3>
                    <p>$content</p>
                    <p><strong>Genre:</strong> " . implode(', ', $genre) . "</p>
                    <button class='view-book' data-slug='$slug'>View</button>
                </div>";
        endwhile;
        wp_reset_postdata();
    else:
        echo '<p>No books found.</p>';
    endif;

    wp_die();
}
add_action('wp_ajax_fetch_books', 'fetch_books_ajax');
add_action('wp_ajax_nopriv_fetch_books', 'fetch_books_ajax');

// Update Book
function update_book_ajax() {
    $post_id = intval($_POST['id']);
    $title = sanitize_text_field($_POST['title']);
    $content = sanitize_textarea_field($_POST['content']);

    wp_update_post([
        'ID' => $post_id,
        'post_title' => $title,
        'post_content' => $content
    ]);

    echo "Book Updated Successfully!";
    wp_die();
}
add_action('wp_ajax_update_book', 'update_book_ajax');
add_action('wp_ajax_nopriv_update_book', 'update_book_ajax');


?>
