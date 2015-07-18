<?php
    if( $_POST && isset($_POST['fja']) )
    {
        chdir('../');
        include 'app/load.php';

        ShotPage::loadLang();

        $data = ( isset($_POST['data']) && is_array($_POST['data']) ) ? $_POST['data'] : Array() ;
        $jqa = new SAjaxFunctions( $_POST['fja'], $data );
    }