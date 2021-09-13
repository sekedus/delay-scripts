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
    $speed_test = get_option('delay_scripts_speed_test_mode') && delay_scripts_is_bot_speed_test() ? 'true' : 'false'; //Detect bot "website speed test"
  
    ?>
<script type="text/javascript" id="delay-scripts">/*{delay-scripts}*/function delayTriggerScriptLoader(){clearTimeout(delayLoadScriptsTimer),delayLoadScripts("timeout"),delayUserInteractionEvents.forEach(function(e){window.removeEventListener(e,delayTriggerScriptLoader,{passive:!0})})}function delayLoadScripts(e){delayList=document.querySelectorAll('script[data-type^="lazy-"]'),delaySort>=delayList.length||e!=delayLoadWith||(console.log("delayLoadScripts: "+delayList[delaySort].getAttribute("data-type")),delayList[delaySort].setAttribute("src",delayList[delaySort].getAttribute("data-src")),setTimeout(function(){delayList[delaySort].classList.add("loaded"),delaySort+=1,delayLoadScripts(e)},500))}var delaySort=0,delayList=[];const delaySpeedTest=<?php echo $speed_test ?>,delayLoadWith=delaySpeedTest?"timeout":"<?php echo $load_with ?>",delayLoadTimeout=<?php echo $timeout ?>,delayLoadOnload="onload"==delayLoadWith;console.log("delayLoadWith: "+delayLoadWith);const delayUserInteractionEvents=["mouseover","keydown","touchmove","touchstart"],delayLoadScriptsTimer=setTimeout(function(){delayLoadScripts("timeout")},1e3*delayLoadTimeout);delayLoadOnload?(clearTimeout(delayLoadScriptsTimer),window.addEventListener("load",function(){delayLoadScripts("onload")})):delayUserInteractionEvents.forEach(function(e){window.addEventListener(e,delayTriggerScriptLoader,{passive:!0})});</script>
    <?php
}

add_action( 'wp_print_footer_scripts', 'delay_scripts_inject_js' );
