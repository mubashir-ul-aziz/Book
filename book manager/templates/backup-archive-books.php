<?php
    get_header();

    $args = array(
        'post_type'         => 'book',
        'posts_per_page'    => -1,
        'orderby'           => 'title',
        'order'             => 'ASC'
    );

    $books = new WP_Query( $args );

    // $all_meta = get_post_meta(get_the_ID());
    // echo '<pre>';
    // print_r($all_meta);
    // echo '</pre>';

?>
  
    <?php 

    // print_r($books); 
    
    $books = new WP_Query( $args );?>
  

















    <div class="bk_manager _list">
        <div class="container">

        <!-- left-wrapper Column with Accordion Tabs -->
        <div class="left-wrapper">
            <form method="GET" class="book-filter-form">

<div class="accordion">

    <!-- Author -->
    <div class="accordion-item">
        <div class="accordion-header">Author</div>
        <div class="accordion-content">
            <select name="author">
                <option value="">Select Author</option>
                <option value="John Doe">John Doe</option>
                <option value="Jane Smith">Jane Smith</option>
                <!-- Add dynamic PHP loop here -->
            </select>
        </div>
    </div>

    <!-- Publisher -->
    <div class="accordion-item">
        <div class="accordion-header">Publisher</div>
        <div class="accordion-content">
            <select name="publisher">
                <option value="">Select Publisher</option>
                <option value="ABC Publishing">ABC Publishing</option>
                <option value="XYZ Books">XYZ Books</option>
                <!-- Add dynamic PHP loop here -->
            </select>
        </div>
    </div>

    <!-- Price Range -->
    <!-- Accordion Item -->
<div class="accordion-item">
    <div class="accordion-header">Price Range</div>
    <div class="accordion-content">
        <label>Price: <span id="priceRangeValue">0 - 5000</span></label>
        <div id="priceSlider"></div>
        <input type="hidden" name="min_price" id="minPrice">
        <input type="hidden" name="max_price" id="maxPrice">
    </div>
</div>






    <!-- Paper Color -->
    <div class="accordion-item">
        <div class="accordion-header">Paper Color</div>
        <div class="accordion-content">
            <select name="paper_color">
                <option value="">Select Paper Color</option>
                <option value="White">White</option>
                <option value="Cream">Cream</option>
                <option value="Off White">Off White</option>
            </select>
        </div>
    </div>

    <!-- Paper Type -->
    <div class="accordion-item">
        <div class="accordion-header">Paper Type</div>
        <div class="accordion-content">
            <select name="paper_type">
                <option value="">Select Paper Type</option>
                <option value="Glossy">Glossy</option>
                <option value="Matte">Matte</option>
                <option value="Textured">Textured</option>
            </select>
        </div>
    </div>

    <!-- Domain -->
    <div class="accordion-item">
        <div class="accordion-header">Domain</div>
        <div class="accordion-content">
            <label><input type="radio" name="domain" value="Science"> Science</label><br>
            <label><input type="radio" name="domain" value="Technology"> Technology</label><br>
            <label><input type="radio" name="domain" value="Programming"> Programming</label><br>
            <label><input type="radio" name="domain" value="Math"> Math</label><br>
            <label><input type="radio" name="domain" value="Business"> Business</label>
        </div>
    </div>

</div>

<button type="submit" class="filter-btn">Filter Books</button>

</form>



            <!-- <div class="accordion">

                <div class="accordion-item">
                <div class="accordion-header">Tab 1</div>
                <div class="accordion-content">
                    Content for Tab 1
                </div>
                </div>

                <div class="accordion-item">
                <div class="accordion-header">Tab 2</div>
                <div class="accordion-content">
                    Content for Tab 2
                </div>
                </div>

                <div class="accordion-item">
                <div class="accordion-header">Tab 3</div>
                <div class="accordion-content">
                    Content for Tab 3
                </div>
                </div>

                <div class="accordion-item">
                <div class="accordion-header">Tab 4</div>
                <div class="accordion-content">
                    Content for Tab 4
                </div>
                </div>

                <div class="accordion-item">
                <div class="accordion-header">Tab 5</div>
                <div class="accordion-content">
                    Content for Tab 5
                </div>
                </div>

            </div> -->
            <!-- Book Details Section -->
            <!-- <div class="book-details">
                <h3>Book Details</h3>
                <ul>
                    <li><strong>Author:</strong> John Doe</li>
                    <li><strong>Publisher:</strong> ABC Publishing</li>
                    <li><strong>ISBN:</strong> 123-4567890123</li>
                    <li><strong>Price:</strong> $29.99</li>
                    <li><strong>Size:</strong> 8 x 11 x 1 inches</li>
                    <li><strong>Paper Color:</strong> White</li>
                    <li><strong>Paper Type:</strong> Glossy</li>
                    <li><strong>Domain:</strong>
                        <ul class="book-domain">
                            <li>Science</li>
                            <li>Technology</li>
                            <li>Programming</li>
                        </ul>
                    </li>
                </ul>
            </div> -->
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

            <div class="bk_manager-list-wrapper">
                <div class="inner_wrapper">

                    <!-- Full width image -->
                    <div class="feature-image">
                        <a href="<?php the_permalink(); ?>">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail('large'); ?>
                        <?php else : ?>
                            <img src="" alt="No Image">
                        <?php endif; ?>
                        </a>
                    </div>

                    <!-- Full width Title -->
                    <div class="author-name">
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    </div>

                    <?php  
                        // Fetch meta fields  
                        $author         = get_post_meta(get_the_ID(), '_bm_author', true);
                        $publisher      = get_post_meta(get_the_ID(), '_bm_publisher', true);
                        $isbn           = get_post_meta(get_the_ID(), '_bm_isbn', true);
                        $price          = get_post_meta(get_the_ID(), '_bm_price', true);
                        $width          = get_post_meta(get_the_ID(), '_bm_width', true);
                        $height         = get_post_meta(get_the_ID(), '_bm_height', true);
                        $length         = get_post_meta(get_the_ID(), '_bm_length', true);
                        $paper_color    = get_post_meta(get_the_ID(), '_paper_color', true);
                        $paper_type     = get_post_meta(get_the_ID(), '_paper_type', true);
                        $chapters       = get_post_meta(get_the_ID(), '_bm_chapter', true);
                        $size           = ($width && $height && $length) ? $width . ' x ' . $height . ' x ' . $length : '';
                    ?>

                    <!-- Two column layout -->
                    <div class="info-row">
                        <div class="info-col">

                            <?php if ( $author ) : ?>
                                <p><strong>Book Author:</strong> <?php echo esc_html($author); ?></p>
                            <?php endif; ?>

                            <?php if ( $chapters ) : ?>
                                <p><strong>Number of Chapters:</strong> <?php echo is_array($chapters) ? count($chapters) : $chapters; ?></p>
                            <?php endif; ?>

                            <?php
                            // Get book-domain terms
                            $domains = wp_get_post_terms( get_the_ID(), 'book-domain', ['fields' => 'all'] );
                            if ( ! empty( $domains ) && ! is_wp_error( $domains ) ) :
                                echo '<p style=" display: inline; " ><strong>Book Domain:</strong></p><ul class="book-domain" style=" display: inline; " >';
                                foreach ( $domains as $domain ) :
                                    echo '<li>' . esc_html( $domain->name ) . '</li>';
                                endforeach;
                                echo '</ul>';
                            else :
                                echo '<p><strong>Book Domain:</strong> None</p>';
                            endif;
                            ?>

                            <?php if ( $paper_type ) : ?>
                                <p><strong>Paper Type:</strong> <?php echo esc_html($paper_type); ?></p>
                            <?php endif; ?>

                            <?php if ( $size ) : ?>
                                <p><strong>Book Size:</strong> <?php echo esc_html($size); ?></p>
                            <?php endif; ?>

                            <?php if ( $isbn ) : ?>
                                <p><strong>ISBN:</strong> <?php echo esc_html($isbn); ?></p>
                            <?php endif; ?>

                            <?php if ( $paper_color ) : ?>
                                <p><strong>Paper Color:</strong> <?php echo esc_html($paper_color); ?></p>
                            <?php endif; ?>

                        </div>
                    </div>

                </div>
            </div>

        <?php endwhile; ?>
    </div>
    <?php wp_reset_postdata(); ?>
<?php else : ?>
    <p>No books found.</p>
<?php endif; ?>
</div>

        </div>



    </div>
    </div>


<?php get_footer(); ?>
