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
<?php if(_G('del_suc')): ?><div class="actived">删除成功！</div><?php endif ?>
<?php if(_G('del_err')): ?><div class="error">请选择要删除的记录！</div><?php endif ?>
<div class="actived" id="retMsg"></div>
<script>
setTimeout(hideMsg,2600);
</script>
<div id="main_content">
<!--####搜索查询####-->
<form name="s" method="get" action="">
开始日期： <input type="text" name="fdate" class="input" id="txtDate" onclick="SelectDate(this)" size="12" readonly="readonly" value="<?php echo $fdate ?>" />&nbsp;
至 <input type="text" name="tdate" class="input" id="txtDate1" onclick="SelectDate(this)" size="12" readonly="readonly" value="<?php echo $tdate ?>" />&nbsp;

状态：<select name="state">
<option value="-1" <?php if($state==-1) echo 'selected'; ?>>全部</option>
<option value="0" <?php if($state==0) echo 'selected'; ?>>上架中</option>
<option value="1" <?php if($state==1) echo 'selected'; ?>>已下架</option>
</select>&nbsp;
<input type="text" class="input" size="20" name="kwd" value="<?php echo $kwd ?>" /> 
<input type="submit"  class="btn3" value="查询订单" />&nbsp;
<input type="hidden" name="do" value="search" />
</form>
<!--####信息列表####-->
<table class="table_base table_list margin-top15">
<tr>
<th>选择</th>
<th>商户名称</th>
<th>商品名称</th>
<th>商品图片</th>
<th>商品售价</th>
<th>日期</th>
<th>状态</th>
<th>卡密库存</th>
<th>卡密销售</th>
<th>操作</th>
</tr>

<?php
if($lists): 
foreach($lists as $key=>$row):
?>
<form name="list" method="post" action="?action=delall">
<tr class="lightbox" id="r_<?php echo $row['id'] ?>">
<td><input type="checkbox" name="listid[]" class="checkbox" value="<?php echo $row['id'] ?>" /></td>
<td><a class="line blue"  target="_blank" href="<?php echo TB::IM($row['username']); ?>"><?php echo TB::IMG($row['username']); ?><?php echo $row['username'] ?></a></td>

<td>
    <a class="line blue" href="http://item.taobao.com/item.htm?id=<?php echo $row['tb_goodid']?>" target="_blank"><?php echo $row['tb_title'] ?></a>
</td>

<td><img src="<?php echo $row['tb_img']?>" width="20"></td>

<td><?php echo $row['tb_price'] ?> 元</td>

<td><?php echo $row['addtime'] ?></td>

<td><?php echo $row['is_state'] ? '<span class="red">已下架</span>' : '<span class="green">出售中</span>' ?></td>
<td><a class="line green" href="cards.php?kwd=<?php echo $row['tb_goodid']?>&state=0">查看(<?php echo $row['kucun']?>)</a></td>
<td><a class="line green" href="cards.php?kwd=<?php echo $row['tb_goodid']?>&state=1">查看(<?php echo $row['sells']?>)</a></td>

<td width="80">

	<a class="line blue" href="users.php?action=loginusercenter&id=<?php echo $row['userid'] ?>" target="_blank" title="登录到<?php echo $row['username'] ?>的商户中心">登录</a>&nbsp;

	<a class="line red" href="javascript:void(0)" onclick="delData(<?php echo $row['id'] ?>)" title="删除此订单">删除</a>&nbsp;
</td>
</tr>

<?php
endforeach;
?>

<tr><td colspan="10" class="padding_top_bottom_5 whitebg left">
<input type="button" class="btn3" value="全选" id="selectall" />
<input type="button" class="btn2" value="反选" id="unselectall" />
<input type="submit" class="btn1" value="删除" onclick="if(!confirm('是否要执行 删除 操作？'))return false" />
</td>
</tr>
<tr><td colspan="10" class="h30 graybg"><?php echo $pagelist ?></td></tr>
</form>
<?php endif; ?>
</table>
</div>

<script>
function delData(id){
	if(confirm('是否要要执行此操作？')){
		$.get('goods.php',{action:'del',id:id},function(data){
			if(data=='ok'){
				$('#r_'+id).fadeOut();
			} else {
				alert('删除失败！');
			}
		});
	}
}
</script>