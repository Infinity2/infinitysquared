<?php
class Image
{
    public static function resize($input_file_name, $destination_file_name, $width, $height, $quality=false)
    {
        // MIJENJA VELIČINU SLIKE I SPREMA SLIKU
        //      $input_file_name           mora biti path do slike npr.                                   './slike/tmp_aaa.jpg'
        //      $destination_file_name     mora biti path sa imenom slike gdje ju želimo spremiti npr.    './slike/aaa.jpg'
        
        $thumbw = $width;
        $thumbh = $height;
        
        $imagedata = getimagesize("$input_file_name");
        $imagewidth = $imagedata[0];
        $imageheight = $imagedata[1];
        $imagetype = $imagedata[2];
        
        // type definitions
        // 1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP
        // 7 = TIFF(intel byte order), 8 = TIFF(motorola byte order)
        // 9 = JPC, 10 = JP2, 11 = JPX
        
        if($imagetype == 2)
        {
            $src_img = imagecreatefromjpeg("$input_file_name");
        }
        elseif($imagetype == 1)
        {
            $src_img = imagecreatefromgif("$input_file_name");
        }
        elseif($imagetype == 3)
        {
            $src_img = imagecreatefrompng("$input_file_name");
        }
        
        if($src_img)
        {
            if($imagewidth <= $width)
            {
                $thumbw = $imagewidth;
                $thumbh = $imageheight;
            }
            
            $shrinkage = $thumbw/$imagewidth;
            $dest_width = $thumbw;
            $dest_height = $shrinkage * $imageheight;
            
            if( $dest_height > $imageheight )
            {
                $shrinkage = $thumbh/$imageheight;
                $dest_height = $thumbh;
                $dest_width = $shrinkage * $imagewidth;
            }
            
            $dst_img = imagecreatetruecolor($dest_width,$dest_height);
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width,$dest_height, $imagewidth, $imageheight);
            imageinterlace($dst_img,1); 
            
            if($imagetype == 2)
            {
                if($quality)
                    imagejpeg($dst_img, $destination_file_name, $quality);
                else
                    imagejpeg($dst_img, $destination_file_name);
            }
            elseif($imagetype == 1)
            {
                imagegif($dst_img, $destination_file_name);
            }
            elseif($imagetype == 3)
            {
                imagepng($dst_img, $destination_file_name);
            }
            
            imagedestroy($src_img);
            imagedestroy($dst_img);
        }
    }
}