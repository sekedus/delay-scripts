<?php

// Check "Website Speed Test" user agent https://sekedus.github.io/project/useragent.html
if ( ! function_exists( 'delay_scripts_is_bot_speed_test' ) ) {
  function delay_scripts_is_bot_speed_test() {
    $user_agent = $_SERVER["HTTP_USER_AGENT"];
    if ( preg_match('/(Pingdom|Lighthouse|GTmetrix|PTST\/|DMBrowser|DareBoost|Phantomas|\sYLT\s)/i', $user_agent) ) return true;
    return false;
  }
}