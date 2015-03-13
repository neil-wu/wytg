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
<?php if(_G('add_suc')): ?><div class="actived">消息发送成功</div><?php endif; ?>
<?php if(_G('add_err')): ?><div class="error">消息发送失败</div><?php endif; ?>
<?php if(_G('del_suc')): ?><div class="actived">删除成功</div><?php endif; ?>
<?php if(_G('del_err')): ?><div class="error">删除失败</div><?php endif; ?>
<?php if(_G('del_err_1')): ?><div class="error">请选择要删除的记录</div><?php endif; ?>
<script>setTimeout(hideMsg,2600)</script>
<style>
#msg{float:right;position:relative;margin-top:-44px;margin-right:100px}
#msg a{display:inline-block;background:#f1f1f1;border:1px solid #ddd;padding:3px 10px;margin-left:8px;}
#msg a.current{background:#fff;border-bottom:1px solid #fff;font-weight:bold}
</style>
<div id="main_content">
<div id="msg">
<a href="message.php"<?php echo $action=='' ? ' class="current"' : '' ?>>收件箱</a>
<a href="message.php?action=outbox"<?php echo $action=='outbox' ? ' class="current"' : '' ?>>发件箱</a>
<a href="javascript:void(0)" onclick="Boxy.load('?action=write',{title:'写新消息'})">写新消息</a>
</div>

<?php if($action==''): ?>
<a href="?action=setAllRead">全部设为已读</a>
<p class="h10"></p>
<form name="del" method="post" action="?action=delall">
<table class="table_base table_list">
<tr>
<th>选择</th>
<th>标题</th>
<th>发件人</th>
<th>时间</th>
<th>操作</th>
</tr>
<?php if($lists): ?>
<?php foreach($lists as $key=>$val): ?>
<tr class="lightbox">
<td><input type="checkbox" name="listid[]" value="<?php echo $val['id'] ?>" /></td>
<td class="left"><a href="javascript:void(0)" onclick="Boxy.load('?action=view&id=<?php echo $val['id'] ?>',{title:'<?php echo $val['title'] ?>'})"<?php echo $val['is_read']==0 ? ' class="bold"' : '' ?>><?php echo $val['title'] ?></a></td>
<td><a href="javascript:void(0)" onclick="Boxy.load('users.php?action=getuserinfo&userid=<?php echo $val['from_userid'] ?>',{title:'商户<?php echo $val['from_user'] ?>基本信息'})" title="商户<?php echo $val['from_user'] ?>基本信息" style="text-decoration:underline;color:#000"><?php echo $val['from_user'] ?></a></td>
<td><?php echo $val['addtime'] ?></td>
<td><a href="javascript:void(0)" onclick="Boxy.load('?action=write&uname=<?php echo $val['from_user'] ?>',{title:'写新消息'})">回复</a></td>
</tr>
<?php endforeach; ?>
<tr><td colspan="5" class="padding_top_bottom_5 whitebg left">
<input type="button" class="btn3" value="全选" id="selectall" />
<input type="button" class="btn2" value="反选" id="unselectall" />
<input type="submit" class="btn1" value="删除" onclick="if(!confirm('是否要执行 删除 操作？'))return false" />
</tr>
<tr><td class="graybg h30 " colspan="5" style="text-align:left;padding-left:10px"><?php echo $pagelist ?></td></tr>
<?php else: ?>
<tr><td colspan="5">暂无消息</td></tr>
<?php endif; ?>
</table>
</form>
<?php endif; ?>

<?php if($action=='outbox'): ?>
<form name="del" method="post" action="?action=delall">
<table class="table_base table_list">
<tr>
<th>选择</th>
<th>标题</th>
<th>收件人</th>
<th>时间</th>
</tr>
<?php if($lists): ?>
<?php foreach($lists as $key=>$val): ?>
<tr class="lightbox">
<td><input type="checkbox" name="listid[]" value="<?php echo $val['id'] ?>" /></td>
<td class="left"><a href="javascript:void(0)" onclick="Boxy.load('?action=view&id=<?php echo $val['id'] ?>',{title:'<?php echo $val['title'] ?>'})"><?php echo $val['title'] ?></a></td>
<td><a href="javascript:void(0)" onclick="Boxy.load('users.php?action=getuserinfo&userid=<?php echo $val['to_userid'] ?>',{title:'商户<?php echo $val['to_user'] ?>基本信息'})" title="商户<?php echo $val['to_user'] ?>基本信息" style="text-decoration:underline;color:#000"><?php echo $val['to_user'] ?></a></td>
<td><?php echo $val['addtime'] ?></td>
</tr>
<?php endforeach; ?>
<tr><td colspan="4" class="padding_top_bottom_5 whitebg left">
<input type="button" class="btn3" value="全选" id="selectall" />
<input type="button" class="btn2" value="反选" id="unselectall" />
<input type="submit" class="btn1" value="删除" onclick="if(!confirm('是否要执行 删除 操作？'))return false" />
</tr>
<tr><td class="graybg h30" colspan="4"><?php echo $pagelist ?></td></tr>
<?php else: ?>
<tr><td colspan="4">暂无消息</td></tr>
<?php endif; ?>
</table>
</form>
<?php endif; ?>
</div>