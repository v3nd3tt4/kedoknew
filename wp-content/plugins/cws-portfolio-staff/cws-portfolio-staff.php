<?php
/*
Plugin Name: CWS Portfolio & Staff
Plugin URI:  http://creaws.com
Description: Internal use for creaws/cwsthemes themes only.
Text Domain: cws-portfolio-staff
Version: 1.1.0
*/

/*------------------------------------
-------------- PORTFOLIO -------------
------------------------------------*/

$theme = wp_get_theme();
if ($theme->get( 'Template' )) {
  define('THEME_SLUG', $theme->get( 'Template' ));
} else {
  define('THEME_SLUG', $theme->get( 'TextDomain' ));
}

add_action( "init", "register_cws_portfolio_cat" );
add_action( "init", "register_cws_portfolio" );

function register_cws_portfolio_cat(){
	$portfolio_default_slug = "portfolio";
	$portfolio_slug = function_exists( THEME_SLUG . '_get_option' ) ? call_user_func( THEME_SLUG . '_get_option', 'portfolio_slug' ) : $portfolio_default_slug;
	$portfolio_slug = !empty( $portfolio_slug ) ? $portfolio_slug : $portfolio_default_slug;
	register_taxonomy( 'cws_portfolio_cat', 'cws_portfolio', array(
		'hierarchical' => true,
		'show_admin_column' => true,
		'rewrite' => array( 'slug' => sanitize_title($portfolio_slug . '-cat') )
		));
}

function register_cws_portfolio (){
	$portfolio_default_slug = "portfolio";
	$portfolio_slug = function_exists( THEME_SLUG . '_get_option' ) ? call_user_func( THEME_SLUG . '_get_option', 'portfolio_slug' ) : $portfolio_default_slug;
	$portfolio_slug = !empty( $portfolio_slug ) ? $portfolio_slug : $portfolio_default_slug;
	$labels = array(
		'name' => esc_html__( 'Portfolio items', THEME_SLUG ),
		'singular_name' => esc_html__( 'Portfolio item', THEME_SLUG ),
		'menu_name' => esc_html__( 'Portfolio', THEME_SLUG ),
		'add_new' => esc_html__( 'Add Portfolio Item', THEME_SLUG ),
		'add_new_item' => esc_html__( 'Add New Portfolio Item', THEME_SLUG ),
		'edit_item' => esc_html__('Edit Portfolio Item', THEME_SLUG ),
		'new_item' => esc_html__( 'New Portfolio Item', THEME_SLUG ),
		'view_item' => esc_html__( 'View Portfolio Item', THEME_SLUG ),
		'search_items' => esc_html__( 'Search Portfolio Item', THEME_SLUG ),
		'not_found' => esc_html__( 'No Portfolio Items found', THEME_SLUG ),
		'not_found_in_trash' => esc_html__( 'No Portfolio Items found in Trash', THEME_SLUG ),
		'parent_item_colon' => '',
		);
	register_post_type( 'cws_portfolio', array(
		'label' => esc_html__( 'Portfolio items', THEME_SLUG ),
		'labels' => $labels,
		'public' => true,
		'rewrite' => array( 'slug' => sanitize_title($portfolio_slug) ),
		'capability_type' => 'post',
		'supports' => array(
			'title',
			'editor',
			'excerpt',
			'page-attributes',
			'thumbnail'
			),
		'menu_position' => 23,
		'menu_icon' => 'dashicons-format-gallery',
		'taxonomies' => array( 'cws_portfolio_cat' ),
		'has_archive' => true
	));
}

/*------------------------------------
---------------- STAFF ---------------
------------------------------------*/

add_action( "init", "register_cws_staff_department" );
add_action( "init", "register_cws_staff_position" );
add_action( "init", "register_cws_staff" );

function register_cws_staff (){
	$staff_default_slug = "staff";
	$staff_slug = function_exists( THEME_SLUG . '_get_option' ) ? call_user_func( THEME_SLUG . '_get_option', 'staff_slug' ) : $staff_default_slug;
	$staff_slug = !empty( $staff_slug ) ? $staff_slug : $staff_default_slug;
	$labels = array(
		'name' => esc_html__( 'Staff members', THEME_SLUG ),
		'singular_name' => esc_html__( 'Staff member', THEME_SLUG ),
		'menu_name' => esc_html__( 'Our team', THEME_SLUG ),
		'all_items' => esc_html__( 'All', THEME_SLUG ),
		'add_new' => esc_html__( 'Add new', THEME_SLUG ),
		'add_new_item' => esc_html__( 'Add New Staff Member', THEME_SLUG ),
		'edit_item' => esc_html__('Edit Staff Member\'s info', THEME_SLUG ),
		'new_item' => esc_html__( 'New Staff Member', THEME_SLUG ),
		'view_item' => esc_html__( 'View Staff Member\'s info', THEME_SLUG ),
		'search_items' => esc_html__( 'Find Staff Member', THEME_SLUG ),
		'not_found' => esc_html__( 'No Staff Members found', THEME_SLUG ),
		'not_found_in_trash' => esc_html__( 'No Staff Members found in Trash', THEME_SLUG ),
		'parent_item_colon' => '',
		);
	register_post_type( 'cws_staff', array(
		'label' => esc_html__( 'Staff members', THEME_SLUG ),
		'labels' => $labels,
		'public' => true,
		'rewrite' => array( 'slug' => sanitize_title($staff_slug) ),
		'capability_type' => 'post',
		'supports' => array(
			'title',
			'editor',
			'excerpt',
			'page-attributes',
			'thumbnail'
			),
		'menu_position' => 24,
		'menu_icon' => 'dashicons-groups',
		'taxonomies' => array( 'cws_staff_member_position' ),
		'has_archive' => true
	));
}

function register_cws_staff_department(){
	$staff_default_slug = "staff";
	$staff_slug = function_exists( THEME_SLUG . '_get_option' ) ? call_user_func( THEME_SLUG . '_get_option', 'staff_slug' ) : $staff_default_slug;
	$staff_slug = !empty( $staff_slug ) ? $staff_slug : $staff_default_slug;
	$labels = array(
		'name' => esc_html__( 'Departments', THEME_SLUG ),
		'singular_name' => esc_html__( 'Staff department', THEME_SLUG ),
		'all_items' => esc_html__( 'All Staff departments', THEME_SLUG ),
		'edit_item' => esc_html__( 'Edit Staff department', THEME_SLUG ),
		'view_item' => esc_html__( 'View Staff department', THEME_SLUG ),
		'update_item' => esc_html__( 'Update Staff department', THEME_SLUG ),
		'add_new_item' => esc_html__( 'Add Staff department', THEME_SLUG ),
		'new_item_name' => esc_html__( 'New Staff department name', THEME_SLUG ),
		'parent_item' => esc_html__( 'Parent Staff department', THEME_SLUG ),
		'parent_item_colon' => esc_html__( 'Parent Staff department:', THEME_SLUG ),
		'search_items' => esc_html__( 'Search Staff departments', THEME_SLUG ),
		'popular_items' => esc_html__( 'Popular Staff departments', THEME_SLUG ),
		'separate_items_width_commas' => esc_html__( 'Separate with commas', THEME_SLUG ),
		'add_or_remove_items' => esc_html__( 'Add or Remove Staff departments', THEME_SLUG ),
		'choose_from_most_used' => esc_html__( 'Choose from the most used Staff departments', THEME_SLUG ),
		'not_found' => esc_html__( 'No Staff departments found', THEME_SLUG )
	);
	register_taxonomy( 'cws_staff_member_department', 'cws_staff', array(
		'labels' => $labels,
		'hierarchical' => true,
		'show_admin_column' => true,
		'rewrite' => array( 'slug' => sanitize_title($staff_slug . '-cat') )
	));
}

function register_cws_staff_position(){
	$staff_default_slug = "staff";
	$staff_slug = function_exists( THEME_SLUG . '_get_option' ) ? call_user_func( THEME_SLUG . '_get_option', 'staff_slug' ) : $staff_default_slug;
	$staff_slug = !empty( $staff_slug ) ? $staff_slug : $staff_default_slug;
	$labels = array(
		'name' => esc_html__( 'Positions', THEME_SLUG ),
		'singular_name' => esc_html__( 'Staff Member position', THEME_SLUG ),
		'all_items' => esc_html__( 'All Staff Member positions', THEME_SLUG ),
		'edit_item' => esc_html__( 'Edit Staff Member position', THEME_SLUG ),
		'view_item' => esc_html__( 'View Staff Member position', THEME_SLUG ),
		'update_item' => esc_html__( 'Update Staff Member position', THEME_SLUG ),
		'add_new_item' => esc_html__( 'Add Staff Member position', THEME_SLUG ),
		'new_item_name' => esc_html__( 'New Staff Member position name', THEME_SLUG ),
		'search_items' => esc_html__( 'Search Staff Member positions', THEME_SLUG ),
		'popular_items' => esc_html__( 'Popular Staff Member positions', THEME_SLUG ),
		'separate_items_width_commas' => esc_html__( 'Separate with commas', THEME_SLUG ),
		'add_or_remove_items' => esc_html__( 'Add or Remove Staff Member positions', THEME_SLUG ),
		'choose_from_most_used' => esc_html__( 'Choose from the most used Staff Member positions', THEME_SLUG ),
		'not_found' => esc_html__( 'No Staff Member positions found', THEME_SLUG )
	);
	register_taxonomy( 'cws_staff_member_position', 'cws_staff', array(
		'labels' => $labels,
		'show_admin_column' => true,
		'rewrite' => array( 'slug' => sanitize_title( $staff_slug . '-tag') ),
		'show_tagcloud' => false
	));
}

function add_order_column( $columns ) {
  $columns['menu_order'] = /*esc_html__( */"Order"/*, "unilearn" )*/;
  return $columns;
}
add_action('manage_edit-cws_staff_columns', 'add_order_column');
add_action('manage_edit-cws_portfolio_columns', 'add_order_column');

/**
* show custom order column values
*/
function show_order_column($name){
  global $post;
  switch ($name) {
    case 'menu_order':
      $order = $post->menu_order;
      echo $order;
      break;
   default:
      break;
   }
}
add_action('manage_cws_staff_posts_custom_column','show_order_column');
add_action('manage_cws_portfolio_posts_custom_column','show_order_column');

/**
* make column sortable
*/
function order_column_register_sortable( $columns ){
	$new_columns = array(
		"menu_order" 	=> "menu_order",
		"date"			=> "date",
		"title"			=> "title"
	);
	return $new_columns;
}
add_filter('manage_edit-cws_staff_sortable_columns','order_column_register_sortable');
add_filter('manage_edit-cws_portfolio_sortable_columns','order_column_register_sortable');

?>