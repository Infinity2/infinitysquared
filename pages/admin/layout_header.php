<?php
    if (! User::isAdmin()) {
        Redirect::to(Config::get('site_url').'admin/login');
    }
?>
<!doctype html>
<html lang="en">
<head>
    <base href="<?php echo Config::get('site_url') ?>" />
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <title><?php echo Config::get('app_name') ?></title>

    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="css/style_admin.css" rel="stylesheet" type="text/css" />
    <link href="css/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" type="text/css" />
    
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/functions_admin.js"></script>
    <script type="text/javascript" src="js/sajax.js"></script>
    <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
</head>
<body>
    <div class="header">
        <span class="title">InfinitySQUARED</span>

        <?php if (defined('_su3') && (_su3 == 'edit' || _su3 == 'create')): ?>
        <input type="button" value="Save" class="save_btn" id="save_btn_header">
        <?php endif ?>

        <a href="admin/logout" class="logout">Logout</a>
    </div>
    <div class="lmenu">
        <ul>
            <li><a href="admin/home_page" <?php echo (defined('_su2') && _su2 == 'home_page') ? 'class="sel"' : '' ; ?>>Home Page Photos</a></li>
            <li><a href="admin/pages" <?php echo (defined('_su2') && _su2 == 'pages') ? 'class="sel"' : '' ; ?>>Pages</a></li>
            <li><a href="admin/links" <?php echo (defined('_su2') && _su2 == 'links') ? 'class="sel"' : '' ; ?>>Links</a></li>
            <li><a href="admin/our_partners" <?php echo (defined('_su2') && _su2 == 'our_partners') ? 'class="sel"' : '' ; ?>>Our partners</a></li>
            <li><a href="admin/gallery" <?php echo (defined('_su2') && _su2 == 'gallery') ? 'class="sel"' : '' ; ?>>Photo Gallery</a></li>
            <li><a href="admin/videogallery" <?php echo (defined('_su2') && _su2 == 'videogallery') ? 'class="sel"' : '' ; ?>>Video Gallery</a></li>
            <li><a href="admin/testimonials" <?php echo (defined('_su2') && _su2 == 'testimonials') ? 'class="sel"' : '' ; ?>>Testimonials</a></li>
            <li><a href="admin/emails" <?php echo (defined('_su2') && _su2 == 'emails') ? 'class="sel"' : '' ; ?>>E-mails</a></li>
            <li><a href="admin/excitingprojects" <?php echo (defined('_su2') && _su2 == 'excitingprojects') ? 'class="sel"' : '' ; ?>>Exciting projects</a></li>
            <li><a href="admin/contacts_page/edit" <?php echo (defined('_su2') && _su2 == 'contacts_page') ? 'class="sel"' : '' ; ?>>Contacts page text</a></li>
            <li><a href="admin/slogan/edit" <?php echo (defined('_su2') && _su2 == 'slogan') ? 'class="sel"' : '' ; ?>>Slogan edit</a></li>
        </ul>
    </div>
    <div class="content">