<?php
    $links = Db::query('SELECT * FROM links ORDER BY id ASC');
?>
<div class="footer">
    <div class="fmenu green">
        <ul>
            <li><a href="about-us/who-we-are" class="first">ABOUT US</a></li>
            <li><a href="about-us/who-we-are">who we are</a></li>
            <li><a href="about-us/our-values">our values</a></li>
            <li><a href="about-us/exciting-projects">exciting projects</a></li>
            <?php /* ?><li><a href="about-us/our-partners">our partners</a></li><?php */ ?>
        </ul>
    </div>
    <div class="fmenu blue">
        <ul>
            <li><a href="our-services/production-management" class="first">OUR SERVICES</a></li>
            <li><a href="our-services/production-management">production management</a></li>
            <li><a href="our-services/gear">gear</a></li>
            <li><a href="<?php echo 'gallery/'.$links[2]['files_id']; ?>">music and entertainment</a></li>
            <li><a href="<?php echo 'gallery/'.$links[3]['files_id']; ?>">social events</a></li>
            <li><a href="<?php echo 'gallery/'.$links[4]['files_id']; ?>">special occasions</a></li>
        </ul>
    </div>
    <div class="fmenu red">
        <ul>
            <li><a href="contact-us" class="first">CONTACT US</a></li>
            <li><a href="tel:(718)709-4499">P: (718) 709-4499</a></li>
            <li><a href="mailto:info@infinity2pro.com">E: info@infinity2pro.com</a></li>
            <li><a href="http://www.facebook.com/infinity2pro" target="_blank">F: www.facebook.com/infinity2pro</a></li>
            <li><a href="#enter_email" class="fab"><img src="img/mail_icon.png" alt=""></a></li>
        </ul>
    </div>
    <div class="fmenu purple">
        <ul>
            <li><a href="gallery" class="first">GALLERY</a></li>
            <li><a href="gallery">photos</a></li>
            <li><a href="video-gallery">videos</a></li>
        </ul>
    </div>
    <div class="fmenu lblue">
        <ul>
            <li><a href="careers/opportunities" class="first">CAREERS</a></li>
            <li><a href="careers/opportunities">opportunities</a></li>
            <li><a href="mailto:info@infinity2pro.com">send resume</a></li>
            <?php /* ?><li><a href="careers/our-team">our team</a></li><?php */ ?>
            <?php /* ?><li><a href="<?php echo (substr($links[1]['link'],0,4) == 'http') ? $links[1]['link'] : 'http://'.$links[1]['link'] ; ?>">activities</a></li><?php */ ?>
            <?php /* ?><li><a href="careers/partner-with-us">partner with us</a></li><?php */ ?>
        </ul>
    </div>

    <ul class="fmenu_m">
        <li class="green"><a href="about-us/who-we-are">ABOUT US</a></li>
        <li class="blue"><a href="our-services/production-management">OUR SERVICES</a></li>
        <li class="red"><a href="contact-us">CONTACT US</a></li>
        <li class="purple"><a href="" class="gallery_link">GALLERY</a></li>
        <li class="purple gallery"><a href="gallery">PHOTO GALLERY</a></li>
        <li class="purple gallery"><a href="video-gallery">VIDEO GALLERY</a></li>
        <li class="lblue"><a href="careers/opportunities">CAREERS</a></li>
    </ul>

    <div class="bottom">
        Infinity Squared Productions L.L.C.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;All rights reserved&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('Y') ?>
    </div>
</div>
<img src="img/main_bg.jpg" style="display:none;">
<div style="display:none;">
    <div id="enter_email" class="c2">
        <div class="error" id="nl_error" style="display:none;">E-mail is invalid!</div>
        <div class="success" id="nl_success" style="display:none;">Thank you. Your e-mail is saved.</div>
        <p>Enter your e-mail to be notified about our activities:</p>
        <input type="text" id="nl_email">
        <input type="button" value="Submit" onclick="sjx('saveEmail', $('#nl_email').val());" class="submit">
    </div>
</div>
</body>
</html>