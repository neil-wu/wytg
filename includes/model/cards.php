<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

if(!defined('WY_ROOT'))exit;
class cards_class extends Wy_Model{
    function get_cards($limit=false,$offset=false,$cons=fase){
        $data=array();
        $result=$this->fetch_all('cards',$limit,$offset,$cons,$order='order by id desc');
        if($result){
            foreach($result as $key=>$row){
                $row['addtime']=date('Y-m-d H:i:s',$row['addtime']);
                $row['selltime']=$row['is_state'] ? date('Y-m-d H:i:s',$row['selltime']) : '-';
                $row['tb_title']=$this->model('goods')->get_title_by_goodid($row['tb_goodid']);
                $row['cardpwd']=$row['cardpwd'] ? $row['cardpwd'] : '-';
                $row['username']=$this->model('users')->get_username_by_userid($row['userid']);
                $data[]=$row;
            }
        }
        return $data;
    }
}
?>