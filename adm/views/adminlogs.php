<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

if(!defined('WY_ROOT'))exit;
?>

<?php if(_G('del_suc')): ?><div class="actived">删除成功</div><?php endif; ?>
<?php if(_G('del_err')): ?><div class="error">删除失败</div><?php endif; ?>
<script>
setTimeout(hideMsg,2600);
</script>
<div id="main_content">
<!--####搜索查询####-->
<form name="s" method="get" action="">
用户名：
<input type="text" name="username" class="input" maxlength="20" size="10" value="<?php echo $username ?>" />&nbsp;&nbsp;
日期范围：<input type="text" name="fdate" class="input" id="txtDate" onclick="SelectDate(this)" size="12" readonly="readonly" value="<?php echo $fdate ?>" />&nbsp;
至 <input type="text" name="tdate" class="input" id="txtDate1" onclick="SelectDate(this)" size="12" readonly="readonly" value="<?php echo $tdate ?>" />&nbsp;&nbsp;
<input type="submit"  class="btn3" value="查询日志" />
<input type="button" onclick="Boxy.load('?action=deldatalogs&username=<?php echo $username ?>&fdate=<?php echo $fdate ?>&tdate=<?php echo $tdate ?>',{title:'清除登录日志'})"  class="btn1" value="清除日志" />
</form>
  <!--#列表#-->
<table class="table_base table_list margin-top15">
<tr>
<th>选择</th>
<th>用户名</th>
<th>IP</th>
<th>日期</th>
<th>操作</th>
</tr>
<?php
if($lists): 
foreach($lists as $key=>$row):
?>
<form name="list" method="post" action="?action=delalllogs">
<tr class="lightbox">
<td><input type="checkbox" name="listid[]" value="<?php echo $row['id'] ?>" /></td>
<td class="bold"><?php echo $row['username'] ?></td>
<td><a href="http://www.baidu.com/s?wd=<?php echo $row['logip'] ?>" target="_blank" title="点击查看登录IP来源"><?php echo $row['logip'] ?></a></td>
<td><?php echo $row['logtime'] ?></td>
<td>
<a href="<?php echo "?action=dellogs&id=".$row['id'] ?>" onclick="if(!confirm('是否要执行 删除 操作？'))return false"><img src="/static/adm/images/ico_del.png"></a>
</td>
</tr>
<?php endforeach;?>
<tr><td colspan="5" class="padding_top_bottom_5 whitebg left">
<input type="button" class="btn3" value="全选" id="selectall" />
<input type="button" class="btn2" value="反选" id="unselectall" />
<input type="submit" class="btn1" value="删除" onclick="if(!confirm('是否要执行 删除 操作？'))return false" />
</td></tr>
<tr><td colspan="5" class="h30 graybg"><?php echo $pagelist ?></td></tr>
</form>
<?php endif; ?>
</table>
</div>