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
if(!defined('WY_ROOT')) exit;?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Sign In</title>
<link href="/static/adm/css/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	body{background:url(/static/adm/images/bg.png)}
	#login{width:350px;margin:auto;margin-top:80px;background:#fff url(/static/adm/images/top_bg.gif) top repeat-x;border-radius:5px;border:1px solid #333;box-shadow:2px 2px 2px #ccc}
	#page_title{height:60px;line-height:60px;padding-left:30px;font-weight:bold;color:#fff;text-shadow:1px 1px 1px #333;font-size:16px;font-family:Tahoma}
	#input_info{padding:10px 30px}
	.input{width:200px}
	label span{display:inline-block;width:50px;margin-right:10px;font-size:12px;text-align:right}
	.msg{position:relative;top:-20px;left:45px;height:20px;font-size:12px;font-weight:100;color:#f00;text-shadow:0px 0px 0px}
    .btn1{font-size:14px;}
</style>
</head>

<body>
<?php
$err_list=array(
    'E001'=>'验证码不正确',
	'E002'=>'用户名不能为空',
	'E003'=>'用户名长度在5至20个字符之间',
	'E004'=>'登录密码不能为空',
	'E005'=>'密码长度在6至20个字符之间',
	'E006'=>'账号不存在',
	'E007'=>'账号已停用',
	'E008'=>'登录密码错误',
	'E009'=>'登录IP无权限',
	'E010'=>'登录IP无权限',
	'E011'=>'请输入安全码',
	'E012'=>'安全码错误',
);
?>
<form name="login" method="post" action="?action=login">
	<div id="login">
    	<div id="page_title">系统管理登录
<?php if(_G('err')): ?><div class="msg"><?php echo $err_list[_G('err')] ?></div><?php endif; ?>
		</div>
        <div id="input_info">
      	  <div class="h10"></div>
        	<label><span>用户名</span><input type="text" class="input" name="usr" maxlength="20" size="30"></label>
            <div class="h10"></div>
            <label><span>密&nbsp;码</span><input type="password" class="input" name="pwd" maxlength="20" size="30"></label>
            <div class="h10"></div>
            <label><span>安全码</span><input type="password" class="input" name="safepwd" maxlength="20" size="30"></label>
            <div class="h10"></div>
            <label><span>验证码</span><input type="text" class="input" style="width:120px" name="chk" maxlength="5" size="15"> <img src="/chkcode"  align="absmiddle" alt="验证码"></label>
            <div class="h10"></div>
          	<input type="submit" class="btn1" style="margin-left:60px" value="用户登录">
            <div class="h10"></div>
        </div>
    </div>
    <div style="text-align:center;color:#999;padding-top:20px">Powered by WoodyApp</div>
</form>
</body>
</html>