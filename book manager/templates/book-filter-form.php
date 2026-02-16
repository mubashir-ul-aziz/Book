<?php
// Make sure variables like $authors, $publishers, $paper_colors, etc. are passed or available globally
?>
<form method="GET" id="book-filter-form" class="book-filter-form">

<div class="accordion">

    <!-- Author -->
    <div class="accordion-item">
        <div class="accordion-header">Author</div>
        <div class="accordion-content">
            <select name="author">
                <option value="">Select Author</option>
                <?php foreach ($authors as $author_option): ?>
                    <option value="<?php echo esc_attr($author_option); ?>">
                        <?php echo esc_html($author_option); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <!-- Publisher -->
    <div class="accordion-item">
        <div class="accordion-header">Publisher</div>
        <div class="accordion-content">
            <select name="publisher">
                <option value="">Select Publisher</option>
                <?php foreach ($publishers as $publisher_option): ?>
                    <option value="<?php echo esc_attr($publisher_option); ?>">
                        <?php echo esc_html($publisher_option); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <!-- Price Range -->
    <div class="accordion-item">
        <div class="accordion-header">Price Range</div>
        <div class="accordion-content">
            <label>Price: <span id="priceRangeValue"><?php echo $min_price . ' - ' . $max_price; ?></span></label>
            <div id="priceSlider"
                 data-min="<?php echo $min_price; ?>"
                 data-max="<?php echo $max_price; ?>">
            </div>
            <input type="hidden" name="min_price" id="minPrice" value="<?php echo $min_price; ?>">
            <input type="hidden" name="max_price" id="maxPrice" value="<?php echo $max_price; ?>">
        </div>
    </div>

    <!-- Paper Color -->
    <div class="accordion-item">
        <div class="accordion-header">Paper Color</div>
        <div class="accordion-content">
            <select name="paper_color">
                <option value="">Select Paper Color</option>
                <?php foreach ($paper_colors as $color) : ?>
                    <option value="<?php echo esc_attr($color->term_id); ?>"><?php echo esc_html($color->name); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <!-- Paper Type -->
    <div class="accordion-item">
        <div class="accordion-header">Paper Type</div>
        <div class="accordion-content">
            <select name="paper_type">
                <option value="">Select Paper Type</option>
                <?php foreach ($paper_types as $type) : ?>
                    <option value="<?php echo esc_attr($type->term_id); ?>"><?php echo esc_html($type->name); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <!-- Domain -->
    <div class="accordion-item">
        <div class="accordion-header">Domain</div>
        <div class="accordion-content">
            <select name="domain">
                <option value="">Select Domain</option>
                <?php foreach ($domains as $domain) : ?>
                    <option value="<?php echo esc_attr($domain->term_id); ?>"><?php echo esc_html($domain->name); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

</div>

<button type="submit" class="filter-btn">Filter Books</button>

</form>
