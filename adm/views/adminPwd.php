<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

if(!defined('WY_ROOT')) exit;
?>
<div id="main_content"> 
<style>
td p{padding:5px 0;display:none}
td.right{text-align:right}
.input{width:250px}
</style>

<form name="add" method="post" action="?action=save">
<table class="register">
<tr>
<td class="right" width="100">管理员账号：</td>
<td><?php echo $_SESSION['login_adminname'] ?></td>
</tr>

<tr>
<td class="right">旧密码：</td>
<td><input type="password" name="oldpass" class="input" size="40" maxlength="20" /> <span class="red">*</span></td>
</tr>

<tr>
<td class="right">新密码：</td>
<td><input type="password" name="newpass" class="input" size="40" maxlength="20" /> <span class="red">*</span></td>
</tr>

<tr>
<td class="right">确认新密码：</td>
<td><input type="password" name="confirmnewpass" class="input" size="40" maxlength="20" /> <span class="red">*</span></td>
</tr>

<tr>
<td class="right"></td>
<td><input type="submit" class="btn1" value="保存设置" /></td>
</tr>
</table>
</form>
</div>

<script>
$(function(){
  $('[type=submit]').click(function(){
    oldpass=$.trim($('[name=oldpass]').val());
	if(oldpass=='' || oldpass.length<6 || oldpass.length>20){
	  alert('旧密码不能为空！长度在6-20个字符之间！');
	  $('[name=oldpass]').focus();
	  return false;
	}

    newpass=$.trim($('[name=newpass]').val());
	if(newpass=='' || newpass.length<6 || newpass.length>20){
	  alert('新密码不能为空！长度在6-20个字符之间！');
	  $('[name=newpass]').focus();
	  return false;
	}

    confirmnewpass=$.trim($('[name=confirmnewpass]').val());
	if(confirmnewpass!=newpass){
	  alert('两次输入的密码不一样！');
	  $('[name=confirmnewpass]').focus();
	  return false;
	}
  })
})
</script>