<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Shortcode to display books
function bm_books_list_shortcode( $atts ) {
    // Attributes (optional)
    $atts = shortcode_atts(
        array(
            'posts_per_page' => 10,
            'genre' => '', // Optional filter by genre slug
        ),
        $atts,
        'books_list'
    );

    // Query args
    $args = array(
        'post_type'      => 'book',
        'posts_per_page' => intval( $atts['posts_per_page'] ),
        'post_status'    => 'publish',
    );

    // Filter by genre if provided
    if ( ! empty( $atts['genre'] ) ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'genre',
                'field'    => 'slug',
                'terms'    => sanitize_text_field( $atts['genre'] ),
            ),
        );
    }

    $query = new WP_Query( $args );

    // Output buffer
    $output = '<div class="bm-books-list">';

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();

            $all_meta = get_post_meta( get_the_ID());
            // print_r($all_meta);

            $author     = get_post_meta( get_the_ID(), '_bm_author', true );
            $publisher  = get_post_meta( get_the_ID(), '_bm_publisher', true );
            $isbn       = get_post_meta( get_the_ID(), '_bm_isbn', true );

            $thumbnail  = get_the_post_thumbnail(get_the_ID(), 'medium', [
                'class' => 'bm_book_thumb'
            ]);

            $description = wpautop( get_the_excerpt());

            $pdf_file   = get_post_meta( get_the_ID(), '_bm_pdf_file', true );

            $bk_price   = get_post_meta( get_the_ID(), '_bm_price', true);
            $chapters = get_post_meta(get_the_ID(), '_bm_chapter', true);

            $width  = get_post_meta(get_the_ID(), '_bm_width', true);
            $length = get_post_meta(get_the_ID(), '_bm_length', true);
            $height = get_post_meta(get_the_ID(), '_bm_height', true);
            
            $output .= '<div class="bm-book-item">';

            $output .= '<div class="bm-book-thumb-wrap ">' . $thumbnail . '</div>'; 
            $output .= '<h3 class="bm-book-title">' . get_the_title() . '</h3>';
            $output .= '<p><strong>Author:</strong> ' . esc_html( $author ) . '</p>';
            $output .= '<p><strong>Publisher:</strong> ' . esc_html( $publisher ) . '</p>';
            $output .= '<p><strong>ISBN:</strong> ' . esc_html( $isbn ) . '</p>';
            $output .= '<div class="bm-book-desc">' . $description . '</div>';
            if( $pdf_file ){
                $file_name = basename($pdf_file);
                $output .= '<div class="bm-book-pdf-buttons" style="margin-top:10px;">';
                $output .= '<a href="' . esc_url($pdf_file) . '" target="_blank" class="button" style="margin-right:5px;display: inline-block;">View PDF</a>';
                $output .= '<a href="' . esc_url($pdf_file) . '" download class="button" style="display: inline-block;">Download PDF</a>';
                $output .= '<h3 style="margin-top:5px; font-size:16px;">' . esc_html($file_name) . '</h3>';
                $output .= '</div>';
            }
            $output .= '<p><strong>Price:</strong> ' . esc_html($bk_price) . ' Rs </p>';

            if (!empty($chapters) && is_array($chapters)) {
                echo '<ul>';
                foreach ($chapters as $index => $chapter) {
                    // $index starts from 0, so add 1 for display
                    $display_index = $index + 1;

                    echo '<li>';
                    echo '<strong>Chapter ' . $display_index . ':</strong> ';
                    echo 'Name: ' . esc_html($chapter['name']) . '<br>';
                    echo 'Description: ' . esc_html($chapter['description']);
                    echo '</li>';
                }
                echo '</ul>';
            } else {
                echo 'No chapters found.';
            }

            if(!empty($width) || !empty($length) || !empty($height)){
                $output .= "<p><strong>Size</strong> (Width x Length x Height): {$width}cm × {$length}cm × {$height}cm  </p>";
            }

            // Show genres
            $genres = get_the_terms( get_the_ID(), 'genre' );
            if ( $genres && ! is_wp_error( $genres ) ) {
                $genre_list = wp_list_pluck( $genres, 'name' );
                $output .= '<p><strong>Book Domain:</strong> ' . implode( ', ', $genre_list ) . '</p>';
            }

            

            $output .= '</div>'; // bm-book-item
        }
        wp_reset_postdata();
    } else {
        $output .= '<p>No books found.</p>';
    }

    $output .= '</div>'; // bm-books-list

    return $output;
}
add_shortcode( 'books_list', 'bm_books_list_shortcode' );
