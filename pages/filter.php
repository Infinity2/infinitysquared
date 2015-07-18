<?php
    $title = '';

    $allTags = explode(':', _su2);
    foreach ($allTags as $tag) {
        if ((int)$tag > 0) {
            $filterTags[] = (int)$tag;
        }
    }

    $sql = 'SELECT v.* FROM videos v WHERE v.id IN(
                SELECT v.videos_id FROM tagged_videos AS v
                WHERE v.tags_id IN ('.implode(',', $filterTags).')
                GROUP BY v.videos_id
                HAVING COUNT(*) >= '.count($filterTags).')';
    $videos = Db::query($sql);

    ob_start();
    $otherTags = array();
    foreach ($videos as $k => $v) {
        $tagsArray = array();
        $tags = Db::query('SELECT id, title FROM tags WHERE id IN(SELECT tags_id FROM tagged_videos WHERE videos_id = '.$v['id'].' ORDER BY id DESC)');
        if ($tags) {
            foreach ($tags as $tk => $tv) {
                $tagsArray[$tv['id']] = $tv['title'];

                if (! in_array($tv['id'], $filterTags)) {
                    $otherTags[$tv['id']] = $tv['title'];
                }
            }
        }

        if (trim($v['title']) == '') {
            $doc = new DOMDocument;
            $doc->load('http://gdata.youtube.com/feeds/api/videos/'.$v['youtube_id']);
            $vtitle = $doc->getElementsByTagName("title")->item(0)->nodeValue;
        } else {
            $vtitle = $v['title'];
        }
?>
<div class="box" style="background-image: url('http://img.youtube.com/vi/<?php echo $v['youtube_id'] ?>/0.jpg');">
    <div class="tags">
    <?php
        foreach ($tagsArray as $tagId => $tag) {
            echo '<a href="filter/'.$tagId.'">'.$tag.'</a>';
        }
    ?>
    </div>
    <div class="title">
        <h2><?php echo $vtitle ?></h2>
        <p><?php echo nl2br($v['text_1']) ?></p>
    </div>
    <a href="video/<?php echo $v['id'].'/'.Strings::cleanUrl($v['title']) ?>" class="link"></a>
</div>
<?php
    }

    $videosHtml = ob_get_contents();
    ob_end_clean();
?>

<?php if ($otherTags): ?>    
<div class="add_tag_holder">
<?php
    foreach ($otherTags as $tagId => $tagTitle) {
        echo '<a href="filter/'._su2.':'.$tagId.'"><span class="plus">+</span><span>'.$tagTitle.'</span></a> ';
    }
?>
</div>
<?php endif ?>



<div>
<?php
    echo $videosHtml
?>
</div>