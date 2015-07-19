<?php
    // $_SESSION['KCFINDER']['disabled'] = false;

    $fp = new FormProcess();
    $fp->setTable('videogallery');

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

<form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="i_id" id="i_id" value="<?php echo $fp->getId(); ?>">

    <label>
        <span>Title</span>
        <input type="text" name="title" value="<?php echo (isset($data['title'])) ? htmlspecialchars($data['title']) : '' ; ?>">
    </label>
    
    <label>
        <span>Youtube link</span>
        <input type="text" name="link" value="<?php echo (isset($data['link'])) ? htmlspecialchars($data['link']) : '' ; ?>">
    </label>

    <input type="submit" value="_" style="visibility:hidden;" id="save_btn">
</form>