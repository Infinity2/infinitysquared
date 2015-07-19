<?php
    $title = '';

    $testimonials = Db::query('SELECT * FROM testimonials');
    $homePhotos = Db::query('SELECT h.*, (SELECT filename FROM files WHERE table_name = "home_page" AND table_id = h.id LIMIT 1) photo FROM home_page h ORDER BY h.order_number DESC');

    $i = 0;
    $home_slides = array();
    foreach ($homePhotos as $k => $v) {
        $home_slides[] = ['photo' => 'storage/photos/'.$v['photo'], 'title' => $v['title'], 'location' => $v['location'] ];
        $i++;
    }
?>

<div class="content home">
    <div class="backstretch-caption">
        <span class="backstretch-caption-content"></span>
    </div>
</div>

<div class="testimonials">
    <?php
        $s = rand(1,count($testimonials));
        $i = 0;
        if ($testimonials) {
            foreach ($testimonials as $k => $v) {
                $i++;
    ?>
        <div class="text <?php echo ($i == $s) ? 'sel' : '' ; ?>">
            <p><?php echo $v['text_1'] ?></p>
            <span><?php echo $v['title'] ?></span>
            <div class="cf"></div>
        </div>
    <?php
            }
        }
    ?>
</div>
<script>
    var home_slides = <?php echo json_encode($home_slides) ?>;
</script>
