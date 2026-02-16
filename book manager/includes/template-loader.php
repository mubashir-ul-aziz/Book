<?php
add_action('init', function() {
//    die('DEBUG: Plugin stopped here!');
});




function myplugin_load_cpt_templates( $template ) {
    if ( is_singular( 'book' ) ) {
        // Go up one level from 'includes/' then into 'templates/'
        $plugin_template = BOOK_MANAGER_PATH . 'templates/single-book.php';

        if ( file_exists( $plugin_template ) ) {
            return $plugin_template;
        } else {
            error_log('Template not found: ' . $plugin_template);
        }
    }

    return $template;
}
add_filter( 'template_include', 'myplugin_load_cpt_templates' );


add_action('init', function() {
    // die('DEBUG: Plugin stopped here!');
});




add_filter( 'template_include', 'bm_load_book_archive_template' );
function bm_load_book_archive_template( $template ) {

    if ( is_post_type_archive( 'book' ) ) {
        $plugin_template = BOOK_MANAGER_PATH . 'templates/archive-books.php';

        if ( file_exists( $plugin_template ) ) {
            return $plugin_template;
        }
    }

    return $template;
}


