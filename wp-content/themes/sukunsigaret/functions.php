<?php
require_once(TEMPLATEPATH . '/admin/admin-functions.php');
require_once(TEMPLATEPATH . '/admin/admin-interface.php');
require_once(TEMPLATEPATH . '/admin/theme-settings.php');
require_once('wp_bootstrap_navwalker.php');

load_theme_textdomain( 'whegin', TEMPLATEPATH.'/languages' );

/*
function namespaced_admin_styles_function() {
    echo '<link href="'.get_bloginfo('template_directory').'/css/admin-style.css"  rel="stylesheet">';
}

add_action('admin_head', 'namespaced_admin_styles_function');

function FontAwesome_icons() {
    echo '<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">';
}

add_action('admin_head', 'FontAwesome_icons');
//add_action('wp_head', 'FontAwesome_icons');
*/

register_nav_menus( array(
    'primary' => __( 'Primary Menu', 'r3-coaching' ),
    'topmenu' => __( 'Top Menu', 'r3-coaching' ),
) );


if ( function_exists('register_sidebar') ) 
{     
register_sidebar(array(
	'name' => 'Sidebar',
	'id' => 'sidebar',
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '<h1 class="sidebar-title">',
	'after_title' => '</h1>'
));   

register_sidebar(array(
	'name' => 'Bahasa',
	'id' => 'bahasa',
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '',
	'after_title' => ''
));     
}

function get_ID_by_slug($page_slug) {
    $page = get_page_by_path($page_slug);
    if ($page) {
        return $page->ID;
    } else {
        return null;
    }
}

//Add class to edit button
function custom_edit_post_link($output) {
 $output = str_replace('class="post-edit-link"', 'class="post-edit-link btn btn-info"', $output);
 return $output;
}
add_filter('edit_post_link', 'custom_edit_post_link');

// filter the Gravity Forms button type
add_filter("gform_submit_button", "form_submit_button", 10, 2);
function form_submit_button($button, $form){
	return "<button class='button btn btn-danger' id='gform_submit_button_{$form["id"]}'><span>Submit</span></button>";
}

function testimonial() {

	$labels = array(
		'name'                => _x( 'Testimonial', 'Post Type General Name', 'r3' ),
		'singular_name'       => _x( 'Testimonial', 'Post Type Singular Name', 'r3' ),
		'menu_name'           => __( 'Testimonial', 'r3' ),
		'parent_item_colon'   => __( 'Testimonial Item:', 'r3' ),
		'all_items'           => __( 'All Testimonial', 'r3' ),
		'view_item'           => __( 'View Testimonial', 'r3' ),
		'add_new_item'        => __( 'Add New Testimonial', 'r3' ),
		'add_new'             => __( 'Add Testimonial', 'r3' ),
		'edit_item'           => __( 'Edit Testimonial', 'r3' ),
		'update_item'         => __( 'Update Testimonial', 'r3' ),
		'search_items'        => __( 'Search Testimonial', 'r3' ),
		'not_found'           => __( 'Not Found', 'r3' ),
		'not_found_in_trash'  => __( 'Not Found in Trash', 'r3' ),
	);
	$args = array(
		'label'               => __( 'testimonial', 'r3' ),
		'description'         => __( 'Our Testimonial', 'r3' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-format-chat',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	
	register_post_type( 'testimonial', $args );

}

// Hook into the 'init' action
add_action( 'init', 'testimonial', 0 );

function slider() {

	$labels = array(
		'name'                => _x( 'Slider', 'Post Type General Name', 'r3' ),
		'singular_name'       => _x( 'Slider', 'Post Type Singular Name', 'r3' ),
		'menu_name'           => __( 'Slider', 'r3' ),
		'parent_item_colon'   => __( 'Slider Item:', 'r3' ),
		'all_items'           => __( 'All Slider', 'r3' ),
		'view_item'           => __( 'View Slider', 'r3' ),
		'add_new_item'        => __( 'Add New Slider', 'r3' ),
		'add_new'             => __( 'Add Slider', 'r3' ),
		'edit_item'           => __( 'Edit Slider', 'r3' ),
		'update_item'         => __( 'Update Slider', 'r3' ),
		'search_items'        => __( 'Search Slider', 'r3' ),
		'not_found'           => __( 'Not Found', 'r3' ),
		'not_found_in_trash'  => __( 'Not Found in Trash', 'r3' ),
	);
	$args = array(
		'label'               => __( 'slider', 'r3' ),
		'description'         => __( 'Our Slider', 'r3' ),
		'labels'              => $labels,
		'supports'            => array( 'title' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 6,
		'menu_icon'           => 'dashicons-format-gallery',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	
	register_post_type( 'slider', $args );

}

// Hook into the 'init' action
add_action( 'init', 'slider', 0 );

function video() {

	$labels = array(
		'name'                => _x( 'Videos', 'Post Type General Name', 'r3' ),
		'singular_name'       => _x( 'Video', 'Post Type Singular Name', 'r3' ),
		'menu_name'           => __( 'Video', 'r3' ),
		'parent_item_colon'   => __( 'Video Item:', 'r3' ),
		'all_items'           => __( 'All Video', 'r3' ),
		'view_item'           => __( 'View Video', 'r3' ),
		'add_new_item'        => __( 'Add New Video', 'r3' ),
		'add_new'             => __( 'Add Video', 'r3' ),
		'edit_item'           => __( 'Edit Video', 'r3' ),
		'update_item'         => __( 'Update Video', 'r3' ),
		'search_items'        => __( 'Search Video', 'r3' ),
		'not_found'           => __( 'Not Found', 'r3' ),
		'not_found_in_trash'  => __( 'Not Found in Trash', 'r3' ),
	);
	$args = array(
		'label'               => __( 'video', 'r3' ),
		'description'         => __( 'Our Video', 'r3' ),
		'labels'              => $labels,
		'supports'            => array( 'title' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 7,
		'menu_icon'           => 'dashicons-video-alt',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	
	register_post_type( 'video', $args );

}

// Hook into the 'init' action
add_action( 'init', 'video', 0 );

/**
 * Snippet Name: Remove wpautop only for custom post types
 */
 function wpc_remove_autop_for_posttype( $content )
{
    // edit the post type here
    'testimonial' === get_post_type() && remove_filter( 'the_content', 'wpautop' );
    return $content;
}
add_filter( 'the_content', 'wpc_remove_autop_for_posttype', 0 );

// Register Custom Post Type
function product_type() {

	$labels = array(
		'name'                  => _x( 'Produk', 'Post Type General Name', 'whegin' ),
		'singular_name'         => _x( 'Produk', 'Post Type Singular Name', 'whegin' ),
		'menu_name'             => __( 'Produk Sukun', 'whegin' ),
		'name_admin_bar'        => __( 'Produk Sukun', 'whegin' ),
		'archives'              => __( 'Item Archives', 'whegin' ),
		'attributes'            => __( 'Item Attributes', 'whegin' ),
		'parent_item_colon'     => __( 'Parent Item:', 'whegin' ),
		'all_items'             => __( 'Semua Produk', 'whegin' ),
		'add_new_item'          => __( 'Tambah Produk Baru', 'whegin' ),
		'add_new'               => __( 'Tambah Baru', 'whegin' ),
		'new_item'              => __( 'Produk Baru', 'whegin' ),
		'edit_item'             => __( 'Edit Produk', 'whegin' ),
		'update_item'           => __( 'Update Produk', 'whegin' ),
		'view_item'             => __( 'Lihat Produk', 'whegin' ),
		'view_items'            => __( 'View Items', 'whegin' ),
		'search_items'          => __( 'Cari Produk', 'whegin' ),
		'not_found'             => __( 'Tidak ditemukan', 'whegin' ),
		'not_found_in_trash'    => __( 'Tidak ditemukan di tong sampah', 'whegin' ),
		'featured_image'        => __( 'Featured Image', 'whegin' ),
		'set_featured_image'    => __( 'Set featured image', 'whegin' ),
		'remove_featured_image' => __( 'Remove featured image', 'whegin' ),
		'use_featured_image'    => __( 'Use as featured image', 'whegin' ),
		'insert_into_item'      => __( 'Insert into item', 'whegin' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'whegin' ),
		'items_list'            => __( 'Items list', 'whegin' ),
		'items_list_navigation' => __( 'Items list navigation', 'whegin' ),
		'filter_items_list'     => __( 'Filter items list', 'whegin' ),
	);
	$args = array(
		'label'                 => __( 'Produk', 'whegin' ),
		'description'           => __( 'Produk Whegin', 'whegin' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-image-filter',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'produk', $args );

}
add_action( 'init', 'product_type', 0 );

function karir() {

	$labels = array(
		'name'                => _x( 'Karir', 'Post Type General Name', 'r3' ),
		'singular_name'       => _x( 'Karir', 'Post Type Singular Name', 'r3' ),
		'menu_name'           => __( 'Karir', 'r3' ),
		'parent_item_colon'   => __( 'Karir Item:', 'r3' ),
		'all_items'           => __( 'All Karir', 'r3' ),
		'view_item'           => __( 'View Karir', 'r3' ),
		'add_new_item'        => __( 'Add New Karir', 'r3' ),
		'add_new'             => __( 'Add Karir', 'r3' ),
		'edit_item'           => __( 'Edit Karir', 'r3' ),
		'update_item'         => __( 'Update Karir', 'r3' ),
		'search_items'        => __( 'Search Karir', 'r3' ),
		'not_found'           => __( 'Not Found', 'r3' ),
		'not_found_in_trash'  => __( 'Not Found in Trash', 'r3' ),
	);
	$args = array(
		'label'               => __( 'karir', 'r3' ),
		'description'         => __( 'Karir', 'r3' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 6,
		'menu_icon'           => 'dashicons-groups',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	
	register_post_type( 'karir', $args );

}

// Hook into the 'init' action
add_action( 'init', 'karir', 0 );


function bahasa() {

	$labels = array(
		'name'                       => _x( 'Bahasa', 'Taxonomy General Name', 'whegin' ),
		'singular_name'              => _x( 'Bahasa', 'Taxonomy Singular Name', 'whegin' ),
		'menu_name'                  => __( 'Bahasa', 'whegin' ),
		'all_items'                  => __( 'All Items', 'whegin' ),
		'parent_item'                => __( 'Parent Item', 'whegin' ),
		'parent_item_colon'          => __( 'Parent Item:', 'whegin' ),
		'new_item_name'              => __( 'New Item Name', 'whegin' ),
		'add_new_item'               => __( 'Add New Item', 'whegin' ),
		'edit_item'                  => __( 'Edit Item', 'whegin' ),
		'update_item'                => __( 'Update Item', 'whegin' ),
		'view_item'                  => __( 'View Item', 'whegin' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'whegin' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'whegin' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'whegin' ),
		'popular_items'              => __( 'Popular Items', 'whegin' ),
		'search_items'               => __( 'Search Items', 'whegin' ),
		'not_found'                  => __( 'Not Found', 'whegin' ),
		'no_terms'                   => __( 'No items', 'whegin' ),
		'items_list'                 => __( 'Items list', 'whegin' ),
		'items_list_navigation'      => __( 'Items list navigation', 'whegin' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'bahasa', array( 'produk', 'karir' ), $args );

}
add_action( 'init', 'bahasa', 0 );

add_theme_support( 'post-thumbnails', array( 'post', 'page', 'produk' ) );
add_action( 'init', create_function( '', 'add_image_size( "news", 500, 300, true );' ) );
add_action( 'init', create_function( '', 'add_image_size( "category-img", 485, 300, true );' ) );