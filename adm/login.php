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
$action=_G('action');

if($action=='login'){
	$usr=_P('usr');
	$pwd=_P('pwd');
	$safepwd=_P('safepwd');
	$chk=_P('chk');
	if($chk=='' || strtolower($chk)<>$_SESSION['chkcode']) Redirect('?err=E001');
	if($usr=='') Redirect('?err=E002');
	if(strlen($usr)<5 || strlen($usr)>20) Redirect('?err=E003');
	if($pwd=='') Redirect('?err=E004');
	if(strlen($pwd)<6 || strlen($pwd)>20) Redirect('?err=E005');

	$ob=new admin_class();
	if(!$data=$ob->get_admin_by_adminname($usr)){
	    Redirect('?err=E006');
	}
	
	if($data['is_state']){
	    Redirect('?err=E007');
	}

	if(sha1(sha1($pwd))!=$data['userpass']){
	    Redirect('?err=E008');
	}

	if($data['is_verifyip']==1){
		if(strpos($data['verifyip'],_S('REMOTE_ADDR'))===false){
			Redirect('?err=E009');
		}
	} else if($data['is_verifyip']==2){
		$ip_arr=explode('.',_S('REMOTE_ADDR'));
		$prefix_ip=$ip_arr[0].'.'.$ip_arr[1];
		if(strpos($data['verifyip'],$prefix_ip)===false){
			Redirect('?err=E010');
		}
	}

	if($data['is_safe']){
	   if($safepwd==''){
		   Redirect('?err=E011');
	   } else {
		   if($data['userkey']!=sha1(sha1($safepwd))){
			   Redirect('?err=E012');
		   }
	   }
	}

	$_SESSION['login_adminname']=$usr;
	$_SESSION['login_adminid']=$data['id'];
	$_SESSION['login_adminutype']=$data['utype'];
	$_SESSION['login_adminlimit']=explode('|',$data['adminlimit']);
	$_SESSION['login_verifytoken']=sha1($usr.$data['id'].WY_CACHE_TOKEN);

	$logs=$ob->get_log_by_adminid($data['id']);
	if($logs){
	    $_SESSION['login_adminlogip']=$logs['logip'];
	    $_SESSION['login_adminlogtime']=date('Y-m-d H:i:s',$logs['logtime']);
	} else {
	    $_SESSION['login_adminlogip']='';
	    $_SESSION['login_adminlogtime']=''; 
	}
	$logdata=array('userid'=>$data['id'],'logtime'=>time(),'logip'=>_S('REMOTE_ADDR'));
	$ob->insert('adminlogs',$logdata);
	Redirect('./');  
}
	
if($action=='logout'){
    if(isset($_SESSION['login_adminname'])){
		foreach($_SESSION as $key=>$val){
			if(strpos($key,'admin') && isset($_SESSION[$key])){
				$_SESSION[$key]='';
				unset($_SESSION[$key]);
			}
		}
		session_destroy();
		Redirect('login.php');
	}
}
	
require View::getView('login');
View::Output();