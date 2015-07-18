<?php
    // $_SESSION['KCFINDER']['disabled'] = false;

    $fp = new FormProcess();
    $fp->setTable('pages');
    $fp->setId(9);

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
        <span>Main title</span>
        <input type="text" name="text_1" value="<?php echo $data['text_1'] ?>">
    </label>

    <label>
        <span>Subtitle</span>
        <input type="text" name="text_2" value="<?php echo $data['text_2'] ?>">
    </label>

    <label for=""><span>Text under logo</span></label>
    <label>
        <textarea name="text_3" class="ckeditor" cols="30" rows="10"><?php echo (isset($data['text_3'])) ? $data['text_3'] : '' ; ?></textarea>
    </label>

    <input type="submit" value="_" style="visibility:hidden;" id="save_btn">
</form>