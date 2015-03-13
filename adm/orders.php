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
    $status=_G('status');

    if($kwd){
        $cons=$cons=='' ? '' : $cons.' AND ';
        $cons.="(userid in(select userid from ".DB_PREFIX."users where username like '%".$kwd."%') or tb_orderid like '%".$kwd."%' or buyer_nick like '%".$kwd."%' or buyer_email like '%".$kwd."%')";
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
    
    if($status){
        $cons.=$cons ? ' and ' : '';
        $cons.="tb_status='".$status."'";
    }

	$page=_G('p','int');
	if($page==false || $page==0) $page=1;
	$pagesize=20;
	$offset=($page-1)*$pagesize;
    $totalsize=WoodyApp::model('orders')->count('orders',$cons);
	$lists=array();
	if($totalsize>0){
	    $lists=WoodyApp::model('orders')->get_orders($pagesize,$offset,$cons);    
	}

	$totalpage=ceil($totalsize / $pagesize);
	$totalpage=$totalpage ? $totalpage : 1;
	$pagelist=getpagelist('?kwd='.$kwd.'&status='.$status.'&fdate='.$fdate.'&tdate='.$tdate.'&state='.$state.'&p=' , $page , $totalpage , $totalsize);
    
	require View::getView("header");
	require View::getView("orders");
	require View::getView("footer");
	View::Output();
}
	
if($action=='del'){
	$id=_G('id','int');
	$id=$id==false ? 1 : $id;
	WoodyApp::model('orders')->delete('orders','id='.$id);
	echo 'ok';
	exit;
}
	
if($action=='delall'){
	$ids=array();
	if(isset($_POST['listid'])) $ids=$_POST['listid'];
	if(count($ids)==0) Redirect("?del_err=true");
	WoodyApp::model('orders')->delete('orders','id in('.implode(',',$ids).')');
	Redirect(_S('HTTP_REFERER'));
}

if($action=='deldata'){
	$fdate=_G('fdate');
	$tdate=_G('tdate');
	$status=_G('status');
	$state=_G('state','int');
	$kwd=_G('kwd');
    $t='orders';

	require View::getView('clearup');
	View::Output();
	exit;
}

if($action=='exedeldata'){
	$fdate=_P('fdate');
	$tdate=_P('tdate');
	$status=_P('status');
	$state=_P('state','int');
	$kwd=_P('kwd');
	$cons='';

	require View::getView('header');
	
    if($kwd){
        $cons=$cons=='' ? '' : $cons.' AND ';
    	$userid=WoodyApp::model('orders')->model('users')->get_userid_by_username($kwd);
        $cons.="(userid='".$userid."' or tb_orderid like '%".$kwd."%' or buyer_nick like '%".$kwd."%' or buyer_email like '%".$kwd."%')";
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
    
    if($status){
        $cons.=$cons ? ' and ' : '';
        $cons.="tb_status='".$status."'";
    }
	
    if($cons){
		WoodyApp::model('orders')->delete('orders',$cons);

		$msg='<span class="green">已成功清除当前订单记录！</span>';
		$img='success';
		$url=_S('HTTP_REFERER');		
		require View::getView('wy_messager');
	} else {
		$msg='<span class="red">订单记录清除失败！</span>';
		$img='error';
		$url=_S('HTTP_REFERER');
	    require View::getView('wy_messager');
	}
	require View::getView('footer');
	View::Output();
}

if($action=='getgoodinfo'){
    $orderid=_G('orderid');
    $cons="tb_orderid='".$orderid."'";
	$data=WoodyApp::model('cards')->get_cards(false,false,$cons);

	$cards='';
	if($data){
	    foreach($data as $key=>$row){
			$cards.='卡号：'.Options::decrypt($row['cardnum']).''."<br />";
			$cards.=$row['cardpwd']=='' ? '' : '卡密：'.Options::decrypt($row['cardpwd']).''."<br />";
		}
	} else {
	    $cards='卡密还没有提取。';
	}

	require View::getView('getgoodinfo');
	View::Output();
}
?>