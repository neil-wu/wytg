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
<form name="add" method="post" action="?action=addsave">
<table class="register">
<tr>
<td class="right" width="100">管理员类型：</td>
<td>
<select name="utype">
<option value="1">总管理员</option>
<option value="2">子管理员</option>
</select>
</td>
</tr>
<tr>
<td class="right">设置状态：</td>
<td>
<select name="is_state">
<option value="0">审核通过</option>
<option value="1">暂停用户</option>
</select>
</td>
</tr>

<tr>
<td class="right">管理登录名：</td>
<td><input type="text" name="username" autocomplete="off" class="input" size="40" maxlength="50" /> <span class="err_msg" id="err_msg_1">* </span></td>
</tr>

<tr>
<td class="right">登录密码：</td>
<td><input type="password" name="userpass" autocomplete="off" class="input" size="40" maxlength="20" /> <span class="err_msg" id="err_msg_2">* </span></td>
</tr>

<tr>
<td class="right">确认登录密码：</td>
<td><input type="password" name="userpass1" autocomplete="off" class="input" size="40" maxlength="20" /> <span class="err_msg" id="err_msg_5">* </span></td>
</tr>

<tr>
<td class="right">登录IP限制：</td>
<td><select name="is_verifyip">
<option value="0">不设置</option>
<option value="1">根据IP地址</option>
<option value="2">根据IP地址段</option>
</select></td>
</tr>

<tr>
<td class="right">IP地址内容：</td>
<td><textarea name="verifyip" class="input" cols="50" rows="5"></textarea> 多个IP地址或IP段中间用‘|’隔开</td>
</tr>

<tr>
<td class="right">安全码开关：</td>
<td>
<input type="radio" name="is_safe" id="is_safe_1" value="1" onclick="$('tr#is_safe_status').show();"><label for="is_safe_1">开启</label>&nbsp;
<input type="radio" name="is_safe" id="is_safe_2" value="0" onclick="$('tr#is_safe_status').hide();" checked><label for="is_safe_2">关闭</label>
</td>
</tr>

<tr id="is_safe_status" style="display:none">
<td class="right">输入安全码：</td>
<td><input type="text" name="userkey" autocomplete="off" class="input" size="40" maxlength="20"  /> <span class="err_msg" id="err_msg_8">*</span></td>
</tr>

<tr>
<td class="right">管理权限分配：</td>
<td><input type="checkbox" id="selectLimit"> <label for="selectLimit">全选</label></td>
</tr>

<tr>
<td class="right"></td>
<td>
<div style="height:200px;overflow:auto;border:1px solid #ccc;">
<table id="adminLimitList">
<tr>
<?php
$i=1;
foreach($admSubMenu as $sumkey=>$submenu):
$submenu[1]=strtolower($submenu[1]);
?>
<td><input type="checkbox" name="adminlimit['<?php echo $submenu[1] ?>']" id="<?php echo $submenu[1] ?>" value="<?php echo $submenu[1] ?>"> <label for="<?php echo $submenu[1] ?>"><?php echo $submenu[2] ?></label></td>
<?php
if($i%4==0) echo '</tr><tr>';
$i++;
endforeach;
?>
</table>
</div>
</td>
</tr>

<tr>
<td class="right"></td>
<td><input type="submit" class="btn1" value="保存添加" /> <span id="returnMsg"></span></td>
</tr>
</table>
</form>
</div>

<script>
$(function(){
	$('#selectLimit').click(function(){
	    if($(this).attr('checked')=='checked'){
		    $('table#adminLimitList [type=checkbox]').attr('checked',true);
			$(this).next().text('取消');
		} else {
		    $('table#adminLimitList [type=checkbox]').attr('checked',false);
			$(this).next().text('全选'); 
		}
	});

  $('[type=submit]').click(function(){
    username=$.trim($('[name=username]').val());
	if(username=='' || username.length<5 || username.length>20){
	  $('#err_msg_1').html('登录账号不能为空！长度在5-20个字符之间！').show();
	  $('[name=username]').focus();
	  return false;
	};

	if($('#err_msg_1').html()!=''){$('#err_msg_1').html('').hide();};

    userpass=$.trim($('[name=userpass]').val());
	if(userpass=='' || userpass.length<6 || userpass>20){
	  $('#err_msg_2').html('登录密码不能为空！长度在6-20个字符之间！').show();
	  $('[name=userpass]').focus();
	  return false;
	};

	if($('#err_msg_2').html()!=''){$('#err_msg_2').html('').hide();};

    userpass1=$.trim($('[name=userpass1]').val());
	if(userpass1!=userpass){
	  $('#err_msg_5').html('两次输入的密码不同！').show();
	  $('[name=userpass1]').focus();
	  return false;
	};

	if($('#err_msg_5').html()!=''){$('#err_msg_5').html('').hide();}
  });
});
</script>