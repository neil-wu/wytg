<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

if(!defined('WY_ROOT')) exit;
class chkcode{
    function display(){
		$randCode = '';
		$chars = 'abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPRSTUVWXYZ23456789';
		for ( $i = 0; $i < 5; $i++ ){
			$randCode .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		}

		$_SESSION['chkcode'] = strtolower($randCode);

		$img = imagecreate(70,22);
		$bgColor = isset($_GET['mode']) && $_GET['mode'] == 't' ? imagecolorallocate($img,245,245,245) : imagecolorallocate($img,255,255,255);
		$pixColor = imagecolorallocate($img,mt_rand(30, 180), mt_rand(10, 100), mt_rand(40, 250));

		for($i = 0; $i < 5; $i++){
			$x = $i * 13 + mt_rand(0, 4) - 2;
			$y = mt_rand(0, 3);
			$text_color = imagecolorallocate($img, mt_rand(30, 180), mt_rand(10, 100), mt_rand(40, 250));
			imagechar($img, 5, $x + 5, $y + 3, $randCode[$i], $text_color);
		}
		for($j = 0; $j < 60; $j++){
			$x = mt_rand(0,70);
			$y = mt_rand(0,22);
			imagesetpixel($img,$x,$y,$pixColor);
		}

		header('Content-Type: image/jpeg');
		imagejpeg($img);
		imagedestroy($img);
	}
}
?>