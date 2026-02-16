<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function bm_register_books_cpt() {

    $labels = array(
        'name'               => _x( 'Books', 'post type general name', 'books-manager' ),
        'singular_name'      => _x( 'Book', 'post type singular name', 'books-manager' ),
        'menu_name'          => _x( 'Books', 'admin menu', 'books-manager' ),
        'name_admin_bar'     => _x( 'Book', 'add new on admin bar', 'books-manager' ),
        'add_new'            => _x( 'Add New', 'book', 'books-manager' ),
        'add_new_item'       => __( 'Add New Book', 'books-manager' ),
        'new_item'           => __( 'New Book', 'books-manager' ),
        'edit_item'          => __( 'Edit Book', 'books-manager' ),
        'view_item'          => __( 'View Book', 'books-manager' ),
        'all_items'          => __( 'All Books', 'books-manager' ),
        'search_items'       => __( 'Search Books', 'books-manager' ),
        'not_found'          => __( 'No books found.', 'books-manager' ),
        'not_found_in_trash' => __( 'No books found in Trash.', 'books-manager' )
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'book' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'taxonomies'         => array('genre' ), 
        'show_in_rest'       => true, // For Gutenberg editor
    );

    register_post_type( 'book', $args );

    // Register Taxonomy (Genre)
    $taxonomy_labels = array(
        'name'              => _x( 'Book Domains', 'taxonomy general name', 'books-manager' ),
        'singular_name'     => _x( 'Book Domain', 'taxonomy singular name', 'books-manager' ),
        'search_items'      => __( 'Search Book Domain', 'books-manager' ),
        'all_items'         => __( 'All Book Domain', 'books-manager' ),
        'edit_item'         => __( 'Edit Book Domain', 'books-manager' ),
        'update_item'       => __( 'Update Book Domain', 'books-manager' ),
        'add_new_item'      => __( 'Add New Book Domain', 'books-manager' ),
        'new_item_name'     => __( 'New Book Domain Name', 'books-manager' ),
        'menu_name'         => __( 'Book Domain', 'books-manager' ),
    );

    $taxonomy_args = array(
        'hierarchical'      => true,
        'labels'            => $taxonomy_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'book-domain' ),
        'show_in_rest'      => true,
    );

    register_taxonomy( 'book-domain', array( 'book' ), $taxonomy_args );
   
}

add_action( 'init', 'bm_register_books_cpt' );


