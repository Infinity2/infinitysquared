<?php
    $error = false;
    $success = false;

    $cnt = Db::query_one('SELECT COUNT(id) FROM home_page');
    $all = Db::query('SELECT * FROM home_page ORDER BY order_number DESC');
?>

<a href="admin/home_page/create" class="new_btn">+ Add new</a>

<?php if ($error): ?>
    <div class="error"><?php echo $error ?></div>
<?php endif ?>

<?php if ($success): ?>
    <div class="success">Data saved</div>
<?php endif ?>
<div class="home_title">Home Page Photos [<?php echo $cnt ?>]</div>
<table cellspaciong="0" cellpading="0" class="home_table">
    <tr>
        <th>Title</th>
        <th>Location</th>
        <th></th>
    </tr>
<?php
    if ($all) {
        $i = 0;
        foreach ($all as $k => $v) {
            $i++;
?>
    <tr id="tr_<?php echo $v['id'] ?>">
        <td><?php echo $v['title'] ?></td>
        <td><?php echo $v['location'] ?></td>
        <td width="150">
            <?php /* ?><a href="#" id="a_active_<?php echo $v['id'] ?>" class="<?php echo ($v['active'] == 'y') ? 'a_active_y' : 'a_active_n' ; ?>" data-id="<?php echo $v['id'] ?>" data-confirmy="Dali ste sigurni da želite DEKATIVIRATI ovaj članak?" data-confirmn="Dali ste sigurni da želite ATIVIRATI ovaj članak?" data-tt="Aktivno / neaktivno" >Activate / deactivate</a><?php */ ?>
            <a href="admin/home_page/edit/<?php echo $v['id'] ?>" class="a_edit" data-tt="Edit">Edit</a>
            <a href="#" class="a_delete" data-id="<?php echo $v['id'] ?>" data-table="home_page" data-confirmy="Are you sure you want to DELETE this entry?" data-tt="Delete">Delete</a>

            <?php if ($i < $cnt): ?>
            <a href="#" class="a_down" data-tt="down" data-id="<?php echo $v['id'] ?>" data-table="home_page">Down</a>
            <?php endif ?>
            <?php if ($i == $cnt): ?>
            <div class="a_ph"></div>
            <?php endif ?>
            <?php if ($i != 1): ?>
            <a href="#" class="a_up" data-tt="up" data-id="<?php echo $v['id'] ?>" data-table="home_page">Up</a>
            <?php endif ?>
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