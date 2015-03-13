<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

if(!defined('WY_ROOT')) exit;
class checkUser extends Wy_Controller{
	function __construct(){
		parent::__construct();
        if(!isset($_SESSION['login_userid']) || !isset($_SESSION['login_username'])){
            Redirect('/');
        }
        
		if(!isset($_SESSION['login_session_verify']) || $_SESSION['login_session_verify']!=sha1($_SESSION['login_username'].$_SESSION['login_userid'].WY_CACHE_TOKEN)){
			Redirect('/user/logout','您的账号存在异常，请重新登录。');
		}

		$theme=WY_ROOT.'/view/usr/default/';
		$this->tpl=$theme;
        
        //check user status
        $permiss=array('add','addsave','edit','editsave','del','saveset','delset','delall');
        if($_SESSION['login_usertype']==2){
            if(in_array($this->router[2],$permiss)){
                $this->assign('msg','当前账号已过期，数据为只都读状态！');
                $this->assign('url',_S('HTTP_REFERER'));
                $this->assign('img','error');
                $this->getView('wy_messager.php')->Output();exit;
            } 
        }
	}
}
?>