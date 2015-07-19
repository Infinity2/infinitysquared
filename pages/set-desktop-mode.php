<?php
    if (defined('_su2') && _su2 == '1') {
        $_SESSION['cssDesktop'] = true;
    } else if(defined('_su2') && _su2 == '0') {
        unset($_SESSION['cssDesktop']);
    }

    Redirect::to(Config::get('site_url').$_SESSION['lastUrl']);
?>