<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Add Meta Boxes
function bm_add_books_meta_boxes() {
    add_meta_box(
        'bm_book_details',
        'Book Details',
        'bm_book_details_callback',
        'book',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'bm_add_books_meta_boxes' );

// Meta Box Callback
function bm_book_details_callback( $post ) {
    // Add a nonce field for security
    wp_nonce_field( 'bm_save_book_details', 'bm_book_nonce' );

    $author     = get_post_meta( $post->ID, '_bm_author', true );
    $publisher  = get_post_meta( $post->ID, '_bm_publisher', true );
    $isbn       = get_post_meta( $post->ID, '_bm_isbn', true );
    $pdf_file   = get_post_meta( $post->ID, '_bm_pdf_file', true );
    $bk_price   = get_post_meta( $post->ID, '_bm_price', true );
    $chapters    = get_post_meta( $post->ID, '_bm_chapter', true);

    $width  = get_post_meta($post->ID, '_bm_width', true);
    $length = get_post_meta($post->ID, '_bm_length', true);
    $height = get_post_meta($post->ID, '_bm_height', true);

    // Get selected terms
    $selected_colors = wp_get_post_terms($post->ID, 'paper_color', array('fields' => 'ids'));
    $selected_types  = wp_get_post_terms($post->ID, 'paper_type', array('fields' => 'ids'));

    // Get all terms
    $colors = get_terms(array(
        'taxonomy' => 'paper_color',
        'hide_empty' => false,
    ));

    $types = get_terms(array(
        'taxonomy' => 'paper_type',
        'hide_empty' => false,
    ));

    if( ! is_array($chapters)){
        $chapters = [];
    }
    ?>

    <h3>Book Chapters</h3>
    <table id="bm_chapters_table" style="width:100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="border:1px solid #ccc; padding:5px;">Number</th>
                <th style="border:1px solid #ccc; padding:5px;">Chapter Name</th>
                <th style="border:1px solid #ccc; padding:5px;">Description</th>
                <th style="border:1px solid #ccc; padding:5px;">Remove</th>
            </tr>
        </thead>
        <tbody>
            <?php if ( ! empty( $chapters ) ) : ?>
                <?php foreach ( $chapters as $index => $chapter ) : ?>
                    <tr>
                        <td style="border:1px solid #ccc; padding:5px;text-align: center;font-weight: 700;">
                            <?php echo ($index + 1); ?>
                        </td>
                        <td style="border:1px solid #ccc; padding:5px;">
                            <input type="text" name="bm_chapters[<?php echo $index; ?>][name]" value="<?php echo esc_attr($chapter['name']); ?>" style="width:100%;" />
                        </td>
                        <td style="border:1px solid #ccc; padding:5px;">
                            <textarea name="bm_chapters[<?php echo $index; ?>][description]" rows="4" style="width:100%;"><?php echo esc_textarea($chapter['description']); ?></textarea>
                        </td>
                        <td style="border:1px solid #ccc; padding:5px;text-align: center;">
                            <button class="button bm_remove_chapter">Remove</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <p style=" text-align: right; " >
        <button class="button" id="bm_add_chapter">Add Chapter</button>
    </p>

    <p>
        <label for="bm_pdf_file"><strong>Upload Book PDF:</strong></label><br>
        <input type="text" id="bm_pdf_file" name="bm_pdf_file" value="<?php echo esc_attr( $pdf_file ); ?>" style="width:70%; display: non;" />
        <button class="button bm-upload-pdf">Upload PDF</button>
        <?php if ( $pdf_file ) : ?>
            <div style="margin-top:8px;">
                <strong>Selected File:</strong>  
                <a href="<?php echo esc_url( $pdf_file ); ?>" target="_blank">View PDF</a>
            </div>
        <?php endif; ?>
    </p>

    <p>
        <label for="bm_author">Author:</label><br>
        <input type="text" id="bm_author" name="bm_author" value="<?php echo esc_attr( $author ); ?>" style="width:100%">
    </p>
    <p>
        <label for="bm_publisher">Publisher:</label><br>
        <input type="text" id="bm_publisher" name="bm_publisher" value="<?php echo esc_attr( $publisher ); ?>" style="width:100%">
    </p>
    <p>
        <label for="bm_isbn">ISBN:</label><br>
        <input type="number" id="bm_isbn" name="bm_isbn" value="<?php echo esc_attr( $isbn ); ?>" style="width:100%">
    </p>
    <p>
        <label for="bm_price">Book Price (Rs):</label><br>
        <input type="number" id="bm_price" name="bm_price" value="<?php echo esc_attr( $bk_price ); ?>" 
            style="width:100%" step="0.01" min="0">
    </p>

    <h3>Book Size</h3>
    <p>
        <label>Length (cm):</label><br>
        <input type="number" step="0.1" min="0" name="bm_length" value="<?php echo esc_attr($length); ?>" style="width:30%;">
    </p>

    <p>
        <label>Width (cm):</label><br>
        <input type="number" step="0.1" min="0" name="bm_width" value="<?php echo esc_attr($width); ?>" style="width:30%;">
    </p>

    <p>
        <label>Height (cm):</label><br>
        <input type="number" step="0.1" min="0" name="bm_height" value="<?php echo esc_attr($height); ?>" style="width:30%;">
    </p>

    <p>
        <label for="paper_color">Paper Color:</label><br>
        <select name="paper_color" id="paper_color" style="width:100%;">
            <option value="">Select Color</option>
            <?php foreach ( $colors as $color ) : 
                $selected = in_array( $color->term_id, $selected_colors ) ? 'selected' : ''; ?>
                <option value="<?php echo esc_attr( $color->term_id ); ?>" <?php echo $selected; ?>>
                    <?php echo esc_html( $color->name ); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>


    <p>
        <label for="paper_type">Paper Type:</label><br>
        <select name="paper_type" id="paper_type" style="width:100%;">
            <option value="">Select Type</option>
            <?php foreach ( $types as $type ) : 
                $selected = in_array( $type->term_id, $selected_types ) ? 'selected' : ''; ?>
                <option value="<?php echo esc_attr( $type->term_id ); ?>" <?php echo $selected; ?>>
                    <?php echo esc_html( $type->name ); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>

    <?php
}

// Save Meta Box Data
function bm_save_book_details( $post_id ) {
        
    // Check post type (VERY IMPORTANT)
    if (get_post_type($post_id) !== 'book') {
        return;
    }
    
    // Verify nonce
    if ( ! isset( $_POST['bm_book_nonce'] ) || ! wp_verify_nonce( $_POST['bm_book_nonce'], 'bm_save_book_details' ) ) {
        return;
    }

    // Check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check permissions
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Save fields
    if ( isset( $_POST['bm_author'] ) ) {
        update_post_meta( $post_id, '_bm_author', sanitize_text_field( $_POST['bm_author'] ) );
    }

    if ( isset( $_POST['bm_publisher'] ) ) {
        update_post_meta( $post_id, '_bm_publisher', sanitize_text_field( $_POST['bm_publisher'] ) );
    }

    if ( isset( $_POST['bm_isbn'] ) ) {
        $isbn = $_POST['bm_isbn'];
        $isbn = preg_replace('/[^0-9\-]/', '', $isbn); // allow numbers + hyphens
        update_post_meta( $post_id, '_bm_isbn', $isbn );
    }

    if ( isset( $_POST['bm_pdf_file'])) {
        update_post_meta( $post_id, '_bm_pdf_file', esc_url_raw( $_POST['bm_pdf_file']));
    }

    if ( isset( $_POST['bm_price'] ) ) {
        update_post_meta( $post_id, '_bm_price', floatval( $_POST['bm_price'] ) );
    }

    $chapters = isset($_POST['bm_chapters']) && is_array($_POST['bm_chapters']) ? $_POST['bm_chapters'] : [];

    // Sanitize all fields
    $clean_chapters = [];

    foreach ($chapters as $chapter) {
        // skip empty rows
        if (empty($chapter['name']) && empty($chapter['description'])) {
            continue;
        }

        $clean_chapters[] = [
            'name'        => sanitize_text_field($chapter['name']),
            'description' => sanitize_textarea_field($chapter['description']),
        ];
    }

    // Save final array (clean indexed array)
    update_post_meta($post_id, '_bm_chapter', $clean_chapters);

    if (isset($_POST['bm_width'])) {
        update_post_meta($post_id, '_bm_width', floatval($_POST['bm_width']));
    }

    if (isset($_POST['bm_length'])) {
        update_post_meta($post_id, '_bm_length', floatval($_POST['bm_length']));
    }

    if (isset($_POST['bm_height'])) {
        update_post_meta($post_id, '_bm_height', floatval($_POST['bm_height']));
    }

if ( isset($_POST['paper_color']) ) {
    $color_id = intval($_POST['paper_color']);
    wp_set_post_terms($post_id, [$color_id], 'paper_color', false);
}

if ( isset($_POST['paper_type']) ) {
    $type_id = intval($_POST['paper_type']);
    wp_set_post_terms($post_id, [$type_id], 'paper_type', false);
}



}
add_action( 'save_post', 'bm_save_book_details' );

