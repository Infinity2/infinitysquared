<?php
    // $_SESSION['KCFINDER']['disabled'] = false;

    $fp = new FormProcess();
    $fp->setTable('partners');

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
        <span>Link</span>
        <input type="text" name="link" value="<?php echo (isset($data['link'])) ? htmlspecialchars($data['link']) : '' ; ?>">
    </label>
    <label>
        <span>Description</span>
        <textarea name="text_1" cols="30" rows="10"><?php echo (isset($data['text_1'])) ? $data['text_1'] : '' ; ?></textarea>
    </label>
    
    <?php if (! isset($images)) { ?>
    <label>
        <span>Add photo</span>
        <input type="file" name="photo_1">
    </label>
    <?php } ?>

    <?php if (isset($images)) { ?>
        <label><span>Photo</span></label>
    <?php
            foreach ($images as $k => $v) {
    ?>
        <div class="img_holder_bigger" id="img_<?php echo $v['id'] ?>">
            <input type="button" value="X" class="del_img_btn" data-id="<?php echo $v['id'] ?>" data-confirm="Are you sure you want to DELETE this photo?" />
            <img src="storage/<?php echo $v['type'] ?>s/<?php echo $v['filename'] ?>" width="300">

            <?php /* ?>
            <div class="order_holder">
                <span>Position: </span>
                <input type="text" name="file_order_<?php echo $v['id'] ?>" value="<?php echo $v['order_number'] ?>" class="order">
            </div>
            <?php */ ?>
        </div>
    <?php
            }
        }
    ?>

    <input type="submit" value="_" style="visibility:hidden;" id="save_btn">
</form>