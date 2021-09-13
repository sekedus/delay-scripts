<?php
include('lib/dom-parser.php');

function delay_scripts_is_keyword_included($content, $keywords)
{
    foreach ($keywords as $keyword) {
        if (strpos($content, $keyword) !== false) {
            return true;
        }
    }
    return false;
}

function delay_scripts_rewrite_html($html)
{
    try {
        // Process only GET requests
		if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
		  return $html;
		}
        
        // Disable for logged in users
        if ( get_option('delay_scripts_disable_on_login') && is_user_logged_in() ) return $html;
        
        // Detect non-HTML
        if (!isset($html) || trim($html) === '' || strcasecmp(substr($html, 0, 5), '<?xml') === 0 || trim($html)[0] !== "<") {
            return $html;
        }

        // Exclude on pages
        $disabled_pages = get_option('delay_scripts_disabled_pages');
        $current_url = home_url($_SERVER['REQUEST_URI']);
        if (delay_scripts_is_keyword_included($current_url, $disabled_pages)) {
            return $html;
        }


        // Parse HTML
        $newHtml = str_get_html($html);

        // Not HTML, return original
        if (!is_object($newHtml)) {
            return $html;
        }

        $include_list = get_option('delay_scripts_include_list');
        $number_sort = 1;

        foreach ($newHtml->find("script[!type],script[type='text/javascript']") as $script) {
            if (delay_scripts_is_keyword_included($script->outertext, $include_list)) {
                $script->setAttribute("data-type", "lazy-". $number_sort);
                if ($script->getAttribute("src")) {
                    $script->setAttribute("data-src", $script->getAttribute("src"));
                    $script->removeAttribute("src");
                } else {
                    $script->setAttribute("data-src", "data:text/javascript;base64,".base64_encode($script->innertext));
                    $script->innertext="";
                }
                $number_sort++;
            }
        }
        
        return $newHtml;
    } catch (Exception $e) {
        return $html;
    }
}

if ( !is_admin() ) {
    ob_start("delay_scripts_rewrite_html");
}

// W3TC HTML rewrite
add_filter('w3tc_process_content', function ($buffer) {
    if ( is_admin() ) return $buffer;
    return delay_scripts_rewrite_html($buffer);
});
