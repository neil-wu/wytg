<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

if(!defined('WY_ROOT'))exit;
class orders_class extends Wy_Model{
    function get_orders($limit=false,$offset=false,$cons=fase){
        $data=array();
        $result=$this->fetch_all('orders',$limit,$offset,$cons,$order='order by tb_addtime desc');
        if($result){
            foreach($result as $key=>$row){
                $row['addtime']=date('Y-m-d H:i:s',$row['addtime']);
                $row['tb_addtime']=date('Y-m-d H:i:s',$row['tb_addtime']);
                $row['tb_title']=$this->model('goods')->get_title_by_goodid($row['tb_goodid']);
                $row['username']=$this->model('users')->get_username_by_userid($row['userid']);
                $row['goodname']=$this->model('goods')->get_title_by_goodid($row['tb_goodid']);
                $data[]=$row;
            }
        }
        return $data;
    }
    
    function get_orders_by_orderid($tb_orderid){
        $result=$this->fetch_one('orders',"tb_orderid='".$tb_orderid."'");
        return $result;
    }
}
?>