<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

require 'common.php';
$action=_G('action');
if($action==''){
    require View::getView('header');
    require View::getView('main');
    require View::getView('footer');
}
?>