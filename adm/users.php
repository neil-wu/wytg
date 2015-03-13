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

$userCtype=Options::getUserStatus();

if($action==''){
	$cons='';
	$keyword=_G('keyword');
	$state=_G('state','int');
    $state=isset($_GET['state']) ? $state : -1;

	if($keyword!=''){
		$cons.=$cons ? ' AND ' : '';
		$cons.="id='$keyword' OR username like '%".$keyword."%' ";
	}
	
	if($state>=0){
		$cons.=$cons ? ' AND ' : '';
		$cons.="is_state=$state";
	}

	$page=_G('p','int');
	if($page==false) $page=1;
	$pagesize=20;
	$offset=($page-1)*$pagesize;
    
	$lists=array();
	$totalsize=WoodyApp::model('users')->count('users',$cons);
	if($totalsize>0){
	    $lists=WoodyApp::model('users')->get_users($pagesize,$offset,$cons);
	}
	$totalpage=ceil($totalsize / $pagesize);
	$totalpage=$totalpage ? $totalpage : 1;
	
	$PageList=getpagelist('?keyword='.$keyword.'&state='.$state.'&p=' , $page , $totalpage , $totalsize);

	require View::getView('header');
	require View::getView('users');
	require View::getView('footer');
	View::Output();
}

if($action=='del'){
    $id=_G('id','int');
    $id=$id===false ? 0 : $id;
    WoodyApp::model('users')->delete('users','userid='.$id);
	WoodyApp::model('users')->delete('userlogs','userid='.$id);
	WoodyApp::model('users')->delete('orders','userid='.$id);
	WoodyApp::model('users')->delete('cards','userid='.$id);
	WoodyApp::model('users')->delete('goods','userid='.$id);
	WoodyApp::model('users')->delete('msgtpl','userid='.$id);
    echo 'ok';
}

if($action=='delall'){
    $ids=isset($_POST['listsid']) ? $_POST['listsid'] : array();
    if(count($ids)==0)Redirect('?del_err=true');
    WoodyApp::model('users')->delete('users','userid in('.implode(',',$ids).')');
	WoodyApp::model('users')->delete('userlogs','userid in('.implode(',',$ids).')');
	WoodyApp::model('users')->delete('orders','userid in('.implode(',',$ids).')');
	WoodyApp::model('users')->delete('cards','userid in('.implode(',',$ids).')');
	WoodyApp::model('users')->delete('goods','userid in('.implode(',',$ids).')');
	WoodyApp::model('users')->delete('msgtpl','userid in('.implode(',',$ids).')');
    Redirect('?del_suc=true');
}

if($action=='edit'){
    $id=_G('id','int');
    $id=$id===false ? 0 : $id;
    $data=WoodyApp::model('users')->get_users_by_userid($id);
    extract($data);
	$fromUrl=_S('HTTP_REFERER');
    require View::getView('header');
	require View::getView('usersEdit');
	require View::getView('footer');
    View::Output();
}

if($action=='editsave'){
    $id=_G('id','int');
    $id=$id===false ? 0 : $id;
    $data=$_POST['user'];
    $fromUrl=_P('fromUrl');

    WoodyApp::model('users')->update('users',$data,'id='.$id);

	$fromUrl=strpos($fromUrl,'?') ? $fromUrl.'&edit_suc=true' : '?edit_suc=true';
    
    Redirect($fromUrl);
}

if($action=='loginusercenter'){
    $userid=_G('id','int');
	$data=WoodyApp::model('users')->get_users_by_userid($userid);
	if($data){
		$_SESSION['login_username']=$data['username'];
		$_SESSION['login_userid']=$userid;
		$_SESSION['login_session_verify']=sha1($data['username'].$userid.WY_CACHE_TOKEN);
		$_SESSION['login_usercode']=$data['usercode'];
        $_SESSION['top_session']=$data['token'];
        $_SESSION['login_usertype']=$data['is_state'];
		$_SESSION['login_logtime']='';
		$_SESSION['login_logip']='';
	}
	Redirect('/user');
}

if($action=='deldata'){
    $t='users';
	require View::getView('clearup');
	View::Output();
	exit;
}

if($action=='exedeldata'){
	$day=_P('day');
	$day=$day==false || $day<15 ? 15 : $day;
	require View::getView('header');	
	
	if($day){
		$users=WoodyApp::model('users')->get_users();
		if($users){
		    foreach($users as $key=>$val){
			    $data=WoodyApp::model('users')->get_log_by_userid($val['userid']);
				$formatdate1=strtotime(date('Y-m-d H:i:s'));
				$formatdate2=$data ? $data['logtime'] : $formatdate1;
				$d=ceil(($formatdate1-$formatdate2)/60/60/24);
				if($d>=$day){
				    WoodyApp::model('users')->delete('users','userid='.$val['userid']);
				}
			}
		}

		$msg='<span class="green">已成功清除当前商户记录！</span>';
		$img='success';
		$url=_S('HTTP_REFERER');		
		require View::getView('msg');
	} else {
		$msg='<span class="red">商户记录清除失败！</span>';
		$img='error';
		$url=_S('HTTP_REFERER');
	    require View::getView('msg');
	}
	require View::getView('footer');
	View::Output();
}
?>