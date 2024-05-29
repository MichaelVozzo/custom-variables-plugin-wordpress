<?php
/*
Plugin Name: Custom Variables Plugin
Description: A custom plugin for global variables.
Version: 1.2
Author: EDynam Team
*/

if (!defined('ABSPATH')) {
    exit;
}

// Include necessary files
require_once plugin_dir_path(__FILE__) . 'includes/admin-settings.php';
require_once plugin_dir_path(__FILE__) . 'includes/utilities.php';
require_once plugin_dir_path(__FILE__) . 'includes/shortcodes.php';
require_once plugin_dir_path(__FILE__) . 'includes/elementor-integration.php';


// Enqueue styles or scripts if needed
function custom_variables_styles() {
	wp_enqueue_style('custom-variables-style', plugins_url('/css/custom-variables-plugin.css', __FILE__), array(), '1.2');
}
add_action('admin_enqueue_scripts', 'custom_variables_styles');