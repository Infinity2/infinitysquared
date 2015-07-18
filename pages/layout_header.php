<!doctype html>
<html lang="en">
<head>
    <base href="<?php echo Config::get('site_url') ?>" />
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,width=device-width,user-scalable=no,minimum-scale=1.0,maximum-scale=1.0">

    <title><?php echo ($app->data['title'] != '' ? $app->data['title'].' - '.Config::get('site_title') : Config::get('site_title') ); ?></title>

    <link href="css/style.css?v=1.1" rel="stylesheet" type="text/css" />
    <?php if (isset($_SESSION['cssDesktop'])){ ?>
    <link href="css/desktop.css" rel="stylesheet" type="text/css" />
    <?php } else { ?>
    <link rel="stylesheet" media="screen and (max-width:1015px)" href="css/break1.css?v=1.1"/>
        <?php if (defined('_su1') && _su1 != 'home' && _su1 != '') { ?>
    <link rel="stylesheet" media="screen and (max-width:767px)" href="css/break2_bg.css?v=1.1"/>
        <?php } ?>
    <link rel="stylesheet" media="screen and (max-width:767px)" href="css/break2.css?v=1.1"/>
    <?php } ?>
    <link rel="stylesheet" href="css/jquery.fancybox.css"/>
    <link rel="stylesheet" href="css/motidogallery.css"/>

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.backstrech.js"></script>
    <script type="text/javascript" src="js/jquery.fancybox.pack.js"></script>
    <script type="text/javascript" src="js/functions.js?v=1.1"></script>
    <script type="text/javascript" src="js/sajax.js"></script>
    <?php if (defined('_su1') && _su1 == 'gallery'): ?>
    <script type="text/javascript" src="js/motidogallery.js"></script>
    <?php elseif(defined('_su1') && _su1 == 'video-gallery'): ?>
    <script type="text/javascript" src="js/motidogallery_yt.js"></script>
    <?php endif ?>
</head>
<body>
<?php
    if ((defined('_su1') && _su1 != 'contact-us') || ! defined('_su1')) {
        include 'pages/layout_head.php';
    }
?>