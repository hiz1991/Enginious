<?php
function createThumb( $pathToImage, $pathToThumbs, $thumbWidth ) 
{
      // echo "start";
      $path_parts = pathinfo($pathToImage);
      $fileName = $path_parts['basename'];
      
      $img = imagecreatefromjpeg($pathToImage);
      if (!$img) {
        copy($pathToImage, $pathToThumbs.$fileName);
        // $copy = file_get_contents($pathToImage);
        // file_put_contents($pathToThumbs.$fileName, $copy);
        // exit(0);
      }
      else
      {
        $width = imagesx( $img );
        $height = imagesy( $img );

        // calculate thumbnail size
        $new_width = $thumbWidth;
        $new_height = floor( $height * ( $thumbWidth / $width ) );

        // create a new temporary image
        $tmp_img = imagecreatetruecolor( 150, 150);

        // copy and resize old image into new image 
        imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, 150, 150, $width, $height );
        imagejpeg( $tmp_img, $pathToThumbs.$fileName, 100 );
        imagedestroy($tmp_img);
        // echo "finish";
      }
}
?>