<?php

header("Content-type: image/png");

$img_width = 800;
$img_height = 600;

$img = imagecreatetruecolor($img_width, $img_height);

$black = imagecolorallocate($img, 0, 0, 0);
$white = imagecolorallocate($img, 255, 255, 255);
$red   = imagecolorallocate($img, 255, 0, 0);
$green = imagecolorallocate($img, 0, 255, 0);
$blue  = imagecolorallocate($img, 0, 0, 255);
$orange = imagecolorallocate($img, 255, 200, 0);

imagefill($img, 0, 0, $white);

imagerectangle($img, $img_width*2/10, $img_height*5/10, $img_width*4/10, $img_height*8/10, $red);
imagerectangle($img, $img_width*4/10, $img_height*5/10, $img_width*8/10, $img_height*8/10, $red);

imagepolygon($img, [$img_width*3/10, $img_height*2/10, $img_width*2/10, $img_height*5/10, $img_width*4/10, $img_height*5/10], 3, $red);
imageopenpolygon($img, [$img_width*3/10, $img_height*2/10, $img_width*7/10, $img_height*2/10, $img_width*8/10, $img_height*5/10], 3, $red);

imageellipse($img, 100, 100, 100, 100, $orange);
imagearc($img, $img_width*3/10, $img_height*8/10, 100, 200, 180, 360, $red);

imageline($img, 0, $img_height*8/10, $img_width, $img_height*8/10, $green);

imagepng($img);

