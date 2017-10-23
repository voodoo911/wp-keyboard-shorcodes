<?php
function wfd_add_post_type() {
  $labels = array(
    'name' => __('Forex System', 'fs'),
    'singular_name' => __('Forex System', 'fs'),
    'add_new' => __('Add New', 'fs'),
    'add_new_item' => __('Add New Forex System', 'fs'),
    'edit_item' => __('Edit Forex System', 'fs'),
    'new_item' => __('New Forex System', 'fs'),
    'all_items' => __('All Forex System', 'fs'),
    'view_item' => __('View Forex System', 'fs'),
    'search_items' => __('Search Forex System', 'fs'),
    'not_found' =>  __('No Forex System found', 'fs'),
    'not_found_in_trash' => __('No Forex System found in Trash', 'fs'), 
    'parent_item_colon' => '',
    'menu_name' => __('Forex System', 'fs')

  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array( 'title', 'custom-fields' /*'editor' , 'thumbnail', 'excerpt', 'custom-fields'   'custom-fields' 'custom-fields'  'editor', 'thumbnail', 'custom-fields'  'author', , 'custom-fields', 'editor'  */)
  ); 
  register_post_type('fx_system', $args);
  // Add new taxonomy, NOT hierarchical (like tags)
	$labels = array(
		'name'                       => _x( 'Category', 'taxonomy general name' ),
		'singular_name'              => _x( 'Category', 'taxonomy singular name' ),
		'search_items'               => __( 'Search Categories' ),
		'popular_items'              => __( 'Popular Categories' ),
		'all_items'                  => __( 'All Categories' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Category' ),
		'update_item'                => __( 'Update Category' ),
		'add_new_item'               => __( 'Add New Category' ),
		'new_item_name'              => __( 'New Category Name' ),
		'separate_items_with_commas' => __( 'Separate Categories with commas' ),
		'add_or_remove_items'        => __( 'Add or remove Categories' ),
		'choose_from_most_used'      => __( 'Choose from the most used Categoryies' ),
		'not_found'                  => __( 'No Categories found.' ),
		'menu_name'                  => __( 'Category' ),
	);

	$args = array(
		'hierarchical'          => true,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => true,
	);

	//register_taxonomy( 'racecard_category', 'racecard', $args );
  
  
}
add_action( 'init', 'wfd_add_post_type', 1 );
?>