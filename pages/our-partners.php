<?php
    $title = 'About us - Our partners';

    $data = Db::query('SELECT p.*, (SELECT filename FROM files WHERE table_id = p.id AND table_name = "partners" LIMIT 1) photo FROM partners p ORDER BY order_number DESC');
    $links = Db::query('SELECT * FROM links ORDER BY id ASC');
?>
<div class="menu1">
    <img src="img/page_<?php echo _su1 ?>_menu_bg.png" alt="">
    <div class="menu_items <?php echo _su1 ?>">
        <a href="about-us/who-we-are" class="first sel">ABOUT US</a>
        <a href="about-us/who-we-are" <?php echo (_su2 == 'who-we-are') ? 'class="sel"' : '' ; ?>>WHO WE ARE</a>
        <a href="about-us/our-values" <?php echo (_su2 == 'our-values') ? 'class="sel"' : '' ; ?>>OUR VALUES</a>
    </div>
</div>

<div class="content page <?php echo _su1 ?>">
    <div class="col1">
        <a href="about-us/exciting-projects" <?php echo (_su2 == 'exciting-projects') ? 'class="sel"' : '' ; ?>>EXCITING PROJECTS</a>
        <a href="about-us/our-partners" <?php echo (_su2 == 'our-partners') ? 'class="sel"' : '' ; ?>>OUR PARTNERS</a>
    </div>
    <div class="col3">
        <a href="about-us/who-we-are" <?php echo (_su2 == 'who-we-are') ? 'class="sel"' : '' ; ?>>WHO WE ARE</a>
        <a href="about-us/our-values" <?php echo (_su2 == 'our-values') ? 'class="sel"' : '' ; ?>>OUR VALUES</a>

        <a href="about-us/exciting-projects" <?php echo (_su2 == 'exciting-projects') ? 'class="sel"' : '' ; ?>>EXCITING PROJECTS</a>
        <a href="about-us/our-partners" <?php echo (_su2 == 'our-partners') ? 'class="sel"' : '' ; ?>>OUR PARTNERS</a>
    </div>
    <div class="text ml300">
    <?php
        foreach ($data as $k => $v) {
            $link = (substr($v['link'],0,4) == 'http') ? $v['link'] : 'http://'.$v['link'] ;
    ?>
        <a class="partner" href="<?php echo $link ?>">
            <h3><?php echo $v['title'] ?></h3>
            <img src="storage/photos/thmb_<?php echo $v['photo'] ?>" alt="">
            <p><?php echo nl2br($v['text_1']) ?></p>
        </a>
    <?php
        }
    ?>
    </div>
</div>