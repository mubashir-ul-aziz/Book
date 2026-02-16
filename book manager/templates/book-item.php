<?php
// Security check
if ( ! defined( 'ABSPATH' ) ) exit;

// Fetch meta fields  
$author         = get_post_meta(get_the_ID(), '_bm_author', true);
$publisher      = get_post_meta(get_the_ID(), '_bm_publisher', true);
$isbn           = get_post_meta(get_the_ID(), '_bm_isbn', true);
$price          = get_post_meta(get_the_ID(), '_bm_price', true);
$width          = get_post_meta(get_the_ID(), '_bm_width', true);
$height         = get_post_meta(get_the_ID(), '_bm_height', true);
$length         = get_post_meta(get_the_ID(), '_bm_length', true);
$chapters       = get_post_meta(get_the_ID(), '_bm_chapter', true);
$size           = ($width && $height && $length) ? $width . ' x ' . $height . ' x ' . $length : '';

$domains = wp_get_post_terms( get_the_ID(), 'book-domain', ['fields' => 'all'] );
$paper_colors = get_the_terms(get_the_ID(), 'paper_color');
$paper_types = get_the_terms(get_the_ID(), 'paper_type');

// print_r($paper_colors);
// die;
?>

<div class="bk_manager-list-wrapper">
    <div class="inner_wrapper">

        <!-- Featured Image -->
        <div class="feature-image">
            <a href="<?php the_permalink(); ?>">
                <?php if ( has_post_thumbnail() ) : ?>
                    <?php the_post_thumbnail('large'); ?>
                <?php else : ?>
                    <img src="" alt="No Image">
                <?php endif; ?>
            </a>
        </div>

        <!-- Title -->
        <div class="author-name">
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        </div>

        <div class="info-row">
            <div class="info-col">

                <?php if ( $author ) : ?>
                    <p><strong>Book Author:</strong> <?php echo esc_html($author); ?></p>
                <?php endif; ?>

                <?php if ( $chapters ) : ?>
                    <p><strong>Number of Chapters:</strong> <?php echo is_array($chapters) ? count($chapters) : $chapters; ?></p>
                <?php endif; ?>

                <?php  
                // Book Domain terms
                if ( ! empty( $domains ) && ! is_wp_error( $domains ) ) :
                    echo '<p style="display:inline;"><strong>Book Domain:</strong></p>';
                    echo '<ul class="book-domain" style="display:inline;">';
                        foreach ( $domains as $domain ) :
                            echo '<li>' . esc_html($domain->name) . '</li>';
                        endforeach;
                    echo '</ul>';
                endif;
                ?>
                
                <?php if (!empty($paper_colors)) : ?>
                    <p><strong>Paper Color:</strong> 
                    <?php $color_names = wp_list_pluck($paper_colors, 'name');
            echo esc_html(implode(', ', $color_names));?>
            </p>
                <?php endif; ?>

                <?php if (!empty($paper_types) && !empty($paper_types[0]->name)) : ?>
                    <p><strong>Paper Type:</strong> <?php echo esc_html($paper_types[0]->name); ?></p>
                <?php endif; ?>

                <?php if ( $size ) : ?>
                    <p><strong>Book Size:</strong> <?php echo esc_html($size); ?></p>
                <?php endif; ?>

                <?php if ( $isbn ) : ?>
                    <p><strong>ISBN:</strong> <?php echo esc_html($isbn); ?></p>
                <?php endif; ?>

            </div>
        </div>

    </div>
</div>
