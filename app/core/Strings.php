<?php
class Strings
{
    public static function cutParagraph($paragraph, $limit=20)
    {
        if(strlen($paragraph) > $limit)
        {
            $rough_short_par = substr($paragraph, 0, $limit);
            $last_space_pos = strrpos($rough_short_par, " "); 
            
            $clean_short_par = substr($rough_short_par, 0, $last_space_pos);
            $clean_sentence = $clean_short_par . "...";
            
            return $clean_sentence;
        }
        else
        {
            return $paragraph;
        }
    }

    public static function cleanUrl($string)
    {
        $url = str_replace("'", '', $string);
        $url = str_replace('%20', ' ', $url);
        $hr = array('Č','Ć','Ž','Đ','Š','č','ć','ž','đ','š');
        $en = array('C','C','Z','D','S','c','c','z','d','s');
        $url = str_replace($hr, $en, $url);
        $url = preg_replace('~[^\\pL0-9\._\+]+~u', '-', $url); // substitutes anything but letters, numbers and '_' '+' with separator
        $url = trim($url, "-");
        @$url = iconv("utf-8", "us-ascii//TRANSLIT", $url);  // you may opt for your own custom character map for encoding.
        $url = strtolower($url);
        $url = preg_replace('~[^-a-z0-9\._]+~', '', $url); // keep only letters, numbers, '_' and separator
        return $url;
    }

    public static function getDomain($url)
    {
        preg_match('/http:\/\/(((www).)|())([A-Za-z0-9\.-]+\.\w+)(.*)/', $url, $m);
        
        return $m[5];
    }
}