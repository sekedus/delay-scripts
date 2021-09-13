<?php

// Add credit links in plugins list
function delay_scripts_add_action_links($links) {
  
    array_unshift(
        $links,
        '<a href="https://sociabuzz.com/sekedus/donate" target="_blank" style="color:#3db634;font-weight:bold;">Donate</a>',
        '<a href="'. admin_url('options-general.php?page=delay-scripts') .'">'. __('Settings') .'</a>',
        '<a href="'. admin_url('plugin-editor.php?plugin=delay-scripts%2Fdelay-scripts.php') .'">'. __('Edit') .'</a>'
    );
    
    return $links;
    
}
