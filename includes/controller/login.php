<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

if(!defined('WY_ROOT')) exit;
class login extends Wy_Controller{

	function __construct(){
		parent::__construct();
	}
    
    function callback(){
        $token=_G('top_session');
        $_SESSION['top_session']=$token;
        $data=TB::API('taobao.user.seller.get',array(
            'fields'=>'user_id,nick,avatar',
        ));

        if($data){
            $userid=$data['user_id'];
            $nick=$data['nick'];
            $avatar=$data['avatar'];
            
            $shop=TB::API('taobao.shop.get',array(
                'fields'=>'title',
                'nick'=>$nick,
            ));
            
            $sub=TB::API('taobao.vas.subscribe.get',array(
                'nick'=>$nick,
            ));

            $userinfo=$this->model('users')->get_users_by_userid($userid);
            if($userinfo && $userinfo['is_state']==3){
                $this->assign('msg','当前账号不可用，<a class="line blue" href="'.TB::IM($this->config['qq']).'" target="_blank">请联系客服→</a>');
                $this->assign('t',1);
                $this->getView('wy_messager.php')->Output();exit;
            }
            
            if($userinfo && ($userinfo['is_state']==0 || $userinfo['is_state']==1)){
                $days=($userinfo['expiretime']-time());
                if($days<0){
                    $is_state=2;
                } else {
                    $is_state=$userinfo['is_state'];
                }
            }

            if(!$userinfo){
                if(!$sub){
                    $is_state=1;
                    $expire=time()+60*60*48;
                } else {
                    $is_state=0;
                    $expire=$sub['deadline'];
                }
                
                $data=array(
                   'userid'=>$userid,
                   'is_state'=>$is_state,
                   'username'=>$nick,
                   'shop'=>$shop['title'],
                   'avatar'=>$avatar,
                   'token'=>$token,
                   'addtime'=>time(),
                   'expiretime'=>$expire,
                   'usercode'=>getRandomString(5),
                );
                $this->model('users')->insert('users',$data);
                
                //default msgtpl
                $msgtpl=array(
                    'userid'=>$userid,
                    'title'=>'购买商品发货通知',
                    'name'=>'默认模板',
                    'tpl'=>"您在{shopname}购买的商品信息如下：\r\n{content}\r\n您也可以通过以下链接自助领取:\r\n{goodurl}",
                    'addtime'=>time(),
                );
                $this->model('users')->insert('msgtpl',$msgtpl);
                
            } else {
                if($sub){
                    $expire=$sub['deadline'];
                } else {
                    $expire=$userinfo['expiretime'];
                }
                $this->model('users')->update('users',array('is_state'=>$is_state,'expiretime'=>$expire),'userid='.$userid);
            }
                
    		$_SESSION['login_username']=$nick;
    		$_SESSION['login_userid']=$userid;
            $_SESSION['login_usertype']=$is_state;
            $_SESSION['login_session_verify']=sha1($nick.$userid.WY_CACHE_TOKEN);
            
            $userlog=array(
                'userid'=>$userid,
                'logip'=>_S('REMOTE_ADDR'),
                'logtime'=>time(),
            );
            
            $this->model('users')->insert('userlogs',$userlog);
        }
        
        Redirect('/user');
    }
}

?>