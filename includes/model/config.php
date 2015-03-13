<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

if(!defined('WY_ROOT'))exit;
class config_class extends Wy_Model{
    function get_config(){
        $result=$this->fetch_one('config');
        return $result;
    }
}
?>