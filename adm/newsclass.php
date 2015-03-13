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
	$lists=WoodyApp::model('news')->get_newsclass();
	require View::getView("header");
	require View::getView("newsClass");
	require View::getView("footer");
	View::Output();
}
	
if($action=='add'){
	require View::getView("newsClassAdd");
	View::Output();
}
	
if($action=='addsave'){
	$cname=_P('cname');
	if($cname=='') Redirect('?add_err=true');
	WoodyApp::model('news')->insert('newsclass',array('classname'=>$cname));
	Redirect('?add_suc=true');
}

if($action=='edit'){
	$id=_G('id','int');
	$id=$id===false ? 0 : $id;
	$class=WoodyApp::model('news')->get_newsclass_by_id($id);
	extract($class);
	require View::getView("newsClassEdit");
	View::Output();
}
	
if($action=='editsave'){
	$id=_G('id','int');
	$id=$id===false ? 0 : $id;
	$cname=_P('cname');
	if($cname=='') Redirect('?edit_err=true');
	WoodyApp::model('news')->update('newsclass',array('classname'=>$cname),'id='.$id);
	Redirect('?edit_suc=true');
}
	
if($action=='del'){
	$id=_G('id','int');
	$id=$id==false ? 0 : $id;
	WoodyApp::model('news')->delete('newsclass','id='.$id);
	Redirect('?del_suc=true');
}
	
if($action=='delall'){
	$ids=array();
	if(isset($_POST['listid'])) $ids=$_POST['listid'];
	if(count($ids)==0) Redirect('?del_err=true');
    WoodyApp::model('news')->delete('newsclass','id in('.implode(',',$ids).')');
	Redirect('?del_suc=true');
}