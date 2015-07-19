<?php
    $error = false;
    $success = false;

    $cnt = Db::query_one('SELECT COUNT(id) FROM videos');
    $all = Db::query('SELECT * FROM videos ORDER BY order_number DESC');
?>

<?php if ($error): ?>
    <div class="error"><?php echo $error ?></div>
<?php endif ?>

<?php if ($success): ?>
    <div class="success">Data saved</div>
<?php endif ?>
<div class="home_title">Videos [<?php echo $cnt ?>]</div>
<table cellspaciong="0" cellpading="0" class="home_table">
    <tr>
        <th>Title</th>
        <th>Tags</th>
        <th></th>
    </tr>
<?php
    if ($all) {
        foreach ($all as $k => $v) {
            $tagsIds = Db::query('SELECT tags_id FROM tagged_videos WHERE videos_id = '.$v['id'].' ORDER BY id DESC');
            
            $tagsIdsArray = array();
            $tagsArray = array();
            if ($tagsIds) {
                foreach ($tagsIds as $tk => $tv) {
                    $tagsIdsArray[] = $tv['tags_id'];
                }

                $tags = Db::query('SELECT title FROM tags WHERE id IN('.implode(',', $tagsIdsArray).')');
                
                foreach ($tags as $tk => $tv) {
                    $tagsArray[] = $tv['title'];
                }
            }
?>
    <tr>
        <td><?php echo $v['title'] ?></td>
        <td><?php echo implode(', ', $tagsArray); ?></td>
        <td width="150">
            <a href="#" id="a_active_<?php echo $v['id'] ?>" class="<?php echo ($v['active'] == 'y') ? 'a_active_y' : 'a_active_n' ; ?>" data-id="<?php echo $v['id'] ?>" data-confirmy="Dali ste sigurni da želite DEKATIVIRATI ovaj članak?" data-confirmn="Dali ste sigurni da želite ATIVIRATI ovaj članak?" data-tt="Aktivno / neaktivno" >Activate / deactivate</a>
            <a href="admin/videos/edit/<?php echo $v['id'] ?>" class="a_edit" data-tt="Edit">Edit</a>
            <a href="" class="a_delete" data-tt="Delete">Delete</a>
        </td>
    </tr>
<?php
        }
    } else {
?>
    <tr>
        <td colspan="3">Nema</td>
    </tr>
<?php
    }
?>
</table>