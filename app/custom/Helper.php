<?php
class Helper
{

    public static function getPhotos($directories)
    {
        $allphotos = array();
        $i = 0;
        foreach ($directories as $dir) {

            $files = glob('storage/'.$dir.'/*.{jpg,png,gif}', GLOB_BRACE);

            foreach($files as $file) {
                $allphotos[$i]['photo'] = $file;
                $fname = end(explode('/', $file));
                $allphotos[$i]['thumb'] = 'storage/'.$dir.'/thumb/'.$fname;

                $i++;
            }
        }

        return $allphotos;
    }

    public static function getYoutubeIdFromUrl($url)
    {
        $pattern = 
            '%^# Match any youtube URL
            (?:https?://)?  # Optional scheme. Either http or https
            (?:www\.)?      # Optional www subdomain
            (?:             # Group host alternatives
              youtu\.be/    # Either youtu.be,
            | youtube\.com  # or youtube.com
              (?:           # Group path alternatives
                /embed/     # Either /embed/
              | /v/         # or /v/
              | /watch\?v=  # or /watch\?v=
              )             # End path alternatives.
            )               # End host alternatives.
            ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
            $%x'
        ;

        $result = preg_match($pattern, $url, $matches);

        if ($result) {
            return $matches[1];
        }

        return false;
    }
}