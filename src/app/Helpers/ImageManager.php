<?php

namespace App\Helpers;


class ImageManager
{
  public static function returnImg($type, $name = null)
  {
    if ($name != null) {
      return (object) array(
        "success" => 1,
        "data" => array("" . $type => $name . "?time=" . time())
      );
    } else {
      return (object) array(
        "success" => 1,
        "data" => array("" . $type => '/public/image/notfind.jpg')
      );
    }
  }

  public static function deleteImage($file)
  {
    if (file_exists($file)) {
      @unlink($file);
      unset($file);
    }
  }

  public static function cropImageJpg($file, $output, $startX, $startY, $endX, $endY, $w, $h)
  {
    $dst_x = 0;   // X-coordinate of destination point
    $dst_y = 0;   // Y-coordinate of destination point
    $dst_w = $w; // Thumb width
    $dst_h = $h; // Thumb height 
    $src_x = $startX;
    $src_y = $startY; // Crop Srart Y position in original image
    $src_w = $endX; // Crop end X position in original image
    $src_h = $endY; // Crop end Y position in original image
    // Creating an image with true colors having thumb dimensions (to merge with the original image)
    $dst_image = @imagecreatetruecolor($dst_w, $dst_h);

    // Get original image
    $src_image = @imagecreatefromjpeg($file);
    // Cropping
    @imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
    // Saving
    @imagejpeg($dst_image, $output);
    unset($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
  }

  public static function createFile($output, $input)
  {
    $fp = fopen($input, 'w');
    fwrite($fp, $output);
    fclose($fp);
    unset($fp);
  }

  public static function convertPngToJpg($filePath, $output)
  {
    try {
      ## create jpg
      $image = @imagecreatefrompng($filePath);
      $bg = @imagecreatetruecolor(imagesx($image), imagesy($image));
      @imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
      @imagealphablending($bg, TRUE);
      @imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
      @imagedestroy($image);
      $quality = 100; // 0 = worst / smaller file, 100 = better / bigger file 
      @imagejpeg($bg, $output, $quality);
      @imagedestroy($bg);
    } catch (\Exception $e) {
      return $e->getMessage();
    }
    return true;
  }
}
