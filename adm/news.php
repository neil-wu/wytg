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
    $classid=_G('classid','int');
	$lists=array();
	$page=_G('p','int');
	$page=$page==false ? 1 : $page;
	$pagesize=20;
	$offset=($page-1)*$pagesize;
	$cons=$classid ? "classid=$classid" : "";
	$totalsize=WoodyApp::model('news')->count('news',$cons);
	if($totalsize>0){
	    $lists=WoodyApp::model('news')->get_news($pagesize,$offset,$cons);
	}
	$totalpage=ceil($totalsize / $pagesize);
	$totalpage=$totalpage ? $totalpage : 1;
	$pagelist=getpagelist('?classid='.$classid.'&p=' , $page , $totalpage , $totalsize);

	$newsClass=WoodyApp::model('news')->get_newsclass();
	require View::getView("header");
	require View::getView("news");
	require View::getView("footer");
	View::Output();
}


if($action=='add'){
	$newsClass=WoodyApp::model('news')->get_newsclass();
	require View::getView("header");
    require View::getView('newsAdd');
	require View::getView("footer");
	View::Output();
}
	
if($action=='addsave'){
	$classid=_P('classid','int');
	$title=_P('title');
	$is_bold=_P('is_bold');
	$is_color=_P('is_color');
	$is_popup=_P('is_popup','int');
	$is_display_home=_P('is_display_home','int');
	$is_popup=$is_popup==false ? 0 : 1;
	$is_display_home=$is_display_home==false ? 0 :1;
	$addtime=strtotime(_P('addtime'));
	$content=$_POST['contenttext'];
	if($title=='' || $classid=='' || $content=='') Redirect('?add_err=true');
	$data=array('classid'=>$classid , 'title'=>$title , 'content'=>$content , 'addtime'=>$addtime , 'is_color'=>$is_color , 'is_bold'=>$is_bold,'is_popup'=>$is_popup,'is_display_home'=>$is_display_home);
	WoodyApp::model('news')->insert('news',$data);
	Redirect('?add_suc=true');
}
	

if($action=='edit'){
	$id=_G('id','int');
	$id=$id===false ? 0 : $id;
	$newsClass=WoodyApp::model('news')->get_newsclass();
	$news=WoodyApp::model('news')->get_news_by_id($id);
	extract($news);
	require View::getView("header");
	require View::getView("newsEdit");
	require View::getView("footer");
	View::Output();
}
	
if($action=='editsave'){
	$id=_G('id','int');
	$id=$id===false ? 0 : $id;
	$classid=_P('classid','int');
	$title=_P('title');
	$is_bold=_P('is_bold');
	$is_color=_P('is_color');
	$is_popup=_P('is_popup','int');
	$is_display_home=_P('is_display_home','int');
	$addtime=strtotime(_P('addtime'));
	$is_popup=$is_popup==false ? 0 : 1;
	$is_display_home=$is_display_home==false ? 0 :1;
	$content=$_POST['contenttext'];
	if($title=='' || $classid=='' || $content=='') Redirect('?edit_err=true');
	$data=array('classid'=>$classid , 'title'=>$title , 'content'=>$content , 'is_color'=>$is_color , 'is_bold'=>$is_bold,'is_popup'=>$is_popup,'is_display_home'=>$is_display_home,'addtime'=>$addtime);
	WoodyApp::model('news')->update('news',$data,'id='.$id);

	Redirect('?edit_suc=true');
}
	
if($action=='del'){
	$id=_G('id','int');
	$id=$id===false ? 0 : $id;
	WoodyApp::model('news')->delete('news','id='.$id);
	echo 'ok';
}
	
if($action=='delall'){
	$ids=array();
	if(isset($_POST['listid'])) $ids=$_POST['listid'];
	if(count($ids)==0) Redirect('?del_err=true');
	WoodyApp::model('news')->delete('news','id in ('.implode(',',$ids).')');
	Redirect('?del_suc=true');
}