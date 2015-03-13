<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

error_reporting(0);
ob_start();
header('Content-type:text/html;charset=utf-8');
date_default_timezone_set('PRC');
define('WY_ROOT',dirname(__FILE__));
require_once WY_ROOT.'/config/config.php';
require_once WY_ROOT.'/includes/libs/Functions.php';
session_start();
?>