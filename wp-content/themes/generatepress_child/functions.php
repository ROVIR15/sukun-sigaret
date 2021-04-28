<?php
/**
 * GeneratePress child theme functions and definitions.
 *
 * Add your custom PHP in this file. 
 * Only edit this file if you have direct access to it on your server (to fix errors if they happen).
 */

function generatepress_child_enqueue_scripts() {
	if ( is_rtl() ) {
		wp_enqueue_style( 'generatepress-rtl', trailingslashit( get_template_directory_uri() ) . 'rtl.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'generatepress_child_enqueue_scripts', 100 );

function turn_blogposts_translation_off( $post_types, $is_settings ) {
  unset( $post_types['post'] );
  
  return $post_types;
}

add_filter( 'pll_get_post_types', 'turn_blogposts_translation_off', 10, 2 );