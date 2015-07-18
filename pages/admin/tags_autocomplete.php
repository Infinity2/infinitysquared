<?php
    $header = '';
    $footer = '';
    $dont_output_js_path = true;

    $term = end(explode('=', $_SERVER['REQUEST_URI']));

    $sql = 'SELECT * FROM tags WHERE title LIKE "'.Db::clean($term).'%"';
    $data = Db::query($sql);

    // print $sql;
    // var_dump($data);

    $tags = array();
    if ($data) {
        foreach ($data as $k => $v) {
            $tags[] = array(
                'id'=>$v['id'],
                'label'=>$v['title'],
                'value'=>$v['title']
            );
        }
    }

    echo json_encode($tags);
?>