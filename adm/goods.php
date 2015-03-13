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
    $cons='';
    $kwd=_G('kwd');
    $fdate=_G('fdate');
    $tdate=_G('tdate');
    $state=_G('state','int');
    $state=isset($_GET['state']) ? $state : -1;
    $fdate=$fdate==false ? '' : $fdate;
    $tdate=$tdate==false ? '' : $tdate;

    if($kwd){
        $cons=$cons=='' ? '' : $cons.' AND ';
        $cons.="(userid in(select userid from ".DB_PREFIX."users where username like '%".$kwd."%') or tb_title like '%".$kwd."%')";
    }

    if($fdate && isDate($fdate)){
    	if($cons<>'') $cons.=' AND ';
    	$cons .="addtime>=".strtotime($fdate)."";
    }

    if($tdate && isDate($tdate)){
    	if($cons<>'') $cons.=' AND ';
    	$cons .="addtime<=".strtotime($tdate.' 23:59:59')."";
    }

    if($state>=0){
    	if($cons<>'') $cons.=' AND ';
    	$cons .="is_state=$state"; 
    }

	$page=_G('p','int');
	if($page==false || $page==0) $page=1;
	$pagesize=20;
	$offset=($page-1)*$pagesize;
    $totalsize=WoodyApp::model('goods')->count('goods',$cons);
	$lists=array();
	if($totalsize>0){
	    $lists=WoodyApp::model('goods')->get_goods($pagesize,$offset,$cons);    
	}

	$totalpage=ceil($totalsize / $pagesize);
	$totalpage=$totalpage ? $totalpage : 1;
	$pagelist=getpagelist('?kwd='.$kwd.'&fdate='.$fdate.'&tdate='.$tdate.'&state='.$state.'&p=' , $page , $totalpage , $totalsize);
    
	require View::getView("header");
	require View::getView("goods");
	require View::getView("footer");
	View::Output();
}
	
if($action=='del'){
	$id=_G('id','int');
	$id=$id==false ? 1 : $id;
	WoodyApp::model('goods')->delete('goods','id='.$id);
	echo 'ok';
	exit;
}
	
if($action=='delall'){
	$ids=array();
	if(isset($_POST['listid'])) $ids=$_POST['listid'];
	if(count($ids)==0) Redirect("?del_err=true");
	WoodyApp::model('goods')->delete('goods','id in('.implode(',',$ids).')');
	Redirect(_S('HTTP_REFERER'));
}
?>