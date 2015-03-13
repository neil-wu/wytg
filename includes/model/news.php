<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

if(!defined('WY_ROOT'))exit;
class news_class extends Wy_Model{
    function get_news($limit=false,$offset=false,$cons=false){
        $data=array();
        $result=$this->fetch_all('news',$limit,$offset,$cons,$order='order by id desc');
        if($result){
            foreach($result as $key=>$val){
                $val['addtimeforuser']=date('m-d',$val['addtime']);
                $val['addtime']=date('Y-m-d H:i:s',$val['addtime']);
                $val['classname']=$this->get_cname_by_id($val['classid']);
                $data[]=$val;
            }
        }
        return $data;
    }
    
    function get_news_by_id($id){
        $result=$this->fetch_one('news','id='.$id);
        $result['addtime']=date('Y-m-d H:i:s',$result['addtime']);
        return $result;
    }
    
    function get_newsclass($limit=false,$offset=false,$cons=false){
        $data=array();
        $result=$this->fetch_all('newsclass',$limit,$offset,$cons,$order='order by id desc');
        if($result){
            foreach($result as $key=>$val){
                $data[]=$val;
            }
        }
        return $data;
    }
    
    function get_cname_by_id($id){
        $result=$this->fetch_one('newsclass','id='.$id,'classname');
        return $result[0];
    }
    
    function get_newsclass_by_id($id){
        $result=$this->fetch_one('newsclass','id='.$id);
        return $result;
    }
}
?>