<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/
if(!defined('WY_ROOT')) exit; ?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-type" content="text/html;charset=utf-8">
<title><?php echo isset($title) && $title!='' ? $title.' - ' : '' ?><?php echo ''.$this->config['sitename'] ?><?php echo $this->config['sitetitle']!='' ? ' - '.$this->config['sitetitle'] : '' ?></title>
<?php
loadFile('usr/default/css/custom.css');
loadFile('common/jquery.min.js');
loadFile('common/calendar.js');
loadFile('common/woodyapp.js');
loadFile('tpl/default/js/jquery.placeholder.js');
?>
<style>
.topbar{background-color:#ffff66;border-bottom:1px solid #000;text-align:center;font-size:12px;height:30px;line-height:30px;}
</style>
</head>

<body>
    <?php if($_SESSION['login_usertype']==1):?>
        <div class="topbar green">您现在的账号状态为试用状态(2天有效试用期)，<a href="<?php echo TB::FW();?>" class="line blue">立即购买服务→</a></div>
    <?php endif;?>
    
    <?php if($_SESSION['login_usertype']==2):?>
        <div class="topbar red">您当前账号状态已过期(数据为只读状态)，<a href="<?php echo TB::FW();?>" class="line blue">立即续费服务→</a></div>
    <?php endif;?>
    <div id="header">
        <div class="wy_container">
            <div class="logo">
                <a class="navbar-brand" href="/user">卡密寄售</a>
            </div>
          
           <ul class="nav">
              <li><a href="/cards">卡密库存</a></li>
              <li><a href="/goods">在售商品</a></li>
              <li><a href="/orders">交易订单</a></li>
              <li><a href="/user/set">发信模板</a></li>
            </ul>

        <div class="right">
            <a href="/user" ><?php echo $_SESSION['login_username']?>的账户</a>&nbsp;&nbsp;<a href="/user/logout"><img title="登出账户" src="/static/usr/default/images/i05.png" height="22" align="absmiddle"></a>
        </div>
    </div>
    </div>
