<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

if(!defined('WY_ROOT'))exit;
class goods_class extends Wy_Model{
    function get_goods($limit=false,$offset=false,$cons=false){
        $data=array();
        $result=$this->fetch_all('goods',$limit,$offset,$cons,$order='order by id desc');
        if($result){
            foreach($result as $key=>$row){
                $row['kucun']=$this->model('cards')->count('cards',"tb_goodid='".$row['tb_goodid']."' and is_state=0");
                $row['sells']=$this->model('cards')->count('cards',"tb_goodid='".$row['tb_goodid']."' and is_state=1");
                $row['username']=$this->model('users')->get_username_by_userid($row['userid']);
                $row['addtime']=date('Y-m-d H:i:s',$row['addtime']);
                $data[]=$row;
            }
        }
        return $data;
    }
    
    function get_goods_by_id($id){
        $result=$this->fetch_one('goods','id='.$id);
        return $result;
    }
    
    function get_goods_by_goodid($goodid){
        $result=$this->fetch_one('goods',"tb_goodid='".$goodid."'");
        return $result;
    }
    
    function get_userid_by_goodid($goodid){
        $result=$this->fetch_one('goods',"tb_goodid='".$goodid."'",'userid');
        return $result[0];
    }
    
    function get_title_by_goodid($goodid){
        $result=$this->fetch_one('goods',"tb_goodid='".$goodid."'",'tb_title');
        return $result[0];
    }
}
?>