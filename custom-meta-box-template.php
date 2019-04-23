<?php


/*
Plugin Name: Right Sidebar Meta Box Template
Plugin URI: http://fussverkehr.ch/
Description: Enables TinyMCE for the richt_sidebar meta.
Author: Dominik Bucheli Fussverkehr Schweiz
Version: 1.01
Author URI: http://fussverkehr.ch/
GitHub Plugin URI: Fussverkehr/right-sidebar-meta-box-template
GitHub Plugin URI: https://github.com/Fussverkehr/right-sidebar-meta-box-template
*/


/**
 * Adds a meta box to the post editing screen
 */
function prfx_custom_meta() {
	add_meta_box( 'prfx_meta', __( 'Sidebar right', 'prfx-textdomain' ), 'prfx_meta_callback', 'page','side' );
	add_meta_box( 'prfx_meta', __( 'Sidebar right', 'prfx-textdomain' ), 'prfx_meta_callback', 'post','side' );

}
add_action( 'add_meta_boxes', 'prfx_custom_meta' );

/**
 * Outputs the content of the meta box
 */
 if( function_exists( 'is_gutenberg_page' ) && is_gutenberg_page() ) { 
function prfx_meta_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
	$prfx_stored_meta = get_post_meta( $post->ID, 'right_sidebar', true );
	
wp_editor( $prfx_stored_meta, 'right_sidebar', array(
    'wpautop'       => false,
    'media_buttons' => true,
    'textarea_name' => 'right_sidebar',
    'textarea_rows' => 10,
    'teeny'         => true,
    'tinymce'		=> false,
    'drag_drop_upload'	=> true
) );
}     }   
     else {
 
function prfx_meta_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
	$prfx_stored_meta = get_post_meta( $post->ID, 'right_sidebar', true );
	
wp_editor( $prfx_stored_meta, 'right_sidebar', array(
    'wpautop'       => false,
    'media_buttons' => true,
    'textarea_name' => 'right_sidebar',
    'textarea_rows' => 10,
    'teeny'         => false
) );
} }



/**
 * Saves the custom meta input
 */
function prfx_meta_save( $post_id ) {
 
	// Checks save status
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
	// Exits script depending on save status
	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return;
	}
 
	// Checks for input and sanitizes/saves if needed
	
	// Checks for input and saves if needed
	if( isset( $_POST[ 'right_sidebar' ] ) ) {
		update_post_meta( $post_id, 'right_sidebar', $_POST[ 'right_sidebar' ] );
	}

}
add_action( 'save_post', 'prfx_meta_save' );


/**
 * Adds the meta box stylesheet when appropriate
 */
function prfx_admin_styles(){
	global $typenow;
	if( $typenow == 'post' ) {
		wp_enqueue_style( 'prfx_meta_box_styles', plugin_dir_url( __FILE__ ) . 'meta-box-styles.css' );
	}
}
add_action( 'admin_print_styles', 'prfx_admin_styles' );






add_action( 'admin_enqueue_scripts', 'prfx_image_enqueue' );