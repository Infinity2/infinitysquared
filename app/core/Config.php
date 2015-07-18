<?php
class Config
{
    public static function get($fileKey)
    {
        global $_config;

        if( strpos($fileKey, '.') ) {
            list($file, $key) = explode('.', $fileKey);

            $cfg = require $_config['site_root'].'app/config.'.$file.'.php';

            return ( array_key_exists($key, $cfg) ) ? $cfg[$key] : false ;
        } else if ( $fileKey == 'routes' ) {
            return require_once $_config['site_root'].'app/config.routes.php';
        } else {
            return ( array_key_exists($fileKey, $_config) ) ? $_config[$fileKey] : false ;
        }
    }
}