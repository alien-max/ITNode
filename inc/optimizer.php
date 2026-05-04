<?php
if ( !defined( 'ABSPATH' ) ) { exit; }

if ( !function_exists( 'optimize_theme' ) ) {
	function optimize_theme() {
		remove_theme_support( 'block-templates' );

		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );

		remove_filter('the_content_feed', 'wp_staticize_emoji');
		remove_filter('comment_text_rss', 'wp_staticize_emoji');
		remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	}
}

if ( !function_exists( 'disable_post_revisions' ) ) {
	function disable_post_revisions() {
		foreach ( get_post_types() as $post_type ) {
			remove_post_type_support( $post_type, 'revisions' );
		}
	}
}

if ( !function_exists( 'dequeue_theme_styles' ) ) {
	function dequeue_theme_styles() {
		wp_dequeue_style( 'wc-blocks-style' );
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
	}
}

if ( !function_exists( 'customize_comment_form' ) ) {
	function customize_comment_form( $fields ) {
		if( isset( $fields['url'] ) ) { unset( $fields['url'] ); }

		$comment_field = $fields['comment'];
		unset( $fields['comment'] );
		$fields['comment'] = $comment_field;
		return $fields;
	}
}

if ( !function_exists( 'theme_minifier' ) ) {
	function theme_minifier() {
		ob_start( function( $html ) {
			$obj = new MINIFIER( $html );
			return $obj->minify();
		} );
	}
}

add_action( 'after_setup_theme', 'optimize_theme' );
add_action( 'init', 'disable_post_revisions', 999 );
add_action( 'wp_enqueue_scripts', 'dequeue_theme_styles' );
add_filter( 'comment_form_default_fields', 'customize_comment_form' );
add_action( 'get_header', 'theme_minifier' );