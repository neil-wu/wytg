 <?php
if(!defined('WY_ROOT')) exit;
?>
<?php if(_G('del_suc')): ?><div class="actived">删除成功</div><?php endif; ?>
<?php if(_G('del_err')): ?><div class="error">删除失败</div><?php endif; ?>
<?php if(_G('add_err_1')): ?><div class="error">商户资料填写不完整</div><?php endif; ?>
<?php if(_G('add_err_2')): ?><div class="error">商户已存在</div><?php endif; ?>
<?php if(_G('add_suc')): ?><div class="actived">商户创建成功</div><?php endif; ?>
<?php if(_G('edit_suc')): ?><div class="actived">修改保存成功</div><?php endif; ?>
<?php if(_G('edit_err')): ?><div class="error">修改保存失败</div><?php endif; ?>

<div id="main_content">  
  <form name="search" method="get" action="">
  <input type="hidden" name="do" value="search" />
  账号状态：<select name="state">
	  <option value="-1" <?php echo $state==-1 ? 'selected' : '' ?>>全部</option>
	  <?php foreach($userCtype as $key=>$val): ?>
	  <option value="<?php echo $key ?>" <?php echo $state==$key ? 'selected' : '' ?>><?php echo $val ?></option>
	  <?php endforeach; ?>
  </select>&nbsp;
  <input type="text" name="keyword" size="30" class="input" value="<?php echo $keyword ?>" />
  <input type="submit" class="btn3" value="查询商户" /> 
  <input type="button" onclick="Boxy.load('?action=deldata',{title:'清除注册商户'})"  class="btn1" value="清除商户" />&nbsp;

 
  </form>	  

<!--#列表#-->
<table class="margin-top15 table_base table_list">
<tr>
  <th class="center">选 择</th>
  <th>商户编号</th>
  <th>商户名称</th>
  <th class="center" width="50">状 态</th>
  <th>淘宝店铺</th>
  <th>注册时间</th>
  <th>到期时间</th>
  <th>最后一次登录IP</th>
  
  <th class="center">操 作</th>
</tr>
<form name="delall" method="post" action="?action=delall">
<?php
if($lists):
foreach($lists as $key=>$val):
?>
<tr class="lightbox" id="u_<?php echo $val['id'] ?>">

  <td class="center"><input type="checkbox" name="listsid[]" value="<?php echo $val['id'] ?>" /></td>
  <td class="center"><?php echo $val['userid'] ?></td>

  <td class="center"><a href="<?php echo TB::IM($val['username']); ?>" target="_blank" class="line blue"><?php echo TB::IMG($val['username']); ?><?php echo $val['username'] ?></a></td>
  <td class="center">
	  <?php $status=Options::getUserStatus(); echo $status[$val['is_state']] ?>
  </td>

  <td class="center"><a href=""><?php echo $val['shop'] ?></a></td>

  <td class="center"><span title="最后一次登录时间：<?php echo $val['lastlogtime'] ?>"><?php echo $val['addtime'] ?></span></td>
  <td class="center"><?php echo $val['expiretime']?></td>

  <td class="center"><a href="http://www.baidu.com/s?wd=<?php echo $val['lastlogip'] ?>" target="_blank" title="点击查看登录IP来源" style="text-decoration:underline;color:#666"><?php echo $val['lastlogip'] ?></a></td>


  <td class="center" width="100">
  	  <a href="?action=edit&id=<?php echo $val['userid'] ?>" title="编辑"><img src="/static/adm/images/ico_edit.png" alt="编辑" /></a>&nbsp;

	  <a href="javascript:void(0)" title="删除" onclick="delUser(<?php echo $val['userid'] ?>)"><img src="/static/adm/images/ico_del.png" alt="编辑" /></a>&nbsp;

	  <a href="?action=loginusercenter&id=<?php echo $val['userid'] ?>" target="_blank" title="登录到<?php echo $val['username'] ?>的商户中心" style="text-decoration:underline;color:#666">登录</a>&nbsp;
  </td>
</tr>
<?php endforeach; ?>
<tr><td colspan="9" class="padding_top_bottom_5 whitebg left">
<input type="button" class="btn3" id="selectall" value="全选" />
<input type="button" class="btn2" id="unselectall" value="反选" />
<input type="submit" class="btn1" value="删除" onclick="if(!confirm('是否要执行此操作？'))return false" />
</td></tr>
<tr><td colspan="9" class="h30 graybg"><?php echo $PageList ?></td></tr>
<?php else: ?>
<tr><td colspan="9" class="h30 center">no data.</td></tr>
<?php endif; ?>
</form>
</table>
</div>

<script>
var delUser=function(id){
    if(confirm('是否要执行此操作？')){
		$.get('users.php',{action:'del',id:id},function(data){
		    if(data=='ok'){
				$('tr#u_'+id).fadeOut();
			} else {
			    $('tr#u_'+id).css({'background-color':'red'});
			}
		});
    }
};

setTimeout(hideMsg,2600);

function user_status_menu(userid){
	$('td ul').hide();
	$('#user_status_'+userid).addClass('usms');
	$('#user_status_'+userid).show();
};

function user_popup_menu(userid){
	$('td ul').hide();
	$('#user_popup_'+userid).show();
};

function user_ctype_menu(userid){
	$('td ul').hide();
	$('#user_ctype_'+userid).show();
};
</script>