<?php
    $title = 'Contact Us';

    $data = Db::query_row('SELECT * FROM pages WHERE id = 9');
?>
<div class="content">
    <div class="container n contactus">
        <h1><?php echo $data['text_1'] ?></h1>
        <h2><?php echo $data['text_2'] ?></h2>
        <div class="c1">
            <a href="home"><img src="img/logo3.png" class="logo3" alt="Logo"></a>
            <img src="img/logo4.png" style="display:none;">
            <?php echo $data['text_3'] ?>
            <p>
                <a href="http://www.facebook.com/infinity2pro"><img src="img/icon_fb.png" alt="Facebook"></a>
                <a href="https://www.linkedin.com/company/infinity-squared-productions-l-l-c-"><img src="img/icon_in.png" alt="Linkedin"></a>
                <a href="https://twitter.com/Infinity2pro"><img src="img/icon_tw.png" alt="Twitter"></a>
                <a href="https://www.youtube.com/channel/UCpn_JdsaiI5aoURcn8tkpHQ"><img src="img/icon_yt.png" alt="Youtube"></a>
            </p>
        </div>
        <div class="c2">
            <form action="" id="f_contact_us" onsubmit="sjx('contactForm', $('#f_contact_us').serializeObject()); return false;">
                <label>
                    <span>Name</span>
                    <input type="text" name="name" id="name">
                    *
                </label>
                <label>
                    <span>Phone No.</span>
                    <input type="text" name="phone" id="phone">
                    *
                </label>
                <label>
                    <span>E-mail</span>
                    <input type="text" name="email" id="email">
                    *
                </label>
                <label>
                    <span>Question / Comment</span>
                    <textarea cols="30" rows="6" name="comment" id="comment"></textarea>
                </label>
                <label>
                    <span>Best time to contact</span>
                    <textarea cols="30" rows="6" name="time"></textarea>
                </label>
                <label>
                    <input type="submit" value="SUBMIT" class="submit">
                </label>
            </form>
        </div>
    </div>
</div>