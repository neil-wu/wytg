<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

class View{
	static function getView($page,$ext='.php'){
		if(!file_exists(VIEW_PATH.$page.$ext)){
			return VIEW_PATH.'wy_messager.php';
		} else {
			return VIEW_PATH.$page.$ext;
		}
	}
		
	static function Output(){
		$content=ob_get_contents();		
        ob_get_clean();
        echo $content;
		if(ob_get_level()){ob_end_flush();}
	}
}