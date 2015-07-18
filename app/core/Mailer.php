<?php
class Mailer
{
    public static function sendHtmlMail($from, $to, $subject, $msg)
    {
        $message = '
            <html>
            <head>
              <title>'.$subject.'</title>
            </head>
            <body>
                '.$msg.'
            </body>
            </html>
        ';
        
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        
        $headers .= 'From: '.Config::get('app_name').'<'.$from.'>'."\r\n";
        $headers .= 'X-Mailer: PHP/'.phpversion();
        
        $m = mail($to, $subject, $message, $headers);
        
        return $m;
    }
}