<?php

/**
 * Portfolio functions and definitions
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Downgrade functions
require_once 'includes/downgrade-functions.php';

/**
 * Enqueue the style.css file.
 *
 * @since 1.0.0
 */

 add_action( 'wp_enqueue_scripts', 'portfolio_enqueue_styles' );
 function portfolio_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/assets/css/style.css' );
 }


/**
 * Loads the translation files for WordPress.
 *
 * @since 1.0.0
 */

function portfolio_theme_setup()
{
	load_child_theme_textdomain( 'portfolio', get_stylesheet_directory() . '/languages' );
}

add_action('after_setup_theme', 'portfolio_theme_setup');

// include admin classes
add_action('after_setup_theme','blockstrap_portfolio_load_admin');
function blockstrap_portfolio_load_admin(){
	if ( is_admin() ) {
		// Theme admin stuff
		require_once 'includes/class-blockstrap-admin-child.php';
	}
}
