<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

if(!defined('WY_ROOT')) exit;
class gate extends Wy_Controller{

	function __construct(){
		parent::__construct();
	}
    
    function get(){
        
        $users=$this->model('users')->get_users();
        //print_r($users);exit;
        if($users){
            foreach($users as $key=>$row){
                $_SESSION['top_session']=$row['token'];
                
                $data=TB::API('taobao.trades.sold.get',array(
                    'fields'=>'buyer_nick, created, tid, status, payment, discount_fee, total_fee, pay_time, num_iid, num, price,alipay_no,has_buyer_message, orders.price, orders.num, orders.num_iid, orders.sku_id, orders.refund_status',
    
                    'start_created'=>date('Y-m-d',time()-60*60*24).' 00:00:00',
                    //'end_created'=>'2014-07-01 23:59:59',
                ));
                //print_r($data);exit;
                $orders=array();
                $i=0;
                foreach($data as $key=>$val){
                    if($this->model('goods')->get_userid_by_goodid($val['num_iid'])){
                        $order=array(
                            'userid'=>$row['userid'],
                            'tb_goodid'=>$val['num_iid'],
                            'tb_orderid'=>$val['tid'],
                            'buyer_nick'=>$val['buyer_nick'],
                            'tb_addtime'=>strtotime($val['created']),
                            'tb_quantity'=>$val['num'],
                            'tb_status'=>$val['status'],
                            'tb_paymoney'=>$val['payment'],
                            'tb_price'=>$val['total_fee'],
                            'tb_discount'=>$val['discount_fee'],
                            'tb_tradeno'=>$val['alipay_no'],
                        );
            
                        $orderinfo=TB::API('taobao.trade.fullinfo.get',array(
                            'fields'=>'buyer_alipay_no,buyer_email,buyer_message',
                            'tid'=>$val['tid'],
                        ));
            
                        $order=array_merge($order,array(
                            'buyer_alipay_no'=>$orderinfo['buyer_alipay_no'],
                            'buyer_email'=>$orderinfo['buyer_email'],
                            'buyer_message'=>isset($orderinfo['buyer_message']) ? $orderinfo['buyer_message'] : '',
                        ));
                        
                        if($val['status']=='WAIT_SELLER_SEND_GOODS'){
                            //已付款，等待发货
                            TB::API('taobao.logistics.online.send',array(
                               'tid'=>$val['tid'], 
                            ));
                        }
                        
                        if($val['status']=='TRADE_FINISHED'){
                            //确认收货和付款，发送卡密
                            $flag=$this->sendGoods($val['tid']);
                            if($flag){
                                $i++;
                            }
                        }
            
                        if($this->model('orders')->get_orders_by_orderid($val['tid'])){
                            $this->model('orders')->update('orders',$order,"tb_orderid='".$val['tid']."'");
                        } else {
                            $order=array_merge($order,array('addtime'=>time()));
                            $this->model('orders')->insert('orders',$order);
                        }
                    }
                }
            }
        }
        
        echo $i;
    }
    
    function sendGoods($tb_orderid){
        $orders=$this->model('orders')->get_orders_by_orderid($tb_orderid);
        if(!$orders || $orders['is_state']){
            return false;
        }
        
        $goods=$this->model('goods')->get_goods_by_goodid($orders['tb_goodid']);
        if(!$goods || $goods['is_state']){
            return false;
        }
        
        $users=$this->model('users')->get_users_by_userid($orders['userid']);
        if(!$users){
            return false;
        }
        
        $tpl=$this->model('users')->get_msgtpl_by_id($goods['tplid']);
        if(!$tpl){
            return false;
        }
        
        if($goods['is_card']){
            $content=$goods['remark'];
        } else {
            $content='';
            $this->db->query("set autocommit=0");
            $this->db->query("begin");
            $result=$this->db->query("select * from ".DB_PREFIX."cards where is_state=0 and tb_goodid='".$orders['tb_goodid']."' limit ".$orders['tb_quantity']." for update");

            if($this->db->num_rows($result)>=$orders['tb_quantity']){
                while($row=$this->db->fetch_array($result)){
                    $content.=$content ? '<br>' : '';
                    $cardpwd=$row['cardpwd'] ? ' 卡密：'.$row['cardpwd'] : '';
                    $content.='卡号：'.$row['cardnum'].$cardpwd;
                    
                    $this->model('cards')->update('cards',array('is_state'=>1,'selltime'=>time(),'tb_orderid'=>$tb_orderid),'id='.$row['id']);
                }
            } else {
                $this->db->query("rollback");
            }
            $this->db->query("commit");
        }
        
        if($content){
            $title=str_replace('{shopname}',$users['shop'],$tpl['title']);
            $gettype=explode(',',$goods['gettype']);

            $new_content=str_replace('{shopname}',$users['shop'],$tpl['tpl']);
            $new_content=str_replace('{content}',$content,$new_content);
        
            if(in_array(4,$gettype)){
                $goodurl='http://'._S('HTTP_HOST').'/get/'.$users['usercode'];
                $new_content=str_replace('{goodurl}','<a href="'.$goodurl.'">'.$goodurl.'</a>',$new_content); 
            }
            
            $new_content=str_replace("\r\n",'<br>',$new_content);
        
            if(in_array(1,$gettype) && $orders['buyer_email']){
                sendMail($orders['buyer_email'],$title,$new_content);
            }
        
            if(in_array(2,$gettype) && $orders['buyer_alipay_no']){
                sendMail($orders['buyer_alipay_no'],$title,$new_content);
            }
        
            if(in_array(3,$gettype) && $orders['buyer_message'] && isMail($orders['buyer_message'])){
                sendMail($orders['buyer_message'],$title,$new_content);
            }
        
            $this->model('orders')->update('orders',array('is_state'=>1),"tb_orderid='".$tb_orderid."'");
        
            return true;
        }
        
        return false;
    }
}
?>