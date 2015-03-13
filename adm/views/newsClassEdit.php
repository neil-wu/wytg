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
<div class="main">
<form name="add" method="post" action="?action=editsave&id=<?php echo $id ?>">
<input type="text" class="input" name="cname" size="30" maxlength="30" value="<?php echo $classname ?>" />
<input type="submit" class="btn1" value="保存分类" />
</form>
<script>
$('[type=submit]').click(function(){
	var $ob=$('[name=cname]');
	var $cname=$.trim($ob.val());
	if($cname==''){
		alert('分类名称不能为空！');
		$ob.focus();
		return false;
		}
	else{
		var reg1=/[^\a-zA-Z\u4e00-\u9fa5]/g;
		if(reg1.test($cname)){
			alert('分类名称只能是汉字或字母！');
			$ob.focus();
			return false;
			}
		}
	})
</script>
</div>