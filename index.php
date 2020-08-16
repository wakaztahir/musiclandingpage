<?php
/*
Plugin Name: Music Landing Page
Plugin URI: http://example.com
Description: Creates smart links for music
Version: 1.1
Author: Waqas Tahir
Author URI: http://example.com
License: GPL2
*/

// --------------------------FrontEnd Section--------------

//Registering A Stylesheet
function mlp_frontend_styles(){
    wp_register_style( "main",plugin_dir_url(__FILE__)."frontend-style.css", array(),true);

    wp_enqueue_style( "main");
}

add_action( "wp_enqueue_scripts", "mlp_frontend_styles");

//----------------------------Admin Section-----------------

//Registering A Music Release taxonomy
if ( ! function_exists( 'mlp_tax_releases' ) ) {

    function mlp_tax_releases() {
    
        $labels = array(
            'name'                       => _x( 'Releases', 'Taxonomy General Name', 'mlp_music' ),
            'singular_name'              => _x( 'Release', 'Taxonomy Singular Name', 'mlp_music' ),
            'menu_name'                  => __( 'All Releases', 'mlp_music' ),
            'all_items'                  => __( 'All Releases', 'mlp_music' ),
            'new_item_name'              => __( 'New Release Name', 'mlp_music' ),
            'add_new_item'               => __( 'Add New Release', 'mlp_music' ),
            'edit_item'                  => __( 'Edit Release', 'mlp_music' ),
            'update_item'                => __( 'Update Release', 'mlp_music' ),
            'view_item'                  => __( 'View Release', 'mlp_music' ),
            'separate_items_with_commas' => __( 'Separate releases with commas', 'mlp_music' ),
            'add_or_remove_items'        => __( 'Add or remove releases', 'mlp_music' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'mlp_music' ),
            'popular_items'              => __( 'Popular Releases', 'mlp_music' ),
            'search_items'               => __( 'Search Releases', 'mlp_music' ),
            'not_found'                  => __( 'Not Found', 'mlp_music' ),
            'no_terms'                   => __( 'No Releases', 'mlp_music' ),
            'items_list'                 => __( 'Releases list', 'mlp_music' ),
            'items_list_navigation'      => __( 'Releases list navigation', 'mlp_music' ),
        );
        $rewrite = array(
            'slug'                       => '/release',
            'with_front'                 => true,
            'hierarchical'               => false,
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => false,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => false,
            'show_tagcloud'              => false,
            'rewrite'                    => $rewrite,
        );
        register_taxonomy( 'mlp_releases', array( 'mlp_song' ), $args );
    
    }
    add_action( 'init', 'mlp_tax_releases', 0 );
    
}

// Registering Song Custom Post Type
if ( !function_exists('mlp_songs') ) {

    function mlp_songs() {
    
        $labels = array(
            'name'                  => _x( 'Songs', 'Post Type General Name', 'mlp' ),
            'singular_name'         => _x( 'Song', 'Post Type Singular Name', 'mlp' ),
            'menu_name'             => __( 'Music', 'mlp' ),
            'name_admin_bar'        => __( 'Song', 'mlp' ),
            'archives'              => __( 'Song Archives', 'mlp' ),
            'attributes'            => __( 'Song Attributes', 'mlp' ),
            'parent_item_colon'     => __( '', 'mlp' ),
            'all_items'             => __( 'All Songs', 'mlp' ),
            'add_new_item'          => __( 'Add New Song', 'mlp' ),
            'add_new'               => __("Add A Song","mlp"),
            'new_item'              => __( 'New Item', 'mlp' ),
            'edit_item'             => __( 'Edit Song', 'mlp' ),
            'update_item'           => __( 'Update Song', 'mlp' ),
            'view_item'             => __( 'View Song', 'mlp' ),
            'view_items'            => __( 'View Songs', 'mlp' ),
            'search_items'          => __( 'Search Song', 'mlp' ),
            'not_found'             => __( 'Not found', 'mlp' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'mlp' ),
            'featured_image'        => __( 'Featured Image', 'mlp' ),
            'set_featured_image'    => __( 'Set featured image', 'mlp' ),
            'remove_featured_image' => __( 'Remove featured image', 'mlp' ),
            'use_featured_image'    => __( 'Use as featured image', 'mlp' ),
            'insert_into_item'      => __( 'Insert into item', 'mlp' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'mlp' ),
            'items_list'            => __( 'Items list', 'mlp' ),
            'items_list_navigation' => __( 'Items list navigation', 'mlp' ),
            'filter_items_list'     => __( 'Filter items list', 'mlp' ),
        );
        $rewrite = array(
            'slug'                  => "/song",
            'with_front'            => true,
            'pages'                 => false,
            'feeds'                 => false,
        );
        $args = array(
            'label'                 => __( 'Song', 'mlp' ),
            'description'           => __( 'All of your musical works', 'mlp' ),
            'labels'                => $labels,
            'supports'              => array( 'thumbnail',"title"),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 25,
            'menu_icon'             => 'dashicons-album',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'rewrite'               => $rewrite,
            'show_in_rest'          => true,
        );
        register_post_type( 'mlp_song', $args );
    
    }
    add_action( 'init', 'mlp_songs', 0 );
    
}
add_filter( 'rwmb_meta_boxes', 'mlp_register_meta_boxes' );

// Registering Smart Link Custom Post Type
function mlp_create_smartlink_cpt() {

	$labels = array(
		'name' => _x( 'Smart Links', 'Post Type General Name', 'mlp' ),
		'singular_name' => _x( 'Smart Link', 'Post Type Singular Name', 'mlp' ),
		'menu_name' => _x( 'Smart Links', 'Admin Menu text', 'mlp' ),
		'name_admin_bar' => _x( 'Smart Link', 'Add New on Toolbar', 'mlp' ),
		'archives' => __( 'Smart Link Archives', 'mlp' ),
		'attributes' => __( 'Smart Link Attributes', 'mlp' ),
		'parent_item_colon' => __( 'Parent Smart Link:', 'mlp' ),
		'all_items' => __( 'All Smart Links', 'mlp' ),
		'add_new_item' => __( 'Add New Smart Link', 'mlp' ),
		'add_new' => __( 'Add New', 'mlp' ),
		'new_item' => __( 'New Smart Link', 'mlp' ),
		'edit_item' => __( 'Edit Smart Link', 'mlp' ),
		'update_item' => __( 'Update Smart Link', 'mlp' ),
		'view_item' => __( 'View Smart Link', 'mlp' ),
		'view_items' => __( 'View Smart Links', 'mlp' ),
		'search_items' => __( 'Search Smart Link', 'mlp' ),
		'not_found' => __( 'Not found', 'mlp' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'mlp' ),
		'featured_image' => __( 'Featured Image', 'mlp' ),
		'set_featured_image' => __( 'Set featured image', 'mlp' ),
		'remove_featured_image' => __( 'Remove featured image', 'mlp' ),
		'use_featured_image' => __( 'Use as featured image', 'mlp' ),
		'insert_into_item' => __( 'Insert into Smart Link', 'mlp' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Smart Link', 'mlp' ),
		'items_list' => __( 'Smart Links list', 'mlp' ),
		'items_list_navigation' => __( 'Smart Links list navigation', 'mlp' ),
		'filter_items_list' => __( 'Filter Smart Links list', 'mlp' ),
	);
	$rewrite = array(
		'slug' => '/link',
		'with_front' => true,
		'pages' => false,
		'feeds' => false,
	);
	$args = array(
		'label' => __( 'Smart Link', 'mlp' ),
		'description' => __( 'Create Smart Links for Releases', 'mlp' ),
		'labels' => $labels,
		'menu_icon' => 'dashicons-admin-links',
		'supports' => array("title"),
		'taxonomies' => array(),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => "edit.php?post_type=mlp_song",
		'menu_position' => 5,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => false,
		'can_export' => true,
		'has_archive' => false,
		'hierarchical' => false,
		'exclude_from_search' => true,
		'show_in_rest' => false,
		'publicly_queryable' => true,
		'capability_type' => 'post',
		'rewrite' => $rewrite,
	);
	register_post_type( 'mlp_link', $args );

}
add_action( 'init', 'mlp_create_smartlink_cpt', 0 );

// -------------------------------Templates-----------------------

// Registering Smart Link Template
function mlp_link_template( $template ) {
    global $post;

    if ( 'mlp_link' === $post->post_type && locate_template( array( 'single-mlp_link.php' ) ) !== $template ) {
        return plugin_dir_path( __FILE__ ) . 'single-mlp_link.php';
    }

    return $template;
}

add_filter( 'single_template', 'mlp_link_template' );

//Registering ACF
include plugin_dir_path(__FILE__)."mlp-acf.php";

?>