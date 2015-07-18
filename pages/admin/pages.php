<?php
    $error = false;
    $success = false;

    $cnt = Db::query_one('SELECT COUNT(id) FROM pages WHERE pagetype = "page"');
    $all = Db::query('SELECT * FROM pages WHERE pagetype = "page" ORDER BY order_number ASC');
?>
<?php if ($error): ?>
    <div class="error"><?php echo $error ?></div>
<?php endif ?>

<?php if ($success): ?>
    <div class="success">Data saved</div>
<?php endif ?>
<div class="home_title">Pages [<?php echo $cnt ?>]</div>
<table cellspaciong="0" cellpading="0" class="home_table">
    <tr>
        <th>Title</th>
        <th></th>
    </tr>
<?php
    if ($all) {
        foreach ($all as $k => $v) {
?>
    <tr>
        <td><?php echo ucfirst(str_replace('-', ' ', $v['title'])) ?></td>
        <td width="150">
            <?php /* ?><a href="#" id="a_active_<?php echo $v['id'] ?>" class="<?php echo ($v['active'] == 'y') ? 'a_active_y' : 'a_active_n' ; ?>" data-id="<?php echo $v['id'] ?>" data-confirmy="Dali ste sigurni da želite DEKATIVIRATI ovaj članak?" data-confirmn="Dali ste sigurni da želite ATIVIRATI ovaj članak?" data-tt="Aktivno / neaktivno" >Activate / deactivate</a><?php */ ?>
            <a href="admin/pages/edit/<?php echo $v['id'] ?>" class="a_edit" data-tt="Edit">Edit</a>
            <?php /* ?><a href="" class="a_delete" data-tt="Delete">Delete</a><?php */ ?>
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