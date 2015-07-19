<?php
    $slogan = Db::query_one('SELECT text_1 FROM pages WHERE id = 10 LIMIT 1');
?>
<div class="head1 <?php echo (!defined('_su1') || defined('_su1') && _su1 == 'home') ? 'home' : '' ; ?>">
    <div class="container">
        <ul>
            <li><a href="careers/opportunities">Careers</a></li>
            <li>---</li>
            <li><a href="contact-us">Contact us</a></li>
            <li>---</li>
            <li class="gallery">
                <a href="gallery">Gallery</a>
                <div class="gallery_dd">
                    <a href="gallery">Photo gallery</a>
                    <a href="video-gallery">Video gallery</a>
                </div>
            </li>
            <li>---</li>
            <li><a href="our-services/production-management">Our Services</a></li>
            <li>---</li>
            <li><a href="about-us/who-we-are">About us</a></li>
        </ul>
    </div>
</div>
<div class="head2">
    <div class="container">
        <a href="home" class="logo_m"><img src="img/logo1.png" alt=""></a>
        <a href="home" class="logo"></a>
        <div class="social_icons">
            <a target="_blank" href="https://www.google.com/+InfinitySquaredProductionsLLCNewYork"><img src="img/si_gp.png" alt=""></a>
            <a target="_blank" href="https://www.facebook.com/infinity2pro"><img src="img/si_fb.png" alt=""></a>
            <a target="_blank" href="https://twitter.com/Infinity2pro"><img src="img/si_tw.png" alt=""></a>
            <a target="_blank" href="https://www.linkedin.com/company/infinity-squared-productions-l-l-c-"><img src="img/si_in.png" alt=""></a>
            <a target="_blank" href=""><img src="img/si_rss.png" alt=""></a>
            <a target="_blank" href="https://www.youtube.com/channel/UCpn_JdsaiI5aoURcn8tkpHQ"><img src="img/si_yt.png" alt=""></a>
        </div>
        <div class="social_icons_m">
            <a target="_blank" href="https://www.youtube.com/channel/UCpn_JdsaiI5aoURcn8tkpHQ"><img src="img/si_yt.png" alt=""></a>
            <a target="_blank" href=""><img src="img/si_rss.png" alt=""></a>
            <a target="_blank" href="https://www.linkedin.com/company/infinity-squared-productions-l-l-c-"><img src="img/si_in.png" alt=""></a>
            <a target="_blank" href="https://twitter.com/Infinity2pro"><img src="img/si_tw.png" alt=""></a>
            <a target="_blank" href="https://www.facebook.com/infinity2pro"><img src="img/si_fb.png" alt=""></a>
            <a target="_blank" href="https://www.google.com/+InfinitySquaredProductionsLLCNewYork"><img src="img/si_gp.png" alt=""></a>
        </div>
        <h1><?php echo $slogan; ?></h1>
    </div>
</div>
<img src="img/logo2.png" style="display:none;">