<?php
// // die();
if (!defined('ABSPATH')) exit;

// Ajax action for logged-in and guest users
add_action('wp_ajax_filter_books', 'bm_filter_books_callback');
add_action('wp_ajax_nopriv_filter_books', 'bm_filter_books_callback');

function bm_filter_books_callback() {

    $args = array(
        'post_type'      => 'book',
        'posts_per_page' => -1,
        'post_status'    => 'publish'
    );

    // Author filter
    if (!empty($_POST['author'])) {
        $args['meta_query'][] = array(
            'key'   => '_bm_author',
            'value' => sanitize_text_field($_POST['author']),
        );
    }

    // Publisher filter
    if (!empty($_POST['publisher'])) {
        $args['meta_query'][] = array(
            'key'   => '_bm_publisher',
            'value' => sanitize_text_field($_POST['publisher']),
        );
    }

    // Price range
    if (!empty($_POST['min_price']) && !empty($_POST['max_price'])) {
        $args['meta_query'][] = array(
            'key'     => '_bm_price',
            'value'   => array(floatval($_POST['min_price']), floatval($_POST['max_price'])),
            'type'    => 'NUMERIC',
            'compare' => 'BETWEEN'
        );
    }

    // Paper Color taxonomy
    if (!empty($_POST['paper_color'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'paper_color',
            'field'    => 'term_id',
            'terms'    => intval($_POST['paper_color'])
        );
    }

    // Paper Type taxonomy
    if (!empty($_POST['paper_type'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'paper_type',
            'field'    => 'term_id',
            'terms'    => intval($_POST['paper_type'])
        );
    }

    // Domain taxonomy
    if (!empty($_POST['domain'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'book-domain',
            'field'    => 'term_id',
            'terms'    => intval($_POST['domain'])
        );
    }

    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // return HTML of each book
            include BOOK_MANAGER_PATH . 'templates/book-item.php';
        }
    } else {
        echo "<p>No books found.</p>";
    }

    wp_reset_postdata();

    $output = ob_get_clean();
    echo $output;
    wp_die();
}




