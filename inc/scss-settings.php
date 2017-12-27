<?php
function codegreen_scss_settings_setup() {
    add_submenu_page(
        'themes.php',
        __('SCSS Settings', 'codegreen'),
        __('SCSS Settings', 'codegreen'),
        'manage_options',
        'codegreen-scss-settings',
        'codegreen_render_scss_settings_page'
        );
}

add_action('admin_menu', 'codegreen_scss_settings_setup');

function codegreen_render_scss_settings_page() {
    echo '<div class="wrap">';
    echo '<h1>' . __('SCSS Settings', 'codegreen') . '</h1>';
    
    if (isset($_POST["codegreen_compile_scss"])) {
        codegreen_compile_styles_scss();
        echo '<div class="notice updated is-dismissible"><p>' . __('SCSS rules compiled.', 'codegreen') . '</p></div>';
    }
    
    echo '<form action="" method="post">';
        echo '<p>' . __('Rewrite CSS rules using SCSS template.', 'codegreen') . '</p>';
        echo '<input type="hidden" name="codegreen_compile_scss" value="true">';
        submit_button(__('Compile SCSS Template', 'codegreen'), 'primary', 'codegreen-compile-scss-button', false);
    echo '</form>';
    
    echo '</div>';
}