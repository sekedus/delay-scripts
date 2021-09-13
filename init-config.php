<?php
// Set default config on plugin load if not set
function delay_scripts_set_default_config() {

    if (DELAY_SCRIPTS_VERSION !== get_option('DELAY_SCRIPTS_VERSION')) {
        
        if (get_option('delay_scripts_load_with') === false)
            update_option('delay_scripts_load_with', 'timeout');

        if (get_option('delay_scripts_timeout') === false)
            update_option('delay_scripts_timeout', 4);

        if (get_option('delay_scripts_speed_test_mode') === false)
            update_option('delay_scripts_speed_test_mode', false);

        if (get_option('delay_scripts_disable_on_login') === false)
            update_option('delay_scripts_disable_on_login', true);

        if (get_option('delay_scripts_include_list') === false)
            update_option('delay_scripts_include_list', []);

        if (get_option('delay_scripts_disabled_pages') === false)
            update_option('delay_scripts_disabled_pages', []);

        update_option('DELAY_SCRIPTS_VERSION', DELAY_SCRIPTS_VERSION);
    }
}

add_action('plugins_loaded', 'delay_scripts_set_default_config');
