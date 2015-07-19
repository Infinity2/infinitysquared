<?php
    $header = '';
    $footer = '';

    $emails = Db::query('SELECT * FROM emails ORDER BY id DESC');

    $file = "Infinitysquared e-mails ".date('Y-m-d')."\n\n";

    foreach ($emails as $k => $v) {
        $file .= $v['title'].";\n";
    }

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=emails_'.date('d_m_y').'.csv');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    // header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    echo $file;
    exit;
?>