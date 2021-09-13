<div class="delay-scripts">
<h2>Delay Scripts</h2>

<?php
    include('settings.php');
    include('faq.php');

    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : "settings";

    if (isset($_POST['submit'])) {
        echo '<div class="notice notice-success is-dismissible"><p>Settings have been saved! Please clear cache if you\'re using a cache plugin</p></div>';
    }
?>

<h2 class="nav-tab-wrapper">
    <a href="?page=delay-scripts&tab=settings" class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : ''; ?>">Settings</a>
    <a href="?page=delay-scripts&tab=faq" class="nav-tab <?php echo $active_tab == 'faq' ? 'nav-tab-active' : ''; ?>">FAQ</a>
</h2>

<?php
    switch ($active_tab) {
        case 'settings':
            delay_scripts_view_settings();
            break;
        case 'faq':
            delay_scripts_view_faq();
            break;
        default:
            delay_scripts_view_settings();
    }
?>

</div>