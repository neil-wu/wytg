<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

if(!defined('WY_ROOT'))exit;
class admin_class extends Wy_Model{
    function get_admin($limit=false,$offset=false,$cons=false,$order='order by id desc'){
        $data=array();
        $result=$this->fetch_all('admin',$limit,$offset,$cons,$order);
        if($result){
            foreach($result as $key=>$val){
                $val['addtime']=date('Y-m-d H:i:s',$val['addtime']);
                $userlog=$this->get_log_by_adminid($val['id']);
                if($userlog){
                    $val['lastlogip']=$userlog['logip'];
                    $val['lastlogtime']=date('Y-m-d H:i:s',$userlog['logtime']);
                } else {
                    $val['lastlogip']='';
                    $val['lastlogtime']='';
                }
                $data[]=$val;
            }
        }
        return $data;
    }
    
    function get_admin_by_adminid($adminid){
        $result=$this->fetch_one('admin','id='.$adminid);
        return $result;
    }
    
    function get_admin_by_adminname($adminname){
        $result=$this->fetch_one('admin',"username='".$adminname."'");
        return $result;
    }
    
    function get_adminid_by_adminname($adminname){
        $result=$this->fetch_one('admin',"username='".$adminname."'",'id');
        return $result[0];
    }
    
    function get_adminname_by_adminid($adminid){
        $result=$this->fetch_one('admin',"id='".$adminid."'",'username');
        return $result[0];
    }
    
    function get_log_by_adminid($adminid){
        $result=$this->fetch_one('adminlogs','userid='.$adminid.' order by id desc');
        return $result;
    }
    
    function get_adminlogs($limit=false,$offset=false,$cons=false,$order='order by id desc'){
        $data=array();
        $result=$this->fetch_all('adminlogs',$limit,$offset,$cons,$order);
        if($result){
            foreach($result as $key=>$val){
                $val['username']=$this->get_adminname_by_adminid($val['userid']);
                $val['logtime']=date('Y-m-d H:i:s',$val['logtime']);
                $data[]=$val;
            }
        }
        return $data;
    }
}
?>