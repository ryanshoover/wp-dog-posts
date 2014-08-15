<?php
/*
Plugin Name: Create dog posts
Plugin URI: http://ryan.hoover.ws
Description: Provides a feature for adding dog posts
Version: 0.1
Author: Ryan Hoover
Author URI: http://ryan.hoover.ws
*/


// *****
// Registers the custom post type
add_action( 'init', 'rsh_create_dog_post_type' );

function rsh_create_dog_post_type() {
  register_post_type( 'rsh_dog',
    array(
      'labels' => array(
        'name' => __( 'Dogs' ),
        'singular_name' => __( 'Dog' ),
				'add_new_item' => __( 'Add New Dog' ),
      ),
		'description' => 'Pages specifically for showcasing dogs',
		'public' => true,
    'has_archive' => true,
		'menu_icon' => plugins_url( 'images/paw.png' , __FILE__ ),
		'supports' => array( 'title', 'editor', 'thumbnail' ),
    )
  );

}	


// *****
// Change label on the Featured Image meta_box to make it more intuitive
add_action('do_meta_boxes', 'rsh_dog_meta_box');

function rsh_dog_meta_box() {
	remove_meta_box('postimagediv', 'rsh_dog', 'side');
	add_meta_box('postimagediv', __('Dog Image'), 'post_thumbnail_meta_box', 'rsh_dog', 'normal', 'low');
}

// *****
// Add column in dogs admin screen to show dog image
function rsh_dog_images_columns($columns) {
	/** Add an Image Column **/
	$imageColumn = array(
		'image' => __('Image')
	);
	$columns = array_merge( $columns, $imageColumn );
	
	return $columns;
}
add_filter('manage_edit-rsh_dog_columns', 'rsh_dog_images_columns');

// *****
// Get content for custom column
function rsh_dog_images_column_content($column_name, $post_id) {
	if ($column_name == 'image') {
		$post_thumbnail_id = get_post_thumbnail_id($post_id);
	  	if ($post_thumbnail_id) {
	    	$post_thumbnail_img = wp_get_attachment_thumb_url($post_thumbnail_id);
				echo '<img src="' . $post_thumbnail_img . '" style="height:75px;width:75px;" />'; //height-width is hard coded, could be styled in CSS instead
	  	}
	}
	
}
add_action('manage_rsh_dog_posts_custom_column', 'rsh_dog_images_column_content', 10, 2);
