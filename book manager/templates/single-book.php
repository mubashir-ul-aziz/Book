<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

get_header(); 
// Fetch meta fields
$author         = get_post_meta(get_the_ID(), '_bm_author', true);
$publisher      = get_post_meta(get_the_ID(), '_bm_publisher', true);
$isbn           = get_post_meta(get_the_ID(), '_bm_isbn', true);
$price          = get_post_meta(get_the_ID(), '_bm_price', true);
$width          = get_post_meta(get_the_ID(), '_bm_width', true);
$height         = get_post_meta(get_the_ID(), '_bm_height', true);
$length         = get_post_meta(get_the_ID(), '_bm_length', true);
$paper_color    = get_post_meta(get_the_ID(), '_paper_color', true);
$pdf_file       = get_post_meta(get_the_ID(), '_bm_pdf_file', true);
$chapters       = get_post_meta($post->ID, '_bm_chapter', true);
$size           = $width . ' x ' . $height . ' x ' . $length;

$terms = get_the_terms(get_the_ID(), 'book-domain');
$paper_colors = get_the_terms(get_the_ID(), 'paper_color');
$paper_types = get_the_terms(get_the_ID(), 'paper_type');
?>

<?php 

    // $all_meta = get_post_meta(get_the_ID());
    // echo '<pre>';
    // print_r($all_meta);
    // echo '</pre>';

?>

<div class="bk_manager _detail">
<div class="container">

    <!-- LEFT COLUMN -->
    <div class="left-wrapper">

        <!-- ACCORDION -->
        <div class="accordion">
            <?php if ( is_array( $chapters ) && ! empty( $chapters ) ) : ?>
                <?php foreach ( $chapters as $index => $chapter ) : ?>
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <?php echo 'Chapter ' . ( $index + 1 ) . ': ' . esc_html( $chapter['name'] ); ?>
                        </div>
                        <div class="accordion-content">
                            <?php echo esc_html( $chapter['description'] ); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No chapters available.</p>
            <?php endif; ?>
        </div>

        <!-- BOOK DETAILS -->
        <div class="book-details">
            <h3>Book Details</h3>
            <ul>
                <?php if (!empty($author)) : ?>
                    <li><strong>Author:</strong> <?php echo esc_html($author); ?></li>
                <?php endif; ?>
                <?php if (!empty($publisher)) : ?>
                    <li><strong>Publisher:</strong> <?php echo esc_html($publisher); ?></li>
                <?php endif; ?>
                <?php if (!empty($isbn)) : ?>
                    <li><strong>ISBN:</strong> <?php echo esc_html($isbn); ?></li>
                <?php endif; ?>
                <?php if (!empty($price)) : ?>
                    <li><strong>Price:</strong> <?php echo esc_html($price); ?></li>
                <?php endif; ?>
                <?php if (!empty($size)) : ?>
                    <li><strong>Size:</strong> <?php echo esc_html($size); ?></li>
                <?php endif; ?>
                <?php if (!empty($paper_colors)) : ?>
                    <li><strong>Paper Color:</strong>
                        <?php 
                            $color_names = wp_list_pluck($paper_colors, 'name');
                            echo esc_html(implode(', ', $color_names));
                        ?>
                    </li>
                <?php endif; ?>
                <?php if (!empty($paper_types) && !empty($paper_types[0]->name)) : ?>
                    <li><strong>Paper Type:</strong> 
                        <?php echo esc_html($paper_types[0]->name); ?>
                    </li>
                <?php endif; ?>
                <?php 
                if (!empty($terms) && !is_wp_error($terms)) : ?>
                    <li><strong>Domain:</strong>
                        <ul class="book-domain" style="display: inline;">
                            <?php foreach ($terms as $term): ?>
                                <li><?php echo esc_html($term->name); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>

    <!-- CENTER COLUMN -->
    <div class="center-wrapper">

        <div class="feature-image">
            <?php echo get_the_post_thumbnail(get_the_ID(), 'large'); ?>
        </div>

        <h2 class="book-title"><?php echo get_the_title(); ?></h2>

        <div class="book-description">
            <?php the_content(); ?>
        </div>

        <div class="book-buttons">
            <?php if ($pdf_file): ?>
                <a href="<?php echo esc_url($pdf_file); ?>" target="_blank" class="read-btn">Read Book</a>
                <a href="<?php echo esc_url($pdf_file); ?>" download class="download-btn">Download PDF</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- RIGHT COLUMN -->
    <div class="right-wrapper">
        Right wrapper content
    </div>

</div>
</div>

<?php
get_footer();
