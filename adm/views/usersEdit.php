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
.input{width:250px}
</style>

<form name="add" method="post" action="?action=editsave&id=<?php echo $id ?>">
<table class="register">
<tr>
<td width="100" class="right">设置状态：</td>
<td>
<select name="user[is_state]">
	  <?php foreach($userCtype as $key=>$val): ?>
	  <option value="<?php echo $key ?>" <?php echo $is_state==$key ? 'selected' : '' ?>><?php echo $val ?></option>
	  <?php endforeach; ?>
  </select>
</td>
</tr>

<tr>
<td class="right">商户名称：</td>
<td><?php echo $username ?></td>
</tr>


<tr>
<td class="right">淘宝店铺：</td>
<td><?php echo $shop ?></td>
</tr>

<tr>
<td class="right">token：</td>
<td><?php echo $token ?></td>
</tr>

<tr>
<td class="right">usercode：</td>
<td><?php echo $usercode ?></td>
</tr>

<tr>
<td width="100" class="right"></td>
<td><input type="submit" class="btn1" value="保存用户" /> <span id="returnMsg"></span></td>
</tr>
</table>
<input type="hidden" name="fromUrl" value="<?php echo $fromUrl ?>">
</form>
</div>