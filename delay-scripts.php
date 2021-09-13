<?php
/**
 * Plugin Name: Delay Scripts
 * Plugin URI: https://github.com/sekedus/delay-scripts
 * Description: Download and execute JavaScript on user interaction.
 * Author: Sekedus
 * Author URI: https://sekedus.com/
 * Version: 1.0.0
 * Text Domain: delay-scripts
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

// Define constant with current version
define('DELAY_SCRIPTS_VERSION', '1.0.0');

include('init-config.php');
include('settings/index.php');
include('inject-js.php');
include('html-rewrite.php');
include('shortcuts.php');
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'delay_scripts_add_action_links');

// Appends additional links below each/specific plugin on the plugins page.
function delay_scripts_add_row_meta($links, $file) {
  
    /* We only want to affect the Delay Scripts plugin listing */
    if ( plugin_basename(__FILE__) !== $file ) {
      return $links;
    }
    
    $row_meta = array(
        '<a href="https://wordpress.org/plugins/flying-scripts/" target="_blank">Source</a>',
        '<a href="'. admin_url('options-general.php?page=delay-scripts&tab=faq') .'">'. __('FAQ') .'</a>'
    );
    
    return array_merge($links, $row_meta);
    
}
add_filter('plugin_row_meta', 'delay_scripts_add_row_meta', 10, 2);
