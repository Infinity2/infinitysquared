<?php
    $error = false;
    $success = false;

    $all = Db::query('SELECT * FROM tags ORDER BY id DESC');
?>

<?php if ($error): ?>
    <div class="error"><?php echo $error ?></div>
<?php endif ?>

<?php if ($success): ?>
    <div class="success">Data saved</div>
<?php endif ?>
<div class="home_title">Tags</div>
<table cellspaciong="0" cellpading="0" class="home_table">
    <tr>
        <th>Tag</th>
        <th></th>
    </tr>
<?php
    foreach ($all as $k => $v) {
?>
    <tr>
        <td><?php echo $v['title'] ?></td>
        <td width="150">
            <a href="admin/tags/edit/<?php echo $v['id'] ?>" class="a_edit" data-tt="Edit">Edit</a>
            <a href="" class="a_delete" data-tt="Delete">Delete</a>
        </td>
    </tr>
<?php
    }
?>
</table>