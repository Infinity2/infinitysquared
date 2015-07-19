<?php
class Translations
{
    public static function load_lang()
    {
        if( isset($_SESSION['lng']) && in_array($_SESSION['lng'], $_config['languages']) )
        {
            $lng = $_SESSION['lng'];
            
            if( is_file($_config['site_root'].'core/lang_'.$lng.'.txt') )
                $handle = @fopen($_config['site_root'].'core/lang_'.$lng.'.txt', "r");
            
            if( $handle )
            {
                while ( $buffer = fgets($handle) )
                {
                    if( $buffer != '' && substr($buffer,0,1) == '_' )
                    {
                        $pos = strpos($buffer, '=');
                        
                        if( $pos !== false )
                        {
                            $const = trim(substr($buffer,0,$pos));
                            $val = trim(substr($buffer,($pos+1)));
                            
                            define($const, $val);
                        }
                    }
                }
                
                fclose ($handle);
            }
        }
    }
}