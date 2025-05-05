<?php
add_action( 'wp_enqueue_scripts', function () {
    // Load parent theme styles
    wp_enqueue_style(
        'twentytwentythree-style',
        get_template_directory_uri() . '/style.css'
    );

    // Load child theme styles (with dependency on parent)
    wp_enqueue_style(
        'twentytwentythree-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        ['twentytwentythree-style']
    );
});

function custom_clean_strict_display_none_styles() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const videoBlock = document.querySelector('.wp-block-savage-platform-primis-video');

        if (!videoBlock) {
            console.log('[Primis Cleanup] Target class `.wp-block-savage-platform-primis-video` NOT found on this page.');
            return;
        }
        console.log('[Primis Cleanup] `.wp-block-savage-platform-primis-video` found ✅');

        const hiddenDivs = videoBlock.querySelectorAll('div[style]');
        let cleanedCount = 0;

        hiddenDivs.forEach(div => {
            const originalStyle = div.getAttribute('style');
            if (!originalStyle) return;

            const normalizedStyle = originalStyle
            .replace(/\s{2,}/g, ' ')
            .replace(/\s*:\s*/g, ':')
            .replace(/\s*;\s*/g, ';')
            .trim()
            .toLowerCase();

            const displayNonePattern = /^display\s*:\s*none\s*(?:!\s*important)?\s*;?$/;

            if (displayNonePattern.test(normalizedStyle)) {
                div.removeAttribute('style');
            }
        });
    });
    </script>
    <?php
}
add_action('wp_footer', 'custom_clean_strict_display_none_styles');




