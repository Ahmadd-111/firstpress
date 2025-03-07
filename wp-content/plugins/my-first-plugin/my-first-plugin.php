<?php
/**
 * Plugin Name: My First Plugin
 * Plugin URI: https://example.com/my-first-plugin
 * Description: A simple WordPress plugin for learning purposes.
 * Version: 1.0
 * Author: Ahmad Raza
 * Author URI: https://example.com
 * License: GPL2
 */

function my_plugin_activate() {
    error_log('My First Plugin activated.');
}
register_activation_hook(__FILE__, 'my_plugin_activate');

function my_plugin_deactivate() {
    error_log('My First Plugin deactivated.');
}
register_deactivation_hook(__FILE__, 'my_plugin_deactivate');

/**
 * Function to display an animated message on the frontend
 */
function my_plugin_display_message() {
    ?>
    <style>
        .my-plugin-message {
            text-align: center;
            font-size: 24px;
            color: blue;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInBounce 1s ease-out forwards;
        }

        @keyframes fadeInBounce {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            50% {
                opacity: 1;
                transform: translateY(-10px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <p class="my-plugin-message">🔥 Welcome! This is an animated message from My First Plugin 🚀</p>
    <?php
}

add_action('wp_footer', 'my_plugin_display_message');