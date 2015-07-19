<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 'on');

	session_start();

	$_config = require_once 'app/config.app.php';
	
	function __autoload($class_name)
    {
        global $_config;

        $to_include = '';

        if( strpos($class_name, '_') )
        {
            list($dir, $cl) = explode('_', $class_name);
            
            if ( is_file($_config['site_root'].'app/core/'.$dir.'/'.$class_name.'.php') )
                $to_include = $_config['site_root'].'app/core/'.$dir.'/'.$class_name.'.php';
            else if ( is_file($_config['site_root'].'app/custom/'.$dir.'/'.$class_name.'.php') )
                $to_include = $_config['site_root'].'app/custom/'.$dir.'/'.$class_name.'.php';
        }
        else
        {
            if ( is_file($_config['site_root'].'app/core/'.$class_name.'.php') )
                $to_include = $_config['site_root'].'app/core/'.$class_name.'.php';
            else if ( is_file($_config['site_root'].'app/custom/'.$class_name.'.php') )
                $to_include = $_config['site_root'].'app/custom/'.$class_name.'.php';
            else
                echo 'Dogodila se greška! functions.php ER.1 : '.$class_name.' : '.$_config['site_url'];
        }

        if( $to_include )
            include_once ($to_include);
        else
            echo 'Error ER.1 : '.$class_name;
    }

	// moramo koristiti varijablu $_db zato jer klasa Db koristi tu varijablu
	$_db = ( $_config['use_database'] == 1 ) ? new Database : null ;