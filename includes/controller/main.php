<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

if(!defined('WY_ROOT')) exit;
class main extends Wy_Controller{

	function __construct(){
		parent::__construct();
	}
	
	function display(){

		$this->getView('index.php')->outPut();
	}
}
?>