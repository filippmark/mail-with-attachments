<?php
 

$width = 60;
$height = 30;
 
$noise_level = 15;
 
$code=rand(1000,9999);
 
setcookie("captcha_code", $code);
 
 
$im = imagecreatetruecolor($width, $height);
$bg = imagecolorallocate($im, 230, 80, 0); 
$fg = imagecolorallocate($im, 255, 255, 255);
$ns = imagecolorallocate($im, 200, 200, 200);
 

imagefill($im, 0, 0, $bg);
 

imagestring($im, 5, 10, 8,  $code, $fg); 
 

for ($i = 0; $i < $noise_level; $i++) {
	for ($j = 0; $j < $noise_level; $j++) {
		imagesetpixel(
			$im,
			rand(0, $width), 
			rand(0, $height),
			$ns
		);
	}
}
 
header("Cache-Control: no-cache, must-revalidate");
header('Content-type: image/png');
 

imagepng($im);
 
imagedestroy($im);
?>