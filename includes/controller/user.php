<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

if(!defined('WY_ROOT')) exit;
class user extends checkUser{

	function __construct(){
		parent::__construct();
	}
    function display(){
        $users=$this->model('users')->get_users_by_userid($_SESSION['login_userid']);
        $data['today_orders_total']=$this->model('orders')->count('orders',"userid=".$_SESSION['login_userid']." and datediff(CURDATE(),date(from_unixtime(addtime)))=0");
        $data['today_orders_success']=$this->model('orders')->count('orders',"userid=".$_SESSION['login_userid']." and datediff(CURDATE(),date(from_unixtime(addtime)))=0 and tb_status='TRADE_FINISHED'");
        $data['today_cards_total']=$this->model('cards')->count('cards',"userid=".$_SESSION['login_userid']." and datediff(CURDATE(),date(from_unixtime(selltime)))=0 and is_state=1");
        
        $data['yestoday_orders_total']=$this->model('orders')->count('orders',"userid=".$_SESSION['login_userid']." and datediff(CURDATE(),date(from_unixtime(addtime)))=1");
        $data['yestoday_orders_success']=$this->model('orders')->count('orders',"userid=".$_SESSION['login_userid']." and datediff(CURDATE(),date(from_unixtime(addtime)))=1 and tb_status='TRADE_FINISHED'");
        $data['yestoday_cards_total']=$this->model('cards')->count('cards',"userid=".$_SESSION['login_userid']." and datediff(CURDATE(),date(from_unixtime(selltime)))=1 and is_state=1");
        
        $news=$this->model('news')->get_news(false,false,'classid=1');
        
        $this->assign('users',$users);
        $this->assign('data',$data);
        $this->assign('news',$news);
        $this->getView('index.php')->Output();
    }
    
	function logout(){
		if(isset($_SESSION['login_username'])){
			foreach($_SESSION as $key=>$val){
				if(!strpos($key,'admin') && isset($_SESSION[$key])){
					$_SESSION[$key]='';
					unset($_SESSION[$key]);
				}
			}
			Redirect('/');
		}
	}
    
    function set(){
        $this->assign('title','发信内容模板');
        $data=$this->model('users')->get_msgtpl(false,false,'userid='.$_SESSION['login_userid']);
        $this->assign('data',$data);
        
        $id=isset($this->router[3]) ? makeSafe($this->router[3],'int') : 0;
        if($id && $tplinfo=$this->model('users')->get_msgtpl_by_id($id)){
            $this->assign('tplinfo',$tplinfo);
        } else {
            $this->assign('tplinfo',array());
        }
        
        $this->getView('msgtpl.php')->Output();
    }
    
    function saveset(){
        $name=_P('tpl_name');
        $tpl=_P('tpl_content');
        $is_state=_P('tpl_state','int');
        $title=_P('tpl_title');
        
        if(!$name || !$tpl){
            $this->assign('msg','参数内容不正确，请返回重新设置！');
            $this->assign('url',_S('HTTP_REFERER'));
            $this->assign('img','error');
            $this->getView('wy_messager.php')->Output();exit;
        }
        
        $id=_P('id','int');
        if($id){
            
            $data=array(
                'name'=>$name,
                'title'=>$title,
                'tpl'=>$tpl,
                'is_state'=>$is_state,
            );
        
            $this->model('users')->update('msgtpl',$data,'id='.$id);
            
        } else {
        
            $data=array(
                'userid'=>$_SESSION['login_userid'],
                'name'=>$name,
                'title'=>$title,
                'tpl'=>$tpl,
                'is_state'=>$is_state,
                'addtime'=>time(),
            );
        
            $this->model('users')->insert('msgtpl',$data);
        }
        
        $this->assign('msg','模板保存成功！');
        $this->assign('url','/user/set');
        $this->getView('wy_messager.php')->Output();
    }
    
    function delset(){
        $id=isset($this->router[3]) ? makeSafe($this->router[3],'int') : 0;
        $this->model('users')->delete('msgtpl','id='.$id.'  and userid='.$_SESSION['login_userid']);
        $this->assign('msg','模板删除成功！');
        $this->assign('url','/user/set');
        $this->getView('wy_messager.php')->Output();
    }
    
    function delall(){
        $listid=isset($_POST['listid']) ? $_POST['listid'] : false;
        if(!$listid){
    		$this->assign('msg','请选择要删除的记录。');
    		$this->assign('url',_S('HTTP_REFERER'));
            $this->assign('img','error');
    		$this->getView('wy_messager.php')->outPut();exit;
        }
        
        $ids='';
        foreach($listid as $key=>$val){
            $ids.=$ids ? ',' : '';
            $ids.=intval($val);
        }
        
        $this->model('users')->delete('msgtpl','id in('.$ids.') and userid='.$_SESSION['login_userid']);
    	$this->assign('msg','商品删除成功。');
    	$this->assign('url','/user/set');
        $this->assign('img','success');
    	$this->getView('wy_messager.php')->outPut();
    }
    
    function viewnews(){
        $id=isset($this->router[3]) ? makeSafe($this->router[3],'int') : 0;
        $data=$this->model('news')->get_news_by_id($id);
        $this->assign('data',$data);
        $this->getView('viewnews2.php')->Output();
    }
    
    function view(){
        $id=isset($this->router[3]) ? makeSafe($this->router[3],'int') : 0;
        $data=$this->model('news')->get_news_by_id($id);
        $this->assign('title',isset($data) ? $data['title'] : '平台公告');
        $this->assign('data',$data);
        $this->getView('viewnews.php')->Output();
    }
}
?>