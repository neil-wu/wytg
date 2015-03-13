<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

if(!defined('WY_ROOT'))exit;
class users_class extends Wy_Model{
    function get_users($limit=false,$offset=false,$cons=false){
        $data=array();
        $result=$this->fetch_all('users',$limit,$offset,$cons,$order='order by id desc');
        if($result){
            foreach($result as $key=>$val){
                $val['addtime']=date('Y-m-d H:i:s',$val['addtime']);
                $val['expiretime']=date('Y-m-d H:i:s',$val['expiretime']);
                $userlog=$this->get_log_by_userid($val['userid']);
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
    
    function get_users_by_userid($userid){
        $result=$this->fetch_one('users','userid='.$userid);
        return $result;
    }
    
    function get_users_by_username($username){
        $result=$this->fetch_one('users',"username='".$username."'");
        return $result;
    }
    
    function get_userid_by_username($username){
        $result=$this->fetch_one('users',"username='".$username."'",'userid');
        return $result[0];
    }
    
    function get_userid_by_usercode($usercode){
        $result=$this->fetch_one('users',"usercode='".$usercode."'",'userid');
        return $result[0];
    }
    
    function get_username_by_userid($userid){
        $result=$this->fetch_one('users',"userid=".$userid."",'username');
        return $result[0];
    }
    
    function get_msgtpl($limit=false,$offset=false,$cons=false){
        $data=array();
        $result=$this->fetch_all('msgtpl',$limit,$offset,$cons,$order='order by id desc');
        if($result){
            foreach($result as $key=>$val){
                $val['addtime']=date('Y-m-d H:i:s',$val['addtime']);
                $val['username']=$this->model('users')->get_username_by_userid($val['userid']);
                $data[]=$val;
            }
        }
        return $data;
    }
    
    function get_msgtpl_by_id($id){
        $result=$this->fetch_one('msgtpl','id='.$id);
        return $result;
    }
    
    function get_userlogs($limit=false,$offset=false,$cons=false){
        $data=array();
        $result=$this->fetch_all('userlogs',$limit,$offset,$cons,$order='order by id desc');
        if($result){
            foreach($result as $key=>$val){
                $val['logtime']=date('Y-m-d H:i:s',$val['logtime']);
                $val['username']=$this->model('users')->get_username_by_userid($val['userid']);
                $data[]=$val;
            }
        }
        return $data;
    }
    
    function get_log_by_userid($userid){
        $result=$this->fetch_one('userlogs','userid='.$userid.' order by id desc');
        return $result;
    }
}
?>