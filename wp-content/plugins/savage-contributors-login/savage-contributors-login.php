<?php
/**
 * Plugin Name: Savage Contributors Login
 * Description: Adds the 'External Contributor' role with limited permissions and separate login page.
 * Version: 1.0
 * Author: Savage Ventures
 */

defined('ABSPATH') || exit;

require_once plugin_dir_path(__FILE__) . 'includes/login-handler.php';
require_once plugin_dir_path(__FILE__) . 'includes/shortcode-login.php';
require_once plugin_dir_path(__FILE__) . 'includes/role-manager.php';
require_once plugin_dir_path(__FILE__) . 'includes/post-review-mailer.php';
require_once plugin_dir_path(__FILE__) . 'includes/admin-settings.php';
require_once plugin_dir_path(__FILE__) . 'includes/admin-menu-restrictions.php';
require_once plugin_dir_path(__FILE__) . 'includes/contributors-post-notifications.php';