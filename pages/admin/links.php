<?php
    $error = false;
    $success = false;

    $cnt = Db::query_one('SELECT COUNT(id) FROM links');
    $all = Db::query('SELECT * FROM links WHERE id > 1 ORDER BY order_number DESC');
?>

<?php if ($error): ?>
    <div class="error"><?php echo $error ?></div>
<?php endif ?>

<?php if ($success): ?>
    <div class="success">Data saved</div>
<?php endif ?>
<div class="home_title">Links [<?php echo $cnt ?>]</div>
<table cellspaciong="0" cellpading="0" class="home_table">
    <tr>
        <th>Title</th>
        <th></th>
    </tr>
<?php
    if ($all) {
        $i = 0;
        foreach ($all as $k => $v) {
            $i++;
?>
    <tr id="tr_<?php echo $v['id'] ?>">
        <td><?php echo ucfirst(str_replace('-', ' ', $v['title'])) ?></td>
        <td width="150">
            <a href="admin/links/edit/<?php echo $v['id'] ?>" class="a_edit" data-tt="Edit">Edit</a>
        </td>
    </tr>
<?php
        }
    } else {
?>
    <tr>
        <td colspan="3">No data</td>
    </tr>
<?php
    }
?>
</table>