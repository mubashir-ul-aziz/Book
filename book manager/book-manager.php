<?php
/*
Plugin Name: Books Manager
Plugin URI:  #
Description: Manage books with custom fields like Author, Publisher, ISBN.
Version:     1.0.0.0
Author:      Dev
Author URI:  #
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Define constant for plugin folder path
if ( ! defined('BOOK_MANAGER_PATH') ) {
    define('BOOK_MANAGER_PATH', plugin_dir_path(__FILE__));
}

if ( ! defined('BOOK_MANAGER_URL') ) {
    define('BOOK_MANAGER_URL', plugin_dir_url(__FILE__));
}

// Include files
require_once plugin_dir_path( __FILE__ ) . 'includes/cpt-books.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/meta-boxes.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/frontend-display.php'; 

function bm_enqueue_admin_assets() {
    wp_enqueue_style( 'bm-admin-css', plugin_dir_url( __FILE__ ) . 'assets/css/admin.css' );
    wp_enqueue_script( 'bm-admin-js', plugin_dir_url( __FILE__ ) . 'assets/js/admin.js', array('jquery'), null, true );
}

add_action( 'admin_enqueue_scripts', 'bm_enqueue_admin_assets' );

require_once plugin_dir_path(__FILE__) . 'includes/template-loader.php';

// Hook to enqueue frontend styles
add_action( 'wp_enqueue_scripts', 'myplugin_enqueue_frontend_styles' );
function myplugin_enqueue_frontend_styles() {

    echo "<!-- DEBUG: enqueue function IS running -->";

    if ( is_post_type_archive('book') || is_singular('book') ) {
        wp_enqueue_style( 'book-frontend-style', BOOK_MANAGER_URL . 'assets/css/frontend.css' );
        wp_enqueue_script( 'book-frontend-js', BOOK_MANAGER_URL . 'assets/js/frontend.js', array('jquery'), false, true );
    }
    if ( is_post_type_archive('book') ) {
        // Load only on BOOK archive page
        wp_enqueue_style( 'book-nouislider-style', BOOK_MANAGER_URL . 'assets/css/nouislider.min.css' );
        wp_enqueue_script( 'book-nouislider-js', BOOK_MANAGER_URL . 'assets/js/nouislider.min.js', array('jquery'), false, true );
    }
}

// Include admin settings page

require_once BOOK_MANAGER_PATH . 'includes/taxonomies.php';

add_action('wp_enqueue_scripts', 'bm_enqueue_script');
function bm_enqueue_script() {
    wp_enqueue_script(
        'bm-filter-js',
        BOOK_MANAGER_URL . 'assets/js/book-filter.js',
        array('jquery'),
        false,
        true
    );

    wp_localize_script('bm-filter-js', 'bm_ajax_obj', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}

function bm_enqueue_scripts() {

    wp_enqueue_script(
        'bm-book-filter',
        BOOK_MANAGER_URL . 'assets/js/book-filter.js',
        array('jquery'),
        false,
        true
    );

    wp_localize_script(
        'bm-book-filter',
        'ajax_var',
        array(
            'ajax_url' => admin_url('admin-ajax.php')
        )
    );
}
// add_action('wp_enqueue_scripts', 'bm_enqueue_scripts');


require_once BOOK_MANAGER_PATH . 'includes/ajax-handlers.php';


require_once BOOK_MANAGER_PATH . 'includes/class-book-rest-controller.php';

// Init REST API
add_action('rest_api_init', function () {
    $controller = new Book_REST_Controller();
    $controller->register_routes();
});








