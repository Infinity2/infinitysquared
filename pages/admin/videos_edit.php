<?php
    // $_SESSION['KCFINDER']['disabled'] = false;

    $fp = new FormProcess();
    $fp->setTable('videos');

    if (defined('_su4') && (int)_su4 > 0) {
        $fp->setId(_su4);
    } else if (isset($_POST['i_id'])) {
        $fp->setId($_POST['i_id']);
    }

    $error = false;
    $success = false;

    if ($_POST) {
        try {
            $fp->setData($_POST, $_FILES);
            $fp->save();
            $success = true;
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    $alldata = $fp->getData();
    $data = $alldata['data'];
    $tags = Db::query('SELECT t.id, t.title FROM tags t WHERE t.id IN (SELECT tags_id FROM tagged_videos WHERE videos_id = '.$fp->getId().') ORDER BY t.title ASC');
?>

<?php if ($error): ?>
    <div class="error"><?php echo $error ?></div>
<?php endif ?>

<?php if ($success): ?>
    <div class="success">Data saved</div>
<?php endif ?>

<form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="i_id" id="i_id" value="<?php echo $fp->getId(); ?>">

    <label>
        <span>Title</span>
        <input type="text" name="title" value="<?php echo (isset($data['title'])) ? htmlspecialchars($data['title']) : '' ; ?>">
    </label>

    <label>
        <span>Youtube ID</span>
        <input type="text" name="youtube_id" value="<?php echo (isset($data['youtube_id'])) ? htmlspecialchars($data['youtube_id']) : '' ; ?>">
    </label>
    <label>
        <span>Add tags</span>
        <input type="text" id="add_tags" value="">
    </label>
    <div id="tags_holder">
<?php
    if ($tags) {
        foreach ($tags as $k => $v) {
            echo '<div class="tag" id="tag_'.$v['id'].'_'.$fp->getId().'"><span>'.$v['title'].'</span><a href="#" class="a_delete delete_tag_video" data-tag_id="'.$v['id'].'" data-video_id="'.$fp->getId().'"></a></div>';
        }
    }
?>
    </div>
    <label>
        <textarea name="text_1" class="ckeditor" cols="30" rows="10"><?php echo (isset($data['text_1'])) ? $data['text_1'] : '' ; ?></textarea>
    </label>

    <input type="submit" value="_" style="visibility:hidden;">
</form>

<script>
$(document).ready(function(){
    $( "#add_tags" ).autocomplete({
        source: "admin/tags_autocomplete",
        minLength: 2,
        select: function( event, ui ) {
            setTimeout(function(){
                $('#add_tags').val('');
                sjx('adminTagVideo', ui.item.id, $('#i_id').val());
            },10);
        }
    });
});
</script>