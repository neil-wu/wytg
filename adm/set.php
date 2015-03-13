<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

require_once 'common.php';
$action=_P('action');

if($action=='save'){
	$site_arr=array();
	$config=$_POST['config'];
	if($config){
	    foreach($config as $key=>$val){
		    $site_arr[$key]=$key=='tongji' ? $val : makeSafe($val);
		}
	}

	WoodyApp::model('config')->update('config',$site_arr,'id=1');			
	Redirect('set.php?op_suc=true');
}
	

$data=WoodyApp::model('config')->get_config();
if($data) extract($data);

require View::getView('header');
require View::getView('set');
require View::getView('footer');
View::Output();
?>