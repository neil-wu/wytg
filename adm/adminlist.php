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
$admSubMenu=Options::getAdmSubMenu();

if($action==''){
	$lists=array();
	$cons='';
	$keyword=_G('keyword');
	if($keyword){	    
		$cons="WHERE username like '%".$keyword."%'";
	}
	$page=_G('p','int');
	if($page==false) $page=1;
	$pagesize=20;
	$offset=($page-1)*$pagesize;
	$totalsize=WoodyApp::model('admin')->count('admin',$cons);
	if($totalsize>0){		
		$lists=WoodyApp::model('admin')->get_admin($pagesize,$offset,$cons);
	}

	$totalpage=ceil($totalsize / $pagesize);
	$PageList=getpagelist('?keyword='.$keyword.'&p=' , $page , $totalpage , $totalsize);
	require View::getView('header');
	require View::getView('adminList');
	require View::getView('footer');
	View::Output();
}

if($action=='add'){
	require View::getView('header');
    require View::getView('adminadd');
	require View::getView('footer');
	View::Output();
}

if($action=='addsave'){
    $username=_P('username');
    $userpass=_P('userpass');
    $is_state=_P('is_state','int');
    $is_safe=_P('is_safe','int');
	$is_verifyip=_P('is_verifyip','int');
    $userkey=_P('userkey');
    $adminlimit=isset($_POST['adminlimit']) ? $_POST['adminlimit'] : array();
    $utype=_P('utype','int');
	$verifyip=_P('verifyip');	

    if($username=='' || $userpass==''){
		$msg='<span class="red">登录用户名和密码不能为空！</span>';
		$url='adminlist.php';
		$img='error';
		require View::getView('header');
	    require View::getView('wy_messager');
		require View::getView('footer');
		View::Output();
		exit;
	}

	if(WoodyApp::model('admin')->get_admin_by_adminname($username)){
		$msg='<span class="red">登录用户名已存在！</span>';
		$url=_S('HTTP_REFERER');
		$img='error';
		require View::getView('header');
	    require View::getView('wy_messager');
		require View::getView('footer');
		View::Output();
		exit;
	}

	$adminlimit=$adminlimit ? implode('|',$adminlimit) : '';

    $data=array(
        'username'=>$username,
        'userpass'=>sha1(sha1($userpass)),
        'is_state'=>$is_state,
        'utype'=>$utype,
		'adminlimit'=>strtolower($adminlimit),
        'addtime'=>time(),
		'is_safe'=>$is_safe,
		'userkey'=>sha1(sha1($userkey)),
		'verifyip'=>$verifyip,
		'is_verifyip'=>$is_verifyip,
    );

    WoodyApp::model('admin')->insert('admin',$data);

	$msg='<span class="green">管理员账号添加成功！</span>';
	$url='adminlist.php';
	$img='success';
	require View::getView('header');
	require View::getView('wy_messager');
	require View::getView('footer');
	View::Output();
}

if($action=='del'){
    $id=_G('id','int');
    $id=$id===false ? 0 : $id;
    WoodyApp::model('admin')->delete('admin','id='.$id);
	WoodyApp::model('admin')->delete('adminlogs','userid='.$id);
    echo 'ok';
}

if($action=='delall'){
    $ids=isset($_POST['listsid']) ? $_POST['listsid'] : array();
    if(count($ids)==0) Redirect('?del_err=true');
    WoodyApp::model('admin')->delete('admin','id in ('.implode(',',$ids).')');
	WoodyApp::model('admin')->delete('adminlogs','userid in ('.implode(',',$ids).')');
    Redirect('?del_suc=true');
}

if($action=='edit'){
    $id=_G('id','int');
    $id=$id===false ? 0 : $id;
    $data=WoodyApp::model('admin')->get_admin_by_adminid($id);
    require View::getView('header');
	require View::getView('adminedit');
	require View::getView('footer');
    View::Output();
}

if($action=='editsave'){
    $id=_G('id','int');
    $id=$id===false ? 0 : $id;
    $userpass=_P('userpass');
    $is_state=_P('is_state','int');
    $is_safe=_P('is_safe','int');
	$is_verifyip=_P('is_verifyip','int');
    $userkey=_P('userkey');
    $adminlimit=isset($_POST['adminlimit']) ? $_POST['adminlimit'] : array();
    $utype=_P('utype','int');
	$verifyip=_P('verifyip');

	$adminlimit=$adminlimit ? implode('|',$adminlimit) : '';

    $data=array(
        'is_state'=>$is_state,
        'utype'=>$utype,
		'adminlimit'=>$adminlimit,
		'is_safe'=>$is_safe,
		'verifyip'=>$verifyip,
		'is_verifyip'=>$is_verifyip,
    );
    if($userpass!='') $data+=array('userpass'=>sha1(sha1($userpass)));
	if($userkey!='') $data+=array('userkey'=>sha1(sha1($userkey)));
    WoodyApp::model('admin')->update('admin',$data,'id='.$id);

	$msg='<span class="green">管理员账号编辑成功！</span>';
	$url='adminlist.php';
	$img='success';
	require View::getView('header');
	require View::getView('wy_messager');
	require View::getView('footer');
	View::Output();
	exit;
}