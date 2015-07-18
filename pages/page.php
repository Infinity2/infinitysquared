<?php
    $title = ucfirst(str_replace('-', ' ', _su1)).' - '.ucfirst(str_replace('-', ' ', _su2));

    $data = Db::query_row('SELECT * FROM pages WHERE title = "'.Db::clean(_su2).'" LIMIT 1');
    $photos = Db::query('SELECT * FROM files WHERE type = "photo" AND table_name = "pages" AND table_id = '.$data['id'].' ORDER BY order_number ASC');
    $links = Db::query('SELECT * FROM links ORDER BY id ASC');

    $photosRight = $data['photos_right'];
?>
<div class="menu1">
    <img src="img/page_<?php echo _su1 ?>_menu_bg.png" alt="">
    <div class="menu_items <?php echo _su1 ?>">
    <?php if (_su1 ==  'about-us') { ?>
        <a href="about-us/who-we-are" class="first sel">ABOUT US</a>
        <a href="about-us/who-we-are" <?php echo (_su2 == 'who-we-are') ? 'class="sel"' : '' ; ?>>WHO WE ARE</a>
        <a href="about-us/our-values" <?php echo (_su2 == 'our-values') ? 'class="sel"' : '' ; ?>>OUR VALUES</a>
    <?php } else if (_su1 ==  'our-services') { ?>
        <a href="our-services/production-management" class="first sel">OUR SERVICES</a>
        <a href="our-services/production-management" <?php echo (_su2 == 'production-management') ? 'class="sel"' : '' ; ?>>PRODUCTION MANAGEMENT</a>
        <a href="our-services/gear" <?php echo (_su2 == 'gear') ? 'class="sel"' : '' ; ?>>GEAR</a>
    <?php } else if (_su1 ==  'careers') { ?>
        <a href="careers/opportunities" class="first sel">CAREERS</a>
        <a href="careers/opportunities" <?php echo (_su2 == 'opportunities') ? 'class="sel"' : '' ; ?>>OPPORTUNITIES</a>
        <a href="mailto:info@infinity2pro.com">SEND RESUME</a>
    <?php } ?>
    </div>
</div>

<div class="content page <?php echo _su1 ?>">
    <div class="col1">
    <?php if (_su1 ==  'about-us') { ?>
        <a href="about-us/exciting-projects" <?php echo (_su2 == 'exciting-projects') ? 'class="sel"' : '' ; ?>>EXCITING PROJECTS</a>
        <?php /* ?><a href="about-us/our-partners" <?php echo (_su2 == 'our-partners') ? 'class="sel"' : '' ; ?>>OUR PARTNERS</a><?php */ ?>
    <?php } else if (_su1 ==  'our-services') { ?>
        <a href="<?php echo 'gallery/'.$links[2]['files_id']; ?>">MUSIC AND ENTERTAINMENT</a>
        <a href="<?php echo 'gallery/'.$links[3]['files_id']; ?>">SOCIAL EVENTS</a>
        <a href="<?php echo 'gallery/'.$links[4]['files_id']; ?>">SPECIAL OCCASIONS</a>
    <?php } else if (_su1 ==  'careers') { ?>
        <?php /* ?><a href="careers/our-team" <?php echo (_su2 == 'our-team') ? 'class="sel"' : '' ; ?>>OUR TEAM</a><?php */ ?>
        <?php /* ?><a href="<?php echo (substr($links[1]['link'],0,4) == 'http') ? $links[1]['link'] : 'http://'.$links[1]['link'] ; ?>">ACTIVITIES</a><?php */ ?>
        <?php /* ?><a href="careers/partner-with-us" <?php echo (_su2 == 'partner-with-us') ? 'class="sel"' : '' ; ?>>PARTNER WITH US</a><?php */ ?>
    <?php } ?>
    </div>

    <?php if ($photos) { ?>
    <div class="col2 <?php echo ($photosRight) ? 'right' : '' ; ?>">
        <?php
            foreach ($photos as $k => $v) {
        ?>
        <a href="storage/photos/<?php echo $v['filename'] ?>" class="fab"><img src="storage/photos/thmb_<?php echo $v['filename'] ?>" alt=""></a>
        <?php
            }
        ?>
    </div>
    <?php } ?>

    <div class="col3">
    <?php if (_su1 ==  'about-us') { ?>
        <a href="about-us/who-we-are" <?php echo (_su2 == 'who-we-are') ? 'class="sel"' : '' ; ?>>WHO WE ARE</a>
        <a href="about-us/our-values" <?php echo (_su2 == 'our-values') ? 'class="sel"' : '' ; ?>>OUR VALUES</a>

        <a href="about-us/exciting-projects" <?php echo (_su2 == 'exciting-projects') ? 'class="sel"' : '' ; ?>>EXCITING PROJECTS</a>
        <?php /* ?><a href="about-us/our-partners" <?php echo (_su2 == 'our-partners') ? 'class="sel"' : '' ; ?>>OUR PARTNERS</a><?php */ ?>
    <?php } else if (_su1 ==  'our-services') { ?>
        <a href="our-services/production-management" <?php echo (_su2 == 'production-management') ? 'class="sel"' : '' ; ?>>PRODUCTION MANAGEMENT</a>
        <a href="our-services/gear" <?php echo (_su2 == 'gear') ? 'class="sel"' : '' ; ?>>GEAR</a>

        <a href="<?php echo 'gallery/'.$links[2]['files_id']; ?>">MUSIC AND ENTERTAINMENT</a>
        <a href="<?php echo 'gallery/'.$links[3]['files_id']; ?>">SOCIAL EVENTS</a>
        <a href="<?php echo 'gallery/'.$links[4]['files_id']; ?>">SPECIAL OCCASIONS</a>
    <?php } else if (_su1 ==  'careers') { ?>
        <a href="careers/opportunities" <?php echo (_su2 == 'opportunities') ? 'class="sel"' : '' ; ?>>OPPORTUNITIES</a>
        <a href="mailto:info@infinity2pro.com">SEND RESUME</a>

        <?php /* ?><a href="careers/our-team" <?php echo (_su2 == 'our-team') ? 'class="sel"' : '' ; ?>>OUR TEAM</a><?php */ ?>
        <?php /* ?><a href="<?php echo (substr($links[1]['link'],0,4) == 'http') ? $links[1]['link'] : 'http://'.$links[1]['link'] ; ?>">ACTIVITIES</a><?php */ ?>
        <?php /* ?><a href="careers/partner-with-us" <?php echo (_su2 == 'partner-with-us') ? 'class="sel"' : '' ; ?>>PARTNER WITH US</a><?php */ ?>
    <?php } ?>
    </div>
    <div class="text <?php echo (! $photos) ? 'ml300' : '' ; ?>  <?php echo ($photosRight && $photos) ? 'right' : '' ; ?>">
    <?php echo $data['text_1'] ?>
    </div>
    <?php if ($photos) { ?>
    <div class="col4">
        <div class="img_slider">
            <?php
            foreach ($photos as $k => $v) {
            ?>
            <img src="storage/photos/thmb_<?php echo $v['filename'] ?>" alt="">
            <?php
                }
            ?>
        </div>
        <?php if (count($photos) > 1): ?>
        <a href="#" class="arr arr_l"></a>
        <a href="#" class="arr arr_r"></a>
        <?php endif ?>
    </div>
    <?php } ?>
</div>