<?php
/**
 * Twenty Twenty-Four functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Twenty Twenty-Four
 * @since Twenty Twenty-Four 1.0
 */

/**
 * Register block styles.
 */

if ( ! function_exists( 'twentytwentyfour_block_styles' ) ) :
	/**
	 * Register custom block styles
	 *
	 * @since Twenty Twenty-Four 1.0
	 * @return void
	 */
	function twentytwentyfour_block_styles() {

		register_block_style(
			'core/details',
			array(
				'name'         => 'arrow-icon-details',
				'label'        => __( 'Arrow icon', 'twentytwentyfour' ),
				/*
				 * Styles for the custom Arrow icon style of the Details block
				 */
				'inline_style' => '
				.is-style-arrow-icon-details {
					padding-top: var(--wp--preset--spacing--10);
					padding-bottom: var(--wp--preset--spacing--10);
				}

				.is-style-arrow-icon-details summary {
					list-style-type: "\2193\00a0\00a0\00a0";
				}

				.is-style-arrow-icon-details[open]>summary {
					list-style-type: "\2192\00a0\00a0\00a0";
				}',
			)
		);
		register_block_style(
			'core/post-terms',
			array(
				'name'         => 'pill',
				'label'        => __( 'Pill', 'twentytwentyfour' ),
				/*
				 * Styles variation for post terms
				 * https://github.com/WordPress/gutenberg/issues/24956
				 */
				'inline_style' => '
				.is-style-pill a,
				.is-style-pill span:not([class], [data-rich-text-placeholder]) {
					display: inline-block;
					background-color: var(--wp--preset--color--base-2);
					padding: 0.375rem 0.875rem;
					border-radius: var(--wp--preset--spacing--20);
				}

				.is-style-pill a:hover {
					background-color: var(--wp--preset--color--contrast-3);
				}',
			)
		);
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'twentytwentyfour' ),
				/*
				 * Styles for the custom checkmark list block style
				 * https://github.com/WordPress/gutenberg/issues/51480
				 */
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
		register_block_style(
			'core/navigation-link',
			array(
				'name'         => 'arrow-link',
				'label'        => __( 'With arrow', 'twentytwentyfour' ),
				/*
				 * Styles for the custom arrow nav link block style
				 */
				'inline_style' => '
				.is-style-arrow-link .wp-block-navigation-item__label:after {
					content: "\2197";
					padding-inline-start: 0.25rem;
					vertical-align: middle;
					text-decoration: none;
					display: inline-block;
				}',
			)
		);
		register_block_style(
			'core/heading',
			array(
				'name'         => 'asterisk',
				'label'        => __( 'With asterisk', 'twentytwentyfour' ),
				'inline_style' => "
				.is-style-asterisk:before {
					content: '';
					width: 1.5rem;
					height: 3rem;
					background: var(--wp--preset--color--contrast-2, currentColor);
					clip-path: path('M11.93.684v8.039l5.633-5.633 1.216 1.23-5.66 5.66h8.04v1.737H13.2l5.701 5.701-1.23 1.23-5.742-5.742V21h-1.737v-8.094l-5.77 5.77-1.23-1.217 5.743-5.742H.842V9.98h8.162l-5.701-5.7 1.23-1.231 5.66 5.66V.684h1.737Z');
					display: block;
				}

				/* Hide the asterisk if the heading has no content, to avoid using empty headings to display the asterisk only, which is an A11Y issue */
				.is-style-asterisk:empty:before {
					content: none;
				}

				.is-style-asterisk:-moz-only-whitespace:before {
					content: none;
				}

				.is-style-asterisk.has-text-align-center:before {
					margin: 0 auto;
				}

				.is-style-asterisk.has-text-align-right:before {
					margin-left: auto;
				}

				.rtl .is-style-asterisk.has-text-align-left:before {
					margin-right: auto;
				}",
			)
		);
	}
endif;

add_action( 'init', 'twentytwentyfour_block_styles' );

/**
 * Enqueue block stylesheets.
 */

if ( ! function_exists( 'twentytwentyfour_block_stylesheets' ) ) :
	/**
	 * Enqueue custom block stylesheets
	 *
	 * @since Twenty Twenty-Four 1.0
	 * @return void
	 */
	function twentytwentyfour_block_stylesheets() {
		/**
		 * The wp_enqueue_block_style() function allows us to enqueue a stylesheet
		 * for a specific block. These will only get loaded when the block is rendered
		 * (both in the editor and on the front end), improving performance
		 * and reducing the amount of data requested by visitors.
		 *
		 * See https://make.wordpress.org/core/2021/12/15/using-multiple-stylesheets-per-block/ for more info.
		 */
		wp_enqueue_block_style(
			'core/button',
			array(
				'handle' => 'twentytwentyfour-button-style-outline',
				'src'    => get_parent_theme_file_uri( 'assets/css/button-outline.css' ),
				'ver'    => wp_get_theme( get_template() )->get( 'Version' ),
				'path'   => get_parent_theme_file_path( 'assets/css/button-outline.css' ),
			)
		);
	}
endif;

add_action( 'init', 'twentytwentyfour_block_stylesheets' );

/**
 * Register pattern categories.
 */

if ( ! function_exists( 'twentytwentyfour_pattern_categories' ) ) :
	/**
	 * Register pattern categories
	 *
	 * @since Twenty Twenty-Four 1.0
	 * @return void
	 */
	function twentytwentyfour_pattern_categories() {

		register_block_pattern_category(
			'twentytwentyfour_page',
			array( 
				'label'       => _x( 'Pages', 'Block pattern category', 'twentytwentyfour' ),
				'description' => __( 'A collection of full page layouts.', 'twentytwentyfour' ),
			)
		);
	}
endif;

add_action( 'init', 'twentytwentyfour_pattern_categories' );

function enqueue_twentyfour_styles() {
    wp_enqueue_style('twentytwentyfour-style', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get('Version'));
}
add_action('wp_enqueue_scripts', 'enqueue_twentyfour_styles');

/**
 * Add custom post type for Movies.
 */
if ( ! function_exists( 'create_movies_post_type' ) ) :

	function create_movies_post_type() {
		$labels = array(
			'name'               => 'Movies',
			'singular_name'      => 'Movie',
			'menu_name'          => 'Movies',
			'name_admin_bar'     => 'Movie',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New Movie',
			'new_item'           => 'New Movie',
			'edit_item'          => 'Edit Movie',
			'view_item'          => 'View Movie',
			'all_items'          => 'All Movies',
			'search_items'       => 'Search Movies',
			'not_found'          => 'No movies found.',
			'not_found_in_trash' => 'No movies found in Trash.',
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'has_archive'        => true,
			'show_in_rest'       => true,
			'supports'           => array('title', 'editor', 'thumbnail'),
			'menu_icon'          => 'dashicons-video-alt2',
			'rewrite'            => array('slug' => 'movies'),
		);

		register_post_type('movie', $args);
	}
endif;

add_action('init', 'create_movies_post_type');

/**
 * Add taxonomy for Movies.
 */
if ( ! function_exists( 'create_movie_taxonomies' ) ) :

	function create_movie_taxonomies() {
		$labels = array(
			'name'              => 'Movie Categories',
			'singular_name'     => 'Movie Category',
			'search_items'      => 'Search Movie Categories',
			'all_items'         => 'All Movie Categories',
			'parent_item'       => 'Parent Category',
			'parent_item_colon' => 'Parent Category:',
			'edit_item'         => 'Edit Movie Category',
			'update_item'       => 'Update Movie Category',
			'add_new_item'      => 'Add New Movie Category',
			'new_item_name'     => 'New Movie Category Name',
			'menu_name'         => 'Movie Categories',
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array('slug' => 'movie-category'),
		);

		register_taxonomy('movie_category', array('movie'), $args);
	}
endif;

add_action('init', 'create_movie_taxonomies');

function add_movie_meta_boxes() {
	add_meta_box(
        'movie_meta_box',
        'Movie Details',
        'display_movie_meta_box',
        'movie',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_movie_meta_boxes');

function display_movie_meta_box($post) {
    $director = get_post_meta($post->ID, 'movie_director', true);
    $release_year = get_post_meta($post->ID, 'movie_release_year', true);

    $terms = get_terms(array(
        'taxonomy' => 'movie_category',
        'hide_empty' => false,
    ));

    $selected_category = wp_get_post_terms($post->ID, 'movie_category', array('fields' => 'ids'));

    ?>
    <p>
        <label for="movie_director">Director:</label><br>
        <input type="text" name="movie_director" id="movie_director" value="<?php echo esc_attr($director); ?>" size="30">
    </p>
    <p>
        <label for="movie_release_year">Release Year:</label><br>
        <input type="text" name="movie_release_year" id="movie_release_year" value="<?php echo esc_attr($release_year); ?>" size="30">
    </p>

    <p>
        <label for="movie_category">Category:</label><br>
        <select name="movie_category" id="movie_category">
            <option value="">Select Category</option>
            <?php foreach ($terms as $term) : ?>
                <option value="<?php echo $term->term_id; ?>" 
                    <?php echo (!empty($selected_category) && in_array($term->term_id, $selected_category)) ? 'selected' : ''; ?>>
                    <?php echo $term->name; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>
    <?php
}

function save_movie_meta($post_id) {
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['movie_director']) || !isset($_POST['movie_release_year'])) return;

    update_post_meta($post_id, 'movie_director', sanitize_text_field($_POST['movie_director']));

    update_post_meta($post_id, 'movie_release_year', sanitize_text_field($_POST['movie_release_year']));

    if (isset($_POST['movie_category']) && $_POST['movie_category'] != '') {
        wp_set_post_terms($post_id, array(intval($_POST['movie_category'])), 'movie_category');
    }
}
add_action('save_post', 'save_movie_meta');

function custom_edit_book_rewrite_rule() {
    add_rewrite_rule('^edit-book/?$', 'index.php?edit_book_page=1', 'top');
}
add_action('init', 'custom_edit_book_rewrite_rule');

function custom_edit_book_query_vars($query_vars) {
    $query_vars[] = 'edit_book_page';
    return $query_vars;
}
add_filter('query_vars', 'custom_edit_book_query_vars');

function custom_edit_book_template_include($template) {
    if (get_query_var('edit_book_page') == 1) {
        return get_template_directory() . '/edit-book.php';
    }
    return $template;
}
add_filter('template_include', 'custom_edit_book_template_include');

// function modify_robots_meta_for_non_fiction() {
//     if (!is_single()) {
//         return;
//     }
    
// 	global $post;
// 	if (get_post_type($post) !== 'book') {
//         return;
//     }
	
// 	$genres = wp_get_post_terms($post->ID, 'genre', array('fields' => 'names'));
//     if (empty($genres)) {
//         return; 
//     }

//     $is_non_fiction = false;
//     foreach ($genres as $genre) {
//         if ($genre === 'Non-Fiction' || term_is_ancestor_of(get_term_by('name', 'Non-Fiction', 'genre')->term_id, get_term_by('name', $genre, 'genre')->term_id, 'genre')) {
//             $is_non_fiction = true;
//             break;
//         }
//     }

//     if ($is_non_fiction) {
//         echo '<script>
//             document.addEventListener("DOMContentLoaded", function () {
//                 let robotsMeta = document.querySelector("meta[name=\'robots\']");
//                 if (robotsMeta) {
//                     robotsMeta.setAttribute("content", "no-index");
//                 } else {
//                     let metaTag = document.createElement("meta");
//                     metaTag.name = "robots";
//                     metaTag.content = "no-index";
//                     document.head.appendChild(metaTag);
//                 }
//             });
//         </script>';
//     }
// }
// add_action('wp_head', 'modify_robots_meta_for_non_fiction');

function modify_robots_meta_for_non_fiction() {
	global $post;
    if (is_single() && get_post_type($post) === 'book') {
		$genres = wp_get_post_terms($post->ID, 'genre', array('fields' => 'names'));
		if (!empty($genres)) {
			foreach ($genres as $genre) {
				if ($genre === 'Non-Fiction' || term_is_ancestor_of(get_term_by('name', 'Non-Fiction', 'genre')->term_id, get_term_by('name', $genre, 'genre')->term_id, 'genre')) {
					echo '<script>
						document.addEventListener("DOMContentLoaded", function () {
							let robotsMeta = document.querySelector("meta[name=\'robots\']");
							if (robotsMeta) {
								robotsMeta.setAttribute("content", "no-indexx");
							} else {
								let metaTag = document.createElement("meta");
								metaTag.name = "robots";
								metaTag.content = "no-indexx";
								document.head.appendChild(metaTag);
							}
						});
					</script>';
				}
			}
		}
    }
}
add_action('wp_head', 'modify_robots_meta_for_non_fiction');

// add_filter('robots_txt', 'custom_robots_txt_content', 10, 2);

// function custom_robots_txt_content($output, $public) {
//     // Keep WordPress default rules
//     $output .= "\n\n# Custom rules";
//     $output .= "\nDisallow: /private/";
//     $output .= "\nDisallow: /hidden-data/";
//     $output .= "\n\n# This is a custom note for local testing";

//     return $output;
// }

// Custom Rewrite Rule for robots.txt
function custom_robots_txt_rewrite_rule() {
    add_rewrite_rule('^robots\.txt$', 'index.php?robots=1', 'top');
}
add_action('init', 'custom_robots_txt_rewrite_rule');

// function custom_robots_txt_content_for_rewrite($output) {
// 	$output .= "\n# Custom note: Created by Ahmad Mughal";
//     return $output;
// }
// add_filter('robots_txt', 'custom_robots_txt_content_for_rewrite');

function custom_robots_txt_content_for_rewrite($output) {
    $output = "# Custom note: Created by Ahmad Mughal";
    return $output;
}
add_filter('robots_txt', 'custom_robots_txt_content_for_rewrite');

function url_encoder_shortcode_callback() {
    $original_url = "https://americansongwriter-com-preprod.go-vip.net/it-came-from-the-british-invasion-for-your-love-the-song-that-gained-the-yardbirds-a-big-hit-and-lost-them-a-legendary-guitarist/";

    // Encryption key (must be 16, 24, or 32 characters for AES)
    $key = 'secretkey1234567'; // 16 characters
    $iv = substr(hash('sha256', $key), 0, 16); // Create 16-byte IV

    // Encode: Encrypt + base64 + safe chars
    $encrypted = openssl_encrypt($original_url, 'AES-128-CBC', $key, 0, $iv);
    $encoded = rtrim(strtr(base64_encode($encrypted), '+/', '-_'), '=');

    // Decode: Reverse base64 and decrypt
    $decoded_base64 = base64_decode(strtr($encoded, '-_', '+/'));
    $decoded = openssl_decrypt($decoded_base64, 'AES-128-CBC', $key, 0, $iv);

	$style = '
    <style>
        .url-box {
            background: #f9f9f9;
            padding: 10px;
            border: 1px solid #ccc;
            word-break: break-all;
            overflow-wrap: anywhere;
            font-family: monospace;
            max-width: 100%;
        }
    </style>';

	$output  = $style;
    $output .= "<h3>Original URL:</h3>";
    $output .= "<div class='url-box'>{$original_url}</div>";
    $output .= "<p><strong>Length:</strong> " . strlen($original_url) . " characters</p>";

    $output .= "<h3>Encoded String:</h3>";
    $output .= "<div class='url-box'>{$encoded}</div>";
    $output .= "<p><strong>Length:</strong> " . strlen($encoded) . " characters</p>";

    $output .= "<h3>Decoded URL:</h3>";
    $output .= "<div class='url-box'>{$decoded}</div>";

    return $output;
}
add_shortcode('url_encoder_shortcode', 'url_encoder_shortcode_callback');


// Start of Implementation of restricted gutenberg user

// function register_contributing_author_role() {
//     add_role(
//         'contributing_author',
//         'Contributing Author',
//         [
//             'read'                  => true,
//             'edit_posts'            => true, 
//             'edit_published_posts'  => false,
//             'delete_posts'          => false,
//             'delete_published_posts'=> false,
//             'publish_posts'         => false,
//             'upload_files'          => true,
//         ]
//     );
// }
// add_action('init', 'register_contributing_author_role');

// function create_contributing_author_user() {
//     $username = 'contributingAuthor';
//     $password = 'contributing_author';
//     $email    = 'ammar@wingmanwp.com';

//     if (!username_exists($username) && !email_exists($email)) {
//         $user_id = wp_create_user($username, $password, $email);
//         if (!is_wp_error($user_id)) {
//             $user = new WP_User($user_id);
//             $user->set_role('contributing_author');
//         }
//     }
// }
// add_action('init', 'create_contributing_author_user');

// function hide_delete_row_actions_contributing_author($actions, $post) {
//     if (current_user_can('contributing_author') && get_current_user_id() === $post->post_author) {
//         unset($actions['trash']);
//         unset($actions['delete']);
//     }
//     return $actions;
// }
// add_filter('post_row_actions', 'hide_delete_row_actions_contributing_author', 10, 2);

// function limit_posts_to_own_contributing_author($query) {
//     if (
//         is_admin() &&
//         $query->is_main_query() &&
//         current_user_can('contributing_author') &&
//         !current_user_can('edit_others_posts')
//     ) {
//         $query->set('author', get_current_user_id());
//     }
// }
// add_action('pre_get_posts', 'limit_posts_to_own_contributing_author');

// function block_published_post_editing_contributing_author() {
//     global $post;
//     if (
//         current_user_can('contributing_author') &&
//         get_current_user_id() === $post->post_author &&
//         $post->post_status === 'publish'
//     ) {
//         wp_die('You cannot edit published posts.');
//     }
// }
// add_action('load-post.php', 'block_published_post_editing_contributing_author');

// function restrict_media_library_to_own_uploads($query) {
//     global $pagenow;

//     if (
//         is_admin() &&
//         $pagenow === 'upload.php' &&
//         $query->is_main_query() &&
//         current_user_can('contributing_author') &&
//         !current_user_can('edit_others_posts')
//     ) {
//         $query->set('author', get_current_user_id());
//     }
// }
// add_action('pre_get_posts', 'restrict_media_library_to_own_uploads');

// function filter_media_library_ajax_for_contributing_author($query) {
//     if (
//         is_admin() &&
//         defined('DOING_AJAX') && DOING_AJAX &&
//         isset($_POST['action']) && $_POST['action'] === 'query-attachments' &&
//         current_user_can('contributing_author') &&
//         !current_user_can('edit_others_posts')
//     ) {
//         $query['author'] = get_current_user_id();
//     }

//     return $query;
// }
// add_filter('ajax_query_attachments_args', 'filter_media_library_ajax_for_contributing_author');

add_action('admin_footer', function () {
    if (!current_user_can('external_contributor')) {
        return;
    }

    global $menu;

    $menu_data = [];
    foreach ($menu as $item) {
        $menu_data[] = [
            'title' => isset($item[0]) ? $item[0] : '',
            'slug'  => isset($item[2]) ? $item[2] : '',
        ];
    }

    echo '<script>console.groupCollapsed("Admin Menu Debug");console.table(' . json_encode($menu_data) . ');console.groupEnd();</script>';
}, 999);
