<?php
if ( !defined( 'ABSPATH' ) ) { exit; }

define( 'THEME_VERSION', '1.0.1' );
define( 'THEME_NAME', 'ITNode' );
define( 'THEME_TEXT_DOMAIN', 'itnode' );

if ( !function_exists( 'theme_setup' ) ) {
	function theme_setup() {
		add_post_type_support( 'page', 'excerpt' );
		add_theme_support( 'menus' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-styles' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-formats', array( 'quote', 'video', 'audio', 'link' ) );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style', 'navigation-widgets', ) );
		add_theme_support( 'custom-logo', array( 'width' => 180, 'height' => 60, 'flex-width' => true, 'flex-height' => true ) );

		if ( class_exists( 'WooCommerce' ) ) {
			add_theme_support( 'woocommerce' );
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );
		}
	}
}

if ( !function_exists( 'enqueue_theme_styles' ) ) {
	function enqueue_theme_styles() {
		wp_enqueue_style( THEME_TEXT_DOMAIN, get_template_directory_uri() . '/style.min.css', [], THEME_VERSION );
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}

if ( !function_exists( 'register_elementor_locations' ) ) {
	function register_elementor_locations( $elementor_theme_manager ) {
		if ( apply_filters( 'register_elementor_locations', true ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}

add_action( 'after_setup_theme', 'theme_setup' );
add_action( 'wp_enqueue_scripts', 'enqueue_theme_styles' );
add_action( 'elementor/theme/register_locations', 'register_elementor_locations' );
add_filter( 'use_block_editor_for_post_type', '__return_false', 100 );
add_filter( 'use_widgets_block_editor', '__return_false' );

require get_template_directory() . '/inc/minifier.php';
require get_template_directory() . '/inc/optimizer.php';