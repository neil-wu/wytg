<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

if(!defined('WY_ROOT')) exit;
class get extends Wy_Controller{

	function __construct(){
		parent::__construct();
	}
    
    function display(){
        $usercode=isset($this->router[2]) ? $this->router[2] : '';
        if(!$usercode || !preg_match('/^([0-9a-zA-Z]+){5}$/',$usercode) || !$this->model('users')->get_userid_by_usercode($usercode)){
            $this->assign('url','/');
            $this->assign('msg','请联系淘宝卖家获取领取网址。');
            $this->getView('wy_messager.php')->Output();exit;
        }
        
        $this->assign('title','领取卡密');
        $this->assign('token',$usercode);
        $this->getView('search.php')->Output();
    }
    
    function search(){
        $usercode=isset($this->router[3]) ? $this->router[3] : '';
        if(!$usercode || !preg_match('/^([0-9a-zA-Z]+){5}$/',$usercode) || !$this->model('users')->get_userid_by_usercode($usercode)){
            echo '领取失败，ERR01。';exit;
        }
        $nick=_P('nick');
        $orderid=_P('orderid');
        $chkcode=_P('chkcode');
        
        if(!$nick || !$orderid || !$chkcode || $chkcode!=$_SESSION['chkcode']){
            echo '领取失败，ERR02。';exit;
        }
        
        $orders=$this->model('orders')->get_orders_by_orderid($orderid);
        if(!$orders || $orders['buyer_nick']!=$nick){
            echo '订单信息不存在。';exit;
        }
        
        if($orders['tb_status']!='TRADE_FINISHED'){
            echo '订单未交易完成。';exit;
        }
        
        $goods=$this->model('goods')->get_goods_by_goodid($orders['tb_goodid']);
        if(!$goods || !in_array(4,explode(',',$goods['gettype']))){
            echo '此商品不支持手动领取。';exit;
        }
        
        if($goods['is_card']){
            echo $goods['remark'];exit;
        }
        
        if($orders['is_state']==1){
            $cards=$this->model('cards')->get_cards(false,false,"tb_orderid='".$orderid."'");
            if(!$cards){
                echo '领取失败，ERR03。';exit;
            }
            $content='';
            foreach($cards as $key=>$val){
                $content.=$content ? '<br>' : '';
                $cardpwd=$val['cardpwd'] ? ' 卡密：'.$val['cardpwd'] : '';
                $content.='卡号：'.$val['cardnum'].$cardpwd;
            }
            echo $content;exit;
        }
        
        $content='';
        $this->db->query("set autocommit=0");
        $this->db->query("begin");
        $result=$this->db->query("select * from ".DB_PREFIX."cards where is_state=0 and tb_goodid='".$orders['tb_goodid']."' limit ".$orders['tb_quantity']." for update");

        if($this->db->num_rows($result)<$orders['tb_quantity']){
            $this->db->query("rollback");
            echo '商品库存不足，请联系客服。';exit;
        }
        
        while($row=$this->db->fetch_array($result)){
            $content.=$content ? '<br>' : '';
            $cardpwd=$row['cardpwd'] ? ' 卡密：'.$row['cardpwd'] : '';
            $content.='卡号：'.$row['cardnum'].$cardpwd;
            
            $this->model('cards')->update('cards',array('is_state'=>1,'selltime'=>time(),'tb_orderid'=>$orderid),'id='.$row['id']);
        }
        $this->db->query("commit");

        $this->model('orders')->update('orders',array('is_state'=>1),"tb_orderid='".$orderid."'");
        
        echo $content;
    }
}
?>