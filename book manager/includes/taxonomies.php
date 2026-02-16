<?php

// Register Paper Color Taxonomy
function bm_register_paper_color_taxonomy() {
    $labels = array(
        'name'              => 'Paper Colors',
        'singular_name'     => 'Paper Color',
        'search_items'      => 'Search Paper Colors',
        'all_items'         => 'All Paper Colors',
        'parent_item'       => 'Parent Paper Color',
        'parent_item_colon' => 'Parent Paper Color:',
        'edit_item'         => 'Edit Paper Color',
        'update_item'       => 'Update Paper Color',
        'add_new_item'      => 'Add New Paper Color',
        'new_item_name'     => 'New Paper Color Name',
        'menu_name'         => 'Paper Colors',
    );

    register_taxonomy('paper_color', 'book', array(
        'hierarchical'      => true, // like categories
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'rewrite'           => array('slug' => 'paper-color'),
    ));
}

// Register Paper Type Taxonomy
function bm_register_paper_type_taxonomy() {
    $labels = array(
        'name'              => 'Paper Types',
        'singular_name'     => 'Paper Type',
        'search_items'      => 'Search Paper Types',
        'all_items'         => 'All Paper Types',
        'parent_item'       => 'Parent Paper Type',
        'parent_item_colon' => 'Parent Paper Type:',
        'edit_item'         => 'Edit Paper Type',
        'update_item'       => 'Update Paper Type',
        'add_new_item'      => 'Add New Paper Type',
        'new_item_name'     => 'New Paper Type Name',
        'menu_name'         => 'Paper Types',
    );

    register_taxonomy('paper_type', 'book', array(
        'hierarchical'      => true, // like categories
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'rewrite'           => array('slug' => 'paper-type'),
    ));
}

add_action('init', 'bm_register_paper_color_taxonomy');
add_action('init', 'bm_register_paper_type_taxonomy');
