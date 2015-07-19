<?php
    // $_SESSION['KCFINDER']['disabled'] = false;

    $fp = new FormProcess();
    $fp->setTable('gallery');

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
        <span>Add photos</span>
        <?php
            for ($i=1; $i <= 8; $i++) { 
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
            <span class="photo_id">ID: <?php echo $v['id'] ?></span>
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