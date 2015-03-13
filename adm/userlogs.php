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
$do=_G('do');
$username='';

$cons='';
	
$username=_G('username');
$ip=_G('ip');
$fdate=_G('fdate');
$tdate=_G('tdate');
if(!$fdate) $fdate=$tdate=date('Y-m-d');

if($username){
	if($cons<>'') $cons.=' AND ';
	$cons .="userid=".WoodyApp::model('users')->get_userid_by_username($username)."";
}

if($fdate<>'' && isDate($fdate)){
	if($cons<>'') $cons.=' AND ';
	$cons .="logtime>=".strtotime($fdate)."";
}

if($tdate<>'' && isDate($tdate)){
	if($cons<>'') $cons.=' AND ';
	$cons .="logtime<=".strtotime($tdate.' 23:59:59')."";
}

if($ip){
    $cons.=$cons ? ' AND ' : '';
	$cons.="logip LIKE '%".$ip."%'";
}

if($action==''){
	$page=_G('p','int');
	if($page==false || $page==0) $page=1;
	$pagesize=20;
	$offset=($page-1)*$pagesize;
	$totalsize=WoodyApp::model('users')->count('userlogs',$cons);
	$lists=array();
	if($totalsize>0){
	    $lists=WoodyApp::model('users')->get_userlogs($pagesize,$offset,$cons);
	}
	$totalpage=ceil($totalsize / $pagesize);
	$totalpage=$totalpage ? $totalpage : 1;
	$pagelist=getpagelist('?username='.$username.'&fdate='.$fdate.'&tdate='.$tdate.'&ip='.$ip.'&p=' , $page , $totalpage , $totalsize);
	require View::getView("header");
	require View::getView("userlogs");
	require View::getView("footer");
	View::Output();
}

if($action=='del'){
	$id=_G('id','int');
	$id=$id===false ? 0 : $id;
	WoodyApp::model('users')->delete('userlogs','id='.$id);
	Redirect(_S('HTTP_REFERER'));
}
	
if($action=='delall'){
	$ids=array();
	if(isset($_POST['listid'])) $ids=$_POST['listid'];
	if(count($ids)==0) Redirect('?del_err=true');
	WoodyApp::model('users')->delete('userlogs','id in('.implode(',',$ids).')');
	Redirect(_S('HTTP_REFERER'));
}

if($action=='deldata'){
    $username=_G('username');
	$fdate=_G('fdate');
	$tdate=_G('tdate');
    $t='userlogs';
	require View::getView('clearup');
	View::Output();
	exit;
}

if($action=='exedeldata'){
    $username=_P('username');
	$fdate=_P('fdate');
	$tdate=_P('tdate');
	require View::getView('header');
	
	if($fdate && isDate($fdate) && $tdate && isDate($tdate)){
		$cons="logtime>=".strtotime($fdate)." AND logtime<=".strtotime($tdate.' 23:59:59')."";
		$cons.=$username ? "AND userid=".WoodyApp::model('users')->get_userid_by_username($username)."" : "";
		WoodyApp::model('users')->delete('userlogs',$cons);

		$msg='<span class="green">已成功清除当前登录日志！</span>';
		$img='success';
		$url=_S('HTTP_REFERER');		
		require View::getView('wy_messager');
	} else {
		$msg='<span class="red">登录日志清除失败！</span>';
		$img='error';
		$url=_S('HTTP_REFERER');
	    require View::getView('wy_messager');
	}
	require View::getView('footer');
	View::Output();
}