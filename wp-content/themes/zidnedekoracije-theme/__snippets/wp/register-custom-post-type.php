<?php

function magicwalls_register_post_type() {
    $singular = 'Custom post type name'; // Book
	$plural = 'Custom post type names';  // Books
	
    $slug = str_replace( ' ', '-', strtolower( $singular ) );

    $labels = array(
        'name' 			      => __( $plural, 'magicwalls' ),
        'singular_name' 	  => __( $singular, 'magicwalls' ),
        'add_new' 		      => _x( 'Add New', 'magicwalls', 'magicwalls' ),
        'add_new_item'  	  => __( 'Add New ' . $singular, 'magicwalls' ),
        'edit'		          => __( 'Edit', 'magicwalls' ),
        'edit_item'	          => __( 'Edit ' . $singular, 'magicwalls' ),
        'new_item'	          => __( 'New ' . $singular, 'magicwalls' ),
        'view' 			      => __( 'View ' . $singular, 'magicwalls' ),
        'view_item' 		  => __( 'View ' . $singular, 'magicwalls' ),
        'search_term'   	  => __( 'Search ' . $plural, 'magicwalls' ),
        'parent' 		      => __( 'Parent ' . $singular, 'magicwalls' ),
        'not_found'           => __( 'No ' . $plural .' found', 'magicwalls' ),
        'not_found_in_trash'  => __( 'No ' . $plural .' in Trash', 'magicwalls' ),
    );

    $args = array(
        'labels'              => $labels,
        'hierarchical'        => false,
        'public'              => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'has_archive'         => true,
        'rewrite'             => array('slug' => $slug),
        'menu_icon'           => '',
        'supports'            => array( 'title', 'thumbnail', 'editor' )
    );

    register_post_type( $slug, $args );
}

add_action( 'init', 'magicwalls_register_post_type' );