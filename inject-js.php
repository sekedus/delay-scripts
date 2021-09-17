<?php
include_once('lib/speed-test.php');

function delay_scripts_inject_js() {
  
    // Disable for logged in users
	  if(get_option('delay_scripts_disable_on_login') && is_user_logged_in()) return;
  
    // Abort if the response is AMP since custom JavaScript isn't allowed
    if (function_exists('amp_is_request') && amp_is_request()) return;

    $load_with = esc_attr(get_option('delay_scripts_load_with'));
    $timeout = get_option('delay_scripts_timeout');
    $timeout = $timeout ? esc_attr($timeout) : '4';
    //$speed_test = get_option('delay_scripts_speed_test_mode') && delay_scripts_is_bot_speed_test() ? 'true' : 'false'; //Detect bot "website speed test"
    $speed_test = get_option('delay_scripts_speed_test_mode') ? 'true' : 'false';
  
    ?>
<script type="text/javascript" id="delay-scripts">/*{delay-scripts}*/function delayGuestMode(){var e=navigator.userAgent;return/Pingdom|Lighthouse|GTmetrix|PTST|DMBrowser|DareBoost|(Phantomas|YLT)|Statically|bot|Google|HeadlessChrome/i.test(e)}function delayTriggerScriptLoader(){clearTimeout(delayLoadScriptsTimer),delayTrigger&&delayLoadScripts(delayLoadWith="trigger"),delayUserInteractionEvents.forEach(function(e){window.removeEventListener(e,delayTriggerScriptLoader,{passive:!0})})}function delayLoadScripts(e){var a;e==delayLoadWith&&(a=(delayList=document.querySelectorAll('script[data-type^="lazy-"]'))[delaySort],console.log("[delay-scripts] with: "+delayLoadWith+", load: "+a.dataset.type),a.classList.contains("loaded")||(a.setAttribute("src",a.dataset.src),setTimeout(function(){a.classList.add("loaded"),console.log("[delay-scripts] loaded: "+a.dataset.type),delaySort+1>=delayList.length?console.log("[delay-scripts] All scripts loaded!"):(delaySort+=1,delayLoadScripts(e))},250)))}var delayLoadScriptsTimer,delaySort=0,delayList=[],delayTrigger=!0,delaySpeedTest=<?php echo $speed_test ?>,delayLoadWith=delaySpeedTest&&delayGuestMode()?"timeout":"<?php echo $load_with ?>",delayLoadTimeout=<?php echo $timeout ?>,delayLoadOnload="onload"==delayLoadWith,delayUserInteractionEvents=["mouseover","keydown","touchmove","touchstart"];delayLoadOnload?window.addEventListener("load",function(){delayTrigger=!1,delayLoadScripts("onload")}):delayLoadScriptsTimer=setTimeout(function(){delayTrigger=!1,delayLoadScripts("timeout")},1e3*delayLoadTimeout),delayUserInteractionEvents.forEach(function(e){window.addEventListener(e,delayTriggerScriptLoader,{passive:!0})});</script>
    <?php
}

add_action( 'wp_print_footer_scripts', 'delay_scripts_inject_js' );
