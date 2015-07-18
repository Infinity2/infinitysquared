<?php
    // $_SESSION['KCFINDER']['disabled'] = false;

    $fp = new FormProcess();
    $fp->setTable('pages');

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
    $images = $alldata['images'];
?>

<?php if ($error): ?>
    <div class="error"><?php echo $error ?></div>
<?php endif ?>

<?php if ($success): ?>
    <div class="success">Data saved</div>
<?php endif ?>

<script>
    tinymce.init({
        height : 500,
        plugins: "link, code",
        selector:'textarea',
        toolbar: [
            "undo redo | styleselect | bold italic | link image | alignleft aligncenter alignright | code"
        ]
        /*file_browser_callback: function(field, url, type, win) {
            tinyMCE.activeEditor.windowManager.open({
                file: 'app/plugins/kcfinder/browse.php?opener=tinymce4&field=' + field + '&type=' + type,
                title: 'KCFinder',
                width: 700,
                height: 500,
                inline: true,
                close_previous: false
            }, {
                window: win,
                input: field
            });
            return false;
        }*/
    });
</script>

<form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="i_id" id="i_id" value="<?php echo $fp->getId(); ?>">

    <label>
        <span>Page</span>
        <input readonly type="text" value="<?php echo (isset($data['title'])) ? ucfirst(str_replace('-', ' ', $data['title'])) : '' ; ?>">
        <input type="hidden" name="title" value="<?php echo $data['title'] ?>">
    </label>

    <label>
        <textarea name="text_1" class="ckeditor" cols="30" rows="10"><?php echo (isset($data['text_1'])) ? $data['text_1'] : '' ; ?></textarea>
    </label>

    <label>
        <span>Photos position</span>
        <select name="photos_right">
            <option value="0" <?php echo ($data['photos_right'] == 0) ? 'selected' : '' ; ?>>Left</option>
            <option value="1" <?php echo ($data['photos_right'] == 1) ? 'selected' : '' ; ?>>Right</option>
        </select>
    </label>

    <label>
        <span>Add photos</span>
        <?php
            for ($i=1; $i <= 4; $i++) { 
        ?>
        <input type="file" name="photo_<?php echo $i ?>">
        <?php
            }
        ?>
    </label>

    <?php if (isset($images)) { ?>
        <label><span>Photo</span></label>
    <?php
            foreach ($images as $k => $v) {
    ?>
        <div class="img_holder_bigger" id="img_<?php echo $v['id'] ?>">
            <input type="button" value="X" class="del_img_btn" data-id="<?php echo $v['id'] ?>" data-confirm="Are you sure you want to DELETE this photo?" />
            <img src="storage/<?php echo $v['type'] ?>s/thmb_<?php echo $v['filename'] ?>" width="300">

            
            <div class="order_holder">
                <span>Position: </span>
                <input type="text" name="file_order_<?php echo $v['id'] ?>" value="<?php echo $v['order_number'] ?>" class="order">
            </div>
        </div>
    <?php
            }
        }
    ?>

    <input type="submit" value="_" style="visibility:hidden;" id="save_btn">
</form>