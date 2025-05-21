<?php
defined('ABSPATH') || exit;

/**
 * Register 'External Contributor' role
 */
function register_external_contributor_role() {
    if (!get_role('external_contributor')) {
        add_role(
            'external_contributor',
            'External Contributor',
            [
                'read'                  => true,
                'edit_posts'            => true,
                'edit_published_posts'  => false,
                'delete_posts'          => false,
                'delete_published_posts'=> false,
                'publish_posts'         => false,
                'upload_files'          => true,
            ]
        );
    }
}
add_action('init', 'register_external_contributor_role');

/**
 * Hide delete/trash options for own posts
 */
function hide_delete_actions_external_contributor($actions, $post) {
    if (current_user_can('external_contributor') && get_current_user_id() === $post->post_author) {
        unset($actions['trash'], $actions['delete']);
    }
    return $actions;
}
add_filter('post_row_actions', 'hide_delete_actions_external_contributor', 10, 2);

/**
 * Limit admin post list to own posts
 */
function limit_posts_to_own_external_contributor($query) {
    if (
        is_admin() &&
        $query->is_main_query() &&
        current_user_can('external_contributor') &&
        !current_user_can('edit_others_posts')
    ) {
        $query->set('author', get_current_user_id());
    }
}
add_action('pre_get_posts', 'limit_posts_to_own_external_contributor');

/**
 * Block editing of published posts
 */
function block_published_post_editing_external_contributor() {
    if (
        current_user_can('external_contributor') &&
        isset($_GET['post']) &&
        ($post = get_post((int) $_GET['post'])) &&
        get_current_user_id() === $post->post_author &&
        $post->post_status === 'publish'
    ) {
        wp_die('You cannot edit published posts.');
    }
}
add_action('load-post.php', 'block_published_post_editing_external_contributor');

/**
 * Restrict media library to own uploads
 */
function restrict_media_library_to_own_uploads($query) {
    global $pagenow;

    if (
        is_admin() &&
        $pagenow === 'upload.php' &&
        $query->is_main_query() &&
        current_user_can('external_contributor') &&
        !current_user_can('edit_others_posts')
    ) {
        $query->set('author', get_current_user_id());
    }
}
add_action('pre_get_posts', 'restrict_media_library_to_own_uploads');

/**
 * Restrict media AJAX requests to own uploads
 */
function filter_media_library_ajax_for_external_contributor($query) {
    if (
        is_admin() &&
        defined('DOING_AJAX') && DOING_AJAX &&
        isset($_POST['action']) && $_POST['action'] === 'query-attachments' &&
        current_user_can('external_contributor') &&
        !current_user_can('edit_others_posts')
    ) {
        $query['author'] = get_current_user_id();
    }

    return $query;
}
add_filter('ajax_query_attachments_args', 'filter_media_library_ajax_for_external_contributor');
