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
<script charset="utf-8" src="views/editor4/kindeditor-min.js"></script>
<script charset="utf-8" src="views/editor4/lang/zh_CN.js"></script>
<?php if(_G('add_suc')): ?><div class="actived">文章添加成功</div><?php endif; ?>
<?php if(_G('add_err')): ?><div class="error">文章添加失败</div><?php endif; ?>
<?php if(_G('edit_suc')): ?><div class="actived">文章修改成功</div><?php endif; ?>
<?php if(_G('edit_err')): ?><div class="error">文章修改失败</div><?php endif; ?>
<?php if(_G('del_suc')): ?><div class="actived">文章删除成功</div><?php endif ?>
<?php if(_G('edit_suc')): ?><div class="actived">文章修改成功</div><?php endif ?>
<?php if(_G('del_err')): ?><div class="error">请选择要删除的文章</div><?php endif ?>
<div id="main_content">
<input type="button" onclick="javascript:location.href='?action=add'" class="btn1" value="添加文章">
<select name="classid" onchange="window.location.href='news.php?classid='+$(this).val()">
<option value="">全部分类</option>
<?php
if($newsClass):
foreach($newsClass as $key=>$val):
?>
<option value="<?php echo $val['id'] ?>" <?php echo $classid==$val['id'] ? 'selected' : '' ?>><?php echo $val['classname'] ?></option>
<?php
endforeach;
endif;
?>
</select>
<!--####信息列表####-->
<table class="table_base table_list margin-top15">
<tr>
<th>选择</th>
<th>类别</th>
<th>文章编号</th>
<th>标题</th>
<th>自动弹出</th>
<th>首页显示</th>
<th>日期</th>
<th>操作</th>
</tr>
<form name="list" method="post" action="?action=delall">
<?php 
if($lists):
foreach($lists as $key=>$row):
?>
<tr class="lightbox" id="u_<?php echo $row['id'] ?>">
<td><input type="checkbox" name="listid[]" class="checkbox" value="<?php echo $row['id'] ?>" /></td>
<td><?php echo $row['classname'] ?></td>
<td><?php echo $row['id'] ?></td>
<td class="left"><span  style="color:#<?php echo $row['is_color'] ?><?php echo $row['is_bold']!='' ? ';font-weight:bold' : '' ?>"><?php echo $row['title'] ?></span></td>
<td><?php echo $row['is_popup'] ? '是' : '否' ?></td>
<td><?php echo $row['is_display_home'] ? '是' : '否' ?></td>
<td><?php echo $row['addtime'] ?></td>
<td>
<a href="?action=edit&id=<?php echo $row['id'] ?>"><img src="/static/adm/images/ico_edit.png"></a>&nbsp;
<a href="javascript:void(0)" onclick="delData(<?php echo $row['id'] ?>)"><img src="/static/adm/images/ico_del.png"></a>
</td>
</tr>
<?php endforeach;?>
<tr><td colspan="8" class="padding_top_bottom_5 whitebg left">
<input type="button" class="btn3" value="全选" id="selectall" />
<input type="button" class="btn2" value="反选" id="unselectall" />
<input type="submit" class="btn1" value="删除" onclick="if(!confirm('是否要执行 删除 操作？'))return false" />
</td></tr>
<tr><td colspan="8" class="h30 graybg"><?php echo $pagelist ?></td></tr>
</form>
<?php endif; ?>
</table>
</div>

<script>
var delData=function(id){
    if(confirm('是否要执行此操作？')){
		$.get('news.php',{action:'del',id:id},function(data){
		    if(data=='ok'){
				$('tr#u_'+id).fadeOut();
			} else {
			    $('tr#u_'+id).css({'background-color':'red'});
			}
		})
    }
};

setTimeout(hideMsg,2600);
</script>