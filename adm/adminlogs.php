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
    $username=_G('username');
	$cons='';
	$fdate=_G('fdate');
	$tdate=_G('tdate');
	if(!$fdate) $fdate=$tdate=date('Y-m-d');

	if($username){
		if($cons<>'') $cons.=' AND ';
		$cons .="userid=".WoodyApp::model('admin')->get_adminid_by_adminname($username)."";
	}

	if($fdate<>'' && isDate($fdate)){
		if($cons<>'') $cons.=' AND ';
		$cons .="logtime>='".strtotime($fdate)."'";
	}

	if($tdate<>'' && isDate($tdate)){
		if($cons<>'') $cons.=' AND ';
		$cons .="logtime<='".strtotime($tdate.' 23:59:59')."'";
	}


	$page=_G('p','int');
	$page=$page ? $page : 1;
	$pagesize=20;
	$offset=($page-1)*$pagesize;
	$totalsize=WoodyApp::model('admin')->count('adminlogs',$cons);
    
	$lists=array();
	if($totalsize>0){
	    $lists=WoodyApp::model('admin')->get_adminlogs($pagesize,$offset,$cons);
	}
	$totalpage=ceil($totalsize / $pagesize);
	$totalpage=$totalpage ? $totalpage :1;
	$pagelist=getpagelist('?username='.$username.'&fdate='.$fdate.'&tdate='.$tdate.'&p=' , $page , $totalpage , $totalsize);

	require View::getView('header');
	require View::getView('adminlogs');
	require View::getView('footer');
	View::Output();
}

if($action=='dellogs'){
	$id=_G('id','int');
	$id=$id===false ? 0 : $id;
	WoodyApp::model('admin')->delete('adminlogs','id='.$id);
	Redirect(_S('HTTP_REFERER'));
}
	
if($action=='delalllogs'){
	$ids=array();
	if(isset($_POST['listid'])) $ids=$_POST['listid'];
	if(count($ids)==0) redirect('?del_err=true');
	WoodyApp::model('admin')->delete('adminlogs','id in('.implode(',',$ids).')');
	Redirect(_S('HTTP_REFERER'));
}

if($action=='deldatalogs'){
    $username=_G('username');
	$fdate=_G('fdate');
	$tdate=_G('tdate');
    $t='adminlogs';
	require View::getView('clearup');
	View::Output();
	exit;
}

if($action=='exedeldatalogs'){
    $username=_P('username');
	$fdate=_P('fdate');
	$tdate=_P('tdate');
	require View::getView('header');
	
	if($fdate && isDate($fdate) && $tdate && isDate($tdate)){
		$cons="date(logtime)>='".$fdate."' AND date(logtime)<='".$tdate."'";
		$cons.=$username ? "AND userid=".WoodyApp::model('admin')->get_adminid_by_adminname($username)."" : "";

		WoodyApp::model('admin')->delete('adminlogs',$cons);

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