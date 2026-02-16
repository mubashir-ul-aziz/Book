<?php

if ( ! defined('ABSPATH') ) exit;

class Book_REST_Controller {

    private $namespace = 'mubashir/v1';
    private $rest_base = 'books';

    public function register_routes() {
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base,
            [
                'methods'  => 'GET',
                'callback' => [ $this, 'get_books' ],
                'permission_callback' => '__return_true'
            ]
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base . '/create',
            [
                'methods'  => 'POST',
                'callback' => [ $this, 'create_book' ],
                'permission_callback' => [ $this, 'permissions_check' ]
            ]
        );
    }

    // -------------------------
    // GET /books
    // -------------------------
    public function get_books( $request ) {

        $args = [
            'post_type'      => 'book',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        ];

        $query = new WP_Query($args);

        $data = [];

        if ( $query->have_posts() ) {
            foreach ( $query->posts as $post ) {

                // Taxonomies example
                $authors = wp_get_post_terms( $post->ID, 'author', ['fields' => 'names'] );
                $publisher = wp_get_post_terms( $post->ID, 'publisher', ['fields' => 'names'] );

                // Custom meta fields example
                $price = get_post_meta( $post->ID, 'price', true );
                $isbn  = get_post_meta( $post->ID, 'isbn', true );

                $data[] = [
                    'id'        => $post->ID,
                    'title'     => get_the_title($post->ID),
                    'content'   => apply_filters('the_content', $post->post_content),
                    'excerpt'   => get_the_excerpt($post->ID),
                    'featured_image' => get_the_post_thumbnail_url($post->ID, 'large'),

                    // Meta fields
                    'price'     => $price,
                    'isbn'      => $isbn,

                    // Taxonomies
                    'authors'   => $authors,
                    'publisher' => $publisher,
                ];
            }
        }

        return rest_ensure_response($data);
    }

    // -----------------------------------------------------
    // POST /books/create  (SECURED Endpoint)
    // -----------------------------------------------------
    public function create_book( $request ) {

        // Verify nonce
        $nonce = $request->get_header('X-WP-Nonce');
        if ( ! wp_verify_nonce($nonce, 'wp_rest') ) {
            return new WP_Error('invalid_nonce', 'Nonce verification failed', ['status' => 403]);
        }

        // Authorization
        if ( ! current_user_can('edit_posts') ) {
            return new WP_Error('forbidden', 'You are not allowed to create books', ['status' => 401]);
        }

        $params = $request->get_json_params();

        $new_book = wp_insert_post([
            'post_type'   => 'book',
            'post_title'  => sanitize_text_field($params['title']),
            'post_status' => 'publish'
        ]);

        if ( is_wp_error($new_book) ) {
            return $new_book;
        }

        // Save meta
        if (!empty($params['price'])) {
            update_post_meta($new_book, 'price', sanitize_text_field($params['price']));
        }

        return [
            'message' => 'Book created successfully',
            'book_id' => $new_book
        ];
    }

    // Check permission for POST
    public function permissions_check() {
        return current_user_can('edit_posts');
    }
}



// http://localhost/practicephp/wp-json/mubashir/v1/books




