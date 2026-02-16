<?php
    get_header();

    $args = array(
        'post_type'         => 'book',
        'posts_per_page'    => -1,
        'orderby'           => 'title',
        'order'             => 'ASC',
        'post_status'    => 'publish'
    );

    // $books = new WP_Query( $args );

    
    $books = new WP_Query($args);

    $authors = array();
    $publishers = array();
    $prices = array();
    
    if ($books->have_posts()) {
    while ($books->have_posts()) {
        $books->the_post();

        $author = get_post_meta(get_the_ID(), '_bm_author', true);
        $publisher = get_post_meta(get_the_ID(), '_bm_publisher', true);
        $price = get_post_meta(get_the_ID(), '_bm_price', true);

        if ($author) $authors[] = $author;
        if ($publisher) $publishers[] = $publisher;
        if ($price) $prices[] = floatval($price);
    }
    wp_reset_postdata();
}
    
    $authors = array_unique($authors);
$publishers = array_unique($publishers);
$min_price = !empty($prices) ? min($prices) : 0;
$max_price = !empty($prices) ? max($prices) : 0;


// Paper Color Terms
$paper_colors = get_terms(array(
    'taxonomy'   => 'paper_color',
    'hide_empty' => false,
));

// Paper Type Terms
$paper_types = get_terms(array(
    'taxonomy'   => 'paper_type',
    'hide_empty' => false,
));

// Domain Terms
$domains = get_terms(array(
    'taxonomy'   => 'book-domain',
    'hide_empty' => false,
));

// echo '<pre>';
// echo "Authors: "; print_r($authors);
// echo "Publishers: "; print_r($publishers);
// echo "Price Range: $min_price - $max_price";
// echo '</pre>';

    ?>

    <div class="bk_manager _list">
        <div class="container">

        <!-- left-wrapper Column with Accordion Tabs -->
        <div class="left-wrapper">
 <?php include BOOK_MANAGER_PATH . 'templates/book-filter-form.php'; ?>
        </div>

        <div class="center-wrapper">
        <!-- Layout Selector -->
            <div class="layout-controls" style="margin-bottom: 20px;display: none;">
                <label for="layout-select">Choose Layout: </label>
                <select id="layout-select">
                    <option value="row">Row</option>
                    <option value="grid-3">Grid 3 Columns</option>
                    <option value="grid-4">Grid 4 Columns</option>
                </select>
            </div>

            <!-- Inner container -->
<div class="inner-container">

    <?php if ( $books->have_posts() ) : ?>
        <div class="bk_manager-archive-wrapper">

            <?php while ( $books->have_posts() ) : $books->the_post(); ?>

                <? // universal path ?>
                <?php include BOOK_MANAGER_PATH . 'templates/book-item.php'; ?> 

            <?php endwhile; ?>

        </div>
    <?php else : ?>
        <p>No books found.</p>
    <?php endif; ?>

</div>

        </div>



    </div>
    </div>


<?php get_footer(); ?>


