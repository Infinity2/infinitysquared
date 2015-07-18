<?php
    $title = 'Video Gallery';
    $videos = Db::query('SELECT title, link FROM videogallery ORDER BY order_number DESC');
?>
<div class="content page gallery">
    <div class="motidogallery">
    <?php
        foreach ($videos as $k => $v) {
            parse_str(parse_url($v['link'], PHP_URL_QUERY ), $link_vars);
            $ytid = $link_vars['v'];
    ?>
        <a href="<?php echo $ytid ?>"><img src="app/plugins/thmb.php?src=http://img.youtube.com/vi/<?php echo $ytid ?>/0.jpg&w=1200&h=750" alt=""></a>
    <?php
        }
    ?>
    </div>
</div>
<script>
$(document).ready(function(){
    $('.motidogallery').motidogallery({
        ratio:1.6
    });
});
</script>