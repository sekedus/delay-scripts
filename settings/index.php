<?php

// Register settings menu
function delay_scripts_register_settings_menu() {
    add_options_page('Delay Scripts', 'Delay Scripts', 'manage_options', 'delay-scripts', 'delay_scripts_view_view');
}
add_action('admin_menu', 'delay_scripts_register_settings_menu');

// Settings page
function delay_scripts_view_view() {
    // Validate nonce
    if (isset($_POST['submit']) && !wp_verify_nonce($_POST['delay-scripts-settings-form'], 'delay-scripts')) {
        echo '<div class="notice notice-error"><p>Nonce verification failed</p></div>';
        exit;
    }

    // Settings
    include 'view.php';
}
