<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

require_once '../init.php';
define('VIEW_PATH',dirname(__FILE__).'/views/');
if(!isset($_SESSION['login_adminname'])) Redirect('login.php');

$_SESSION['login_adminname']=makeSafe($_SESSION['login_adminname']);
$_SESSION['login_adminid']=intval($_SESSION['login_adminid']);
if(!isset($_SESSION['login_verifytoken']) || $_SESSION['login_verifytoken']!=sha1($_SESSION['login_adminname'].$_SESSION['login_adminid'].WY_CACHE_TOKEN)){
    Redirect('login.php');
}

$verify_page=strtolower(substr(basename(_S('SCRIPT_NAME')),0,-4));
$basename=basename(_S('PHP_SELF'));

if(!in_array($verify_page,$_SESSION['login_adminlimit'])){
	$msg='<span class="red">您所在的用户组没有权限管理此页面！</span>';
	$img='error';
	$url=_S('HTTP_REFERER');
    require View::getView('header');
    require View::getView('wy_messager');
	require View::getView('footer');
	View::Output();
	exit;
}