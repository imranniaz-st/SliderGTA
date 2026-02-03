<?php
/**
 * Plugin Name: Slider GTA
 * Plugin URI: https://example.com
 * Description: A beautiful image slider with Swiper.js, supports multiple sliders, shortcodes, and Elementor integration
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * License: GPL2
 * Text Domain: slider-gta
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('SLIDER_GTA_VERSION', '1.0.0');
define('SLIDER_GTA_PATH', plugin_dir_path(__FILE__));
define('SLIDER_GTA_URL', plugin_dir_url(__FILE__));

// Include required files
require_once SLIDER_GTA_PATH . 'includes/class-slider-gta.php';
require_once SLIDER_GTA_PATH . 'includes/class-slider-gta-admin.php';
require_once SLIDER_GTA_PATH . 'includes/class-slider-gta-shortcode.php';

// Check if Elementor is installed and load widget
if (did_action('elementor/loaded')) {
    require_once SLIDER_GTA_PATH . 'includes/elementor/class-slider-gta-elementor.php';
}

// Initialize the plugin
function slider_gta_init() {
    $slider_gta = new Slider_GTA();
    $slider_gta->init();
    
    $slider_admin = new Slider_GTA_Admin();
    $slider_admin->init();
    
    $slider_shortcode = new Slider_GTA_Shortcode();
    $slider_shortcode->init();
}
add_action('plugins_loaded', 'slider_gta_init');

// Activation hook - create custom post type
register_activation_hook(__FILE__, 'slider_gta_activate');
function slider_gta_activate() {
    // Create custom post type for sliders
    slider_gta_register_post_type();
    flush_rewrite_rules();
}

// Deactivation hook
register_deactivation_hook(__FILE__, 'slider_gta_deactivate');
function slider_gta_deactivate() {
    flush_rewrite_rules();
}

// Register custom post type for sliders
function slider_gta_register_post_type() {
    $labels = array(
        'name' => __('Sliders', 'slider-gta'),
        'singular_name' => __('Slider', 'slider-gta'),
        'add_new' => __('Add New Slider', 'slider-gta'),
        'add_new_item' => __('Add New Slider', 'slider-gta'),
        'edit_item' => __('Edit Slider', 'slider-gta'),
        'new_item' => __('New Slider', 'slider-gta'),
        'view_item' => __('View Slider', 'slider-gta'),
        'search_items' => __('Search Sliders', 'slider-gta'),
        'not_found' => __('No sliders found', 'slider-gta'),
        'not_found_in_trash' => __('No sliders found in Trash', 'slider-gta'),
    );

    $args = array(
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-images-alt2',
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array('title'),
        'has_archive' => false,
        'rewrite' => false,
        'query_var' => false,
    );

    register_post_type('slider_gta', $args);
}
add_action('init', 'slider_gta_register_post_type');
