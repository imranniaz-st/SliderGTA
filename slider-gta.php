<?php
/**
 * Plugin Name: Bico Slider
 * Plugin URI: https://bicodev.com
 * Description: A beautiful image slider with Swiper.js, supports multiple sliders, shortcodes, and Elementor integration
 * Version: 1.0.0
 * Author: Bicodev
 * Author URI: https://bicodev.com
 * License: GPL2
 * Text Domain: bico-slider
 * Domain Path: /languages
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('BICO_SLIDER_VERSION', '1.0.0');
define('BICO_SLIDER_PATH', plugin_dir_path(__FILE__));
define('BICO_SLIDER_URL', plugin_dir_url(__FILE__));

// Include required files
require_once BICO_SLIDER_PATH . 'includes/class-bico-slider.php';
require_once BICO_SLIDER_PATH . 'includes/class-bico-slider-admin.php';
require_once BICO_SLIDER_PATH . 'includes/class-bico-slider-shortcode.php';
require_once BICO_SLIDER_PATH . 'includes/class-bico-slider-updates.php';

// Check if Elementor is installed and load widget
if (did_action('elementor/loaded')) {
    require_once BICO_SLIDER_PATH . 'includes/elementor/class-bico-slider-elementor.php';
}

// Initialize the plugin
function bico_slider_init() {
    $bico_slider = new Bico_Slider();
    $bico_slider->init();
    
    $bico_admin = new Bico_Slider_Admin();
    $bico_admin->init();
    
    $bico_shortcode = new Bico_Slider_Shortcode();
    $bico_shortcode->init();
}
add_action('plugins_loaded', 'bico_slider_init');

// Activation hook - create custom post type
register_activation_hook(__FILE__, 'bico_slider_activate');
function bico_slider_activate() {
    // Create custom post type for sliders
    bico_slider_register_post_type();
    flush_rewrite_rules();
}

// Deactivation hook
register_deactivation_hook(__FILE__, 'bico_slider_deactivate');
function bico_slider_deactivate() {
    flush_rewrite_rules();
}

// Register custom post type for sliders
function bico_slider_register_post_type() {
    $labels = array(
        'name' => __('Sliders', 'bico-slider'),
        'singular_name' => __('Slider', 'bico-slider'),
        'add_new' => __('Add New Slider', 'bico-slider'),
        'add_new_item' => __('Add New Slider', 'bico-slider'),
        'edit_item' => __('Edit Slider', 'bico-slider'),
        'new_item' => __('New Slider', 'bico-slider'),
        'view_item' => __('View Slider', 'bico-slider'),
        'search_items' => __('Search Sliders', 'bico-slider'),
        'not_found' => __('No sliders found', 'bico-slider'),
        'not_found_in_trash' => __('No sliders found in Trash', 'bico-slider'),
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

    register_post_type('bico_slider', $args);
}
add_action('init', 'bico_slider_register_post_type');
