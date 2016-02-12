<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

// ------------------------------------------------------------------------

if ( ! function_exists('querydb'))
{
	/**
	 * Element
	 *
	 * Lets you determine whether an array index is set and whether it has a value.
	 * If the element is empty it returns NULL (or whatever you specify as the default value.)
	 *
	 * @param	string
	 * @param	array
	 * @param	mixed
	 * @return	mixed	depends on what the array contains
	 */
	 
}

class MyFile
{

    function getFileExtension($file,$reply=1,$dot=1,$str="."){
        #GET FILE EXT
        $ext = explode($str,basename($file));
        if ($dot==1)$ext = strtolower($str.$ext[count($ext)-1]);
        else $ext = strtolower($ext[count($ext)-1]);
        if ($reply==1) return($ext);
    }
    
    function removeFileExtension($file,$reply=1){
        #GET FILE EXT
        $ext = $this -> getFileExtension($file);
        $ext = str_replace($ext,'',$file);
        if ($reply==1) return($ext);
    }
    
    function getFileType($ext){
        switch ($ext) {
            case ".mkv" : $ext2 = "Matroska Video File"; break;
            case ".mp4" : $ext2 = "MP4 Video File"; break;
            case ".rm" : $ext2 = "Real Media Video File"; break;
            case ".rmvb" : $ext2 = "Real Media Video File"; break;
            case ".avi" : $ext2 = "Avi Video File"; break;
            case ".rar" : $ext2 = "WinRar File"; break;
            case ".jpg" : $ext2 = "JPEG Image File"; break;
            case ".jpeg" : $ext2 = "JPEG Image File"; break;
            case ".gif" : $ext2 = "GIF Image File"; break;
            default  : $ext2 = "Unknown File";
        }
        return $ext2;
    }
    
    function getFileIcon($file){
        #GET FILE EXT
        $ext2 = $this -> getFileGroup($file);

        $icon_file = "<img src=\"{tpl_dir}image/icon/".$ext2."_file.gif\">";
        
        return $icon_file;
    }
        
    function getFileGroup($file){
        #GET FILE EXT
        // related to : new_global.php <- css generate from php, see tehmplate directory
        $ext = $this -> getFileExtension($file);
        $ereg_ext = explode(",",GLOBAL_VIDEO_FILE_EXT);
        $video_file_ext = implode("|",$ereg_ext);

        if (preg_match("/{$ext}/si",".mp3|.wav|.ogg|.wma")) {
            $ext2 = "music";}
        else if (preg_match("/{$ext}/si",$video_file_ext)) {
            $ext2 = "video";}
        else if (preg_match("/{$ext}/si",".m3u|.m3u8|.xspf")) {
            $ext2 = "playlist";}
        else if (preg_match("/{$ext}/si",".rar|.zip|.7z")) {
            $ext2 = "archieve";}
        else if (preg_match("/{$ext}/si",".001|.002|.003|.004|.005|.006")) {
            $ext2 = "part";}
        else if (preg_match("/{$ext}/si",".png|.jpg|.jpeg|.gif")) {
            $ext2 = "image";}
        else if (preg_match("/{$ext}/si",".txt|.doc|.inf|.ini")) {
            $ext2 = "text";}
        else if (preg_match("/{$ext}/si",".htm|.html|.shtml|.xml")) {
            $ext2 = "html";}
        else if (preg_match("/{$ext}/si",".srt|.ass")) {
            $ext2 = "subtitle";}
        else {
            $ext2 = "unknown";}
        
        return $ext2;
    }

    function getFileSize($file="",$fsize=0,$precision=2){
        # GET FIxED FILE SIZE
        if (!empty($file)){
            $fsize = filesize($file);
        }
            $unit = array('TB'=>1024*1024*1024*1024,'GB'=>1024*1024*1024,'MB'=>1024*1024,'KB'=>1024,'Bytes'=>1);
            
            # TB
            if ($fsize > $unit['TB']) $ret_unit = "TB";
            # GB
            else if ($fsize <= $unit['TB'] && $fsize > $unit['GB']) $ret_unit = "GB";
            # MB
            else if ($fsize <= $unit['GB'] && $fsize > $unit['MB']) $ret_unit = "MB";
            # KB
            else if ($fsize <= $unit['MB'] && $fsize > $unit['KB'])$ret_unit = "KB";
            # B
            else if ($fsize <= $unit['KB'] && $fsize >= 0) $ret_unit = "Bytes";
            
            $frac_size = $fsize/$unit[$ret_unit];
            
            $ret_array = array(
                0             => $frac_size,
                'frac_size' => $frac_size,
                1             => $ret_unit,
                'unit'         => $ret_unit,
                2             => $fsize,
                'size'         => $fsize,
                3             => round($frac_size,$precision)." {$ret_unit}",
                'formatted' => round($frac_size,$precision)." {$ret_unit}"
            );
            
            return $ret_array;
    }
    
    function getScaleOfImage($W,$H,$n_W=200,$n_H=300,$mode="fit",$ignore_larger=true){
        if ($mode == "fit"){
            if ($H < $n_H && $W < $n_W){//skala lebih kecil
                $new_H = $H;
                $new_W = $W; 
                $scale = abs($W / $new_W);
            }
            else if ($H/$n_H > $W/$n_W){//gambar skala tinggi lebih kecil
                $new_H = $n_H;
                $new_W = $n_H / $H * $W; 
                $scale = abs($W / $new_W);
            }
            else if ($H/$n_H < $W/$n_W){ // gambar skala lebar besar
                $new_W = $n_W;
                $new_H = $n_W / $W * $H; 
                $scale = abs ($H / $new_H);
            }
            else{ // gambar skala sama
                $new_W = $n_W;
                $new_H = $n_W / $W * $H; 
                $scale = abs ($H / $new_H);
            }
        }
        else if ($mode == "fit-w"){
                $new_W = $n_W;
                $new_H = $n_W / $W * $H; 
                $scale = abs ($H / $new_H);
        }
        else if ($mode == "fit-h"){
                $new_H = $n_H;
                $new_W = $n_H / $H * $W; 
                $scale = abs($W / $new_W);
        }
        else if ($mode == "fill"){
            if ($H < $n_H && $W < $n_W && $ignore_larger == true){//skala lebih kecil
                $new_H = $H;
                $new_W = $W; 
                $scale = abs($W / $new_W);
            }
            else if ($H/$n_H < $W/$n_W){//gambar skala tinggi lebih kecil
                $new_H = $n_H;
                $new_W = $n_H / $H * $W; 
                $scale = abs($W / $new_W);
            }
            else if ($H/$n_H > $W/$n_W){ // gambar skala lebar besar
                $new_W = $n_W;
                $new_H = $n_W / $W * $H; 
                $scale = abs ($H / $new_H);
            }
            else{ // gambar skala =
                $new_W = $n_W;
                $new_H = $n_W / $W * $H; 
                $scale = abs ($H / $new_H);
            }
        }
        return array($new_W,$new_H,$scale);
    }
    
    function makeImageThumbs($source,$destination="output.jpg",$frame_w,$frame_h,$resize_mode="fill",$align="center",$pos=array(),$quality=80){
                
        list($ori_w,$ori_h) = getimagesize($source);
        $thumbnails = $this -> getScaleOfImage($ori_w,$ori_h,$frame_w,$frame_h,$resize_mode);
            
        //print "<br>$frame_w/$frame_h";
        $file_tempor_W = round($thumbnails[0]);
        $file_tempor_H = round($thumbnails[1]);
        $scale = $thumbnails[2];
        
        //when using resize mode fit-w OR fit-h, frame is fixed to the tenpo hight/width
        if ($resize_mode == 'fit-h' || $resize_mode == 'fit-w'){
            $frame_w = $file_tempor_W ;
            $frame_h = $file_tempor_H ;
        }
        
        $add_pp_w = ($file_tempor_W-$frame_w)/2*$scale;
        $add_pp_h = ($file_tempor_H-$frame_h)/2*$scale;

        $imt = @imagecreatetruecolor($frame_w,$frame_h);
            
        $pp_ext = $this -> getFileExtension ($source,1,0,".");
        
        if ($pp_ext == "png"){ //transparent PNG
            imagealphablending($imt, true); 
            // Allocate a transparent color and fill the new image with it. 
            // Without this the image will have a black background instead of being transparent. 
            $transparent = imagecolorallocatealpha( $imt, 0, 0, 0, 127 ); 
            imagefill( $imt, 0, 0, $transparent ); 
        }

            switch ($pp_ext) {
                case "png" : $pp_import = imagecreatefrompng($source); break;
                case "jpeg" : $pp_import = imagecreatefromjpeg($source); break;
                case "gif" : $pp_import = imagecreatefromgif($source); break;
                default  : $pp_import = imagecreatefromjpeg($source);
            }
        //placing image : auto center
        if ($align == "center"){
            /*$dim = array(
                "top"    => ($prev_div_h-$frame_h)/2,
                "left"    => ($prev_div_w-$frame_w)/2,
                "width"    => $ori_w-($prev_div_w-$frame_w)*2,
                "height"=> $ori_h-($prev_div_h-$frame_h)*2,
            );
            //$dimension = implode(",",$dim);*/
            imagecopyresampled($imt,$pp_import,0,0,0+$add_pp_w,0+$add_pp_h,$frame_w ,$frame_h ,$ori_w-($add_pp_w*2),$ori_h-($add_pp_h*2));
        }
        else if ($align == "auto"){
            //$dimension = implode(",",$pos);
            imagecopyresampled($imt,$pp_import,0,0,$pos['left'],$pos['top'],$frame_w ,$frame_h ,$pos['width'],$pos['height']);
        }
        //export image to destination : 
        $destination = strtolower($destination);
		
        if ($pp_ext == "png"){
            // save the alpha 
            imagesavealpha($imt,true); 
            //compress = 1-9
            $o_quality = (100-$quality)/10;
            imagepng($imt, $destination, $o_quality);
        }
        else{
            //quality = 1-100
            $o_quality = $quality;
            imagejpeg($imt, $destination ,$o_quality);
        }
		imagedestroy($imt);

        //imagejpeg($imt, $destination ,$quality);
        //return $dimension;
    }

}

