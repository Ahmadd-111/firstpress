<?php
defined('ABSPATH') || exit;

/**
 * Send email when a post from external_contributor is submitted for review
 */
function notify_post_review_by_external_contributor($new_status, $old_status, $post) {
    if (
        $new_status === 'pending' &&
        $post->post_type === 'post'
    ) {
        $author = get_user_by('id', $post->post_author);

        if ($author && in_array('external_contributor', (array) $author->roles, true)) {
            $to = 'ammar@wingmanwp.com';
            $subject = sprintf('Post Review Request from %s (External Contributor)', $author->user_login);

            $message = sprintf(
                "\nA new post has been submitted for review by an external contributor. Please review it.\n\n" .
                "Username: %s\n" .
                "Email: %s\n" .
                "Post ID: %d\n" .
                "Post Title: %s\n" .
                "Post Link: %s\n",
                $author->user_login,
                $author->user_email,
                $post->ID,
                $post->post_title,
                admin_url("post.php?post={$post->ID}&action=edit")
            );
            wp_mail($to, $subject, $message);
        }
    }
}
add_action('transition_post_status', 'notify_post_review_by_external_contributor', 10, 3);
