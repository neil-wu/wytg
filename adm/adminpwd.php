<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

require_once 'common.php';
$action=_G('action');

if($action==''){
	require View::getView('header');
	require View::getView('adminPwd');
	require View::getView('footer');
	View::Output();
}

if($action=='save'){
    $oldpass=_P('oldpass');
    $newpass=_P('newpass');
    $confirmnewpass=_P('confirmnewpass');

    if($oldpass=='' || $newpass==''){
		$msg='<span class="red">选项不能为空！</span>';
		$url='adminPwd.php';
		$img='error';
		require View::getView('header');
	    require View::getView('wy_messager');
		require View::getView('footer');
		View::Output();
		exit;
	}

    if($newpass!=$confirmnewpass){
		$msg='<span class="red">两次输入的密码不一样！</span>';
		$url='adminPwd.php';
		$img='error';
		require View::getView('header');
	    require View::getView('wy_messager');
		require View::getView('footer');
		View::Output();
		exit;
	}

	if(!$data=WoodyApp::model('admin')->get_admin_by_adminid($_SESSION['login_adminid'])){
		Redirect('出现意外错误！','login.php?action=logout');
	}

	if($data['userpass']!=sha1(sha1($oldpass))){
		$msg='<span class="red">旧的登录密码输入错误！</span>';
		$url='adminPwd.php';
		$img='error';
		require View::getView('header');
	    require View::getView('wy_messager');
		require View::getView('footer');
		View::Output();
		exit; 
	}

    $data=array(
        'userpass'=>sha1(sha1($newpass)),
    );
    WoodyApp::model('admin')->update('admin',$data,'id='.$_SESSION['login_adminid']);

	$msg='<span class="green">管理员登录密码修改成功！</span>';
	$url='adminPwd.php';
	$img='success';
	require View::getView('header');
	require View::getView('wy_messager');
	require View::getView('footer');
	View::Output();
	exit;
}