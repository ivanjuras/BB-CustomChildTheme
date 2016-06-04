<?php

// Defines
define( 'FL_CHILD_THEME_DIR', get_stylesheet_directory() );
define( 'FL_CHILD_THEME_URL', get_stylesheet_directory_uri() );

// Classes
require_once 'bb/class-fl-child-theme.php';

// Actions
add_action( 'fl_head', 'FLChildTheme::stylesheet' );


//-------------------------------------//
//---------- CUSTOM SCRIPTS ----------//
//-----------------------------------//


//---------- Add file types ----------//

// Support SVG file types
add_filter( 'upload_mimes', 'bbchild_add_mime_types' );
function bbchild_add_mime_types( $mimes ) {
	  $mimes['svg'] = 'image/svg+xml';

	  return $mimes;
}

//---------- Remove actions ----------//

// Remove wp_head_actions
add_action( 'init', 'bbchild_remove_wp_head_actions' );
function bbchild_remove_wp_head_actions() {
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'index_rel_link' );
	remove_action( 'wp_head', 'rel_canonical' );
	remove_action( 'wp_head', 'start_post_rel_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
}

// Disable eMojis
add_action( 'init', 'bbchild_disable_emojis' );
function bbchild_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}

// Disable eMojis tinyMCE
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array('wpemoji') );
	}
	else {
		return array();
	}
}