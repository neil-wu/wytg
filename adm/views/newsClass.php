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
<?php if(_G('add_suc')): ?><div class="actived">分类新建成功！</div><?php endif ?>
<?php if(_G('del_suc')): ?><div class="actived">分类删除成功！</div><?php endif ?>
<?php if(_G('edit_suc')): ?><div class="actived">分类修改成功！</div><?php endif ?>
<?php if(_G('add_err')): ?><div class="error">分类新建失败！</div><?php endif ?>
<?php if(_G('del_err')): ?><div class="error">请选择要删除的记录！</div><?php endif ?>
<div id="main_content">
<input type="button" onClick="Boxy.load('?action=add',{title:'新建分类'})" class="btn1" value="新建分类">

<table class="table_base table_list margin-top15">
<tr>
<th>分类ID</th>
<th>分类名称</th>
<th>操作</th>
</tr>

<?php
if($lists): 
foreach($lists as $key=>$row):
?>
<form name="list" method="post" action="?action=delall">
<tr class="lightbox">
<td><?php echo $row['id'] ?></td>
<td><?php echo $row['classname'] ?></td>
<td>
<a href="javascript:;" onclick="Boxy.load('?action=edit&id=<?php echo $row['id'] ?>',{title:'编辑分类'})"><img src="/static/adm/images/ico_edit.png"></a>&nbsp;
<a href="?action=del&id=<?php echo $row['id'] ?>" onclick="if(!confirm('是否要执行 删除 操作？'))return false"><img src="/static/adm/images/ico_del.png"></a>
</td>
</tr>
<?php endforeach;?>
</form>
<?php endif; ?>
</table>
<script>
var addClass=function(){
	$('#addClass').toggle();
};

setTimeout(hideMsg,2600);
$('#addClass [type=submit]').click(function(){
	var $ob=$('[name=cname]');
	var $cname=$.trim($ob.val());
	if($cname==''){
		alert('分类名称不能为空！');
		$ob.focus();
		return false;
	} else {
		var reg1=/[^\a-zA-Z\u4e00-\u9fa5]/g;
		if(reg1.test($cname)){
			alert('分类名称只能是汉字或字母！');
			$ob.focus();
			return false;
		}
	}
});
</script>
</div>