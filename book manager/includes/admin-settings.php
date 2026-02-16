<?php
// Create admin menu
add_action('admin_menu', 'bk_manager_settings_menu');

function bk_manager_settings_menu() {
    add_menu_page(
        'Book Manager Settings',
        'Book Manager',
        'manage_options',
        'bk-manager-settings',
        'bk_manager_settings_page'
    );
    
}
// Settings Page Markup
function bk_manager_settings_page() {
    // Get saved options
    $paper_colors = get_option('bk_paper_colors', []);
    $paper_types  = get_option('bk_paper_types', []);
    ?>

    <div class="wrap">
        <h1>Book Manager Settings</h1>

        <form method="post" action="options.php">
            <?php settings_fields('bk_manager_settings_group'); ?>
            <?php do_settings_sections('bk_manager_settings_group'); ?>

            <h2>Paper Colors</h2>
            <textarea name="bk_paper_colors" rows="5" cols="50"><?php echo implode("\n", $paper_colors); ?></textarea>
            <p>Add one color per line.</p>

            <h2>Paper Types</h2>
            <textarea name="bk_paper_types" rows="5" cols="50"><?php echo implode("\n", $paper_types); ?></textarea>
            <p>Add one type per line.</p>

            <br>
            <input type="submit" class="button button-primary" value="Save Settings">
        </form>
    </div>

    <?php
}

add_action('admin_init', 'bk_manager_register_settings');
function bk_manager_register_settings() {
    register_setting('bk_manager_settings_group', 'bk_paper_colors', 'bk_manager_convert_to_array');
    register_setting('bk_manager_settings_group', 'bk_paper_types', 'bk_manager_convert_to_array');
}

// Convert textarea lines to array
function bk_manager_convert_to_array($value) {
    $lines = explode("\n", $value);
    return array_filter(array_map('trim', $lines));
}
