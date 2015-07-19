<?php
    $title = 'Gallery';
    $galleries = Db::query('SELECT * FROM gallery ORDER BY order_number DESC');

    $photos = array();
    foreach ($galleries as $k => $v) {
        $p = Db::query('SELECT id, filename FROM files WHERE table_name = "gallery" AND table_id = '.$v['id'].' ORDER BY order_number ASC');

        foreach ($p as $pk => $pv) {
            $photos[] = array('id'=>$pv['id'], 'filename'=>$pv['filename']);
        }
    }
    // $photos = Db::query('SELECT id, filename FROM files WHERE table_name = "gallery" AND table_id IN(SELECT id FROM gallery ORDER BY order_number DESC) ORDER BY order_number ASC');
?>
<div class="content page gallery">
    <div class="motidogallery">
    <?php
        foreach ($photos as $k => $v) {
    ?>
        <a href="app/plugins/thmb.php?src=storage/photos/<?php echo $v['filename'] ?>&w=1200&h=750" data-gid="<?php echo $v['id'] ?>"><img src="app/plugins/thmb.php?src=storage/photos/thmb_<?php echo $v['filename'] ?>&w=200&h=125" alt=""></a>
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