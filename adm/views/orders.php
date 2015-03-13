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

发货状态：<select name="state">
<option value="-1" <?php if($state==-1) echo 'selected'; ?>>全部</option>
<option value="0" <?php if($state==0) echo 'selected'; ?>>未发货</option>
<option value="1" <?php if($state==1) echo 'selected'; ?>>已发货</option>
</select>&nbsp;

订单状态：<select name="status">
<option value="" <?php if($status=='') echo 'selected'; ?>>全部</option>
<?php
$AllStatus=TB::GetStatus();
foreach($AllStatus as $key=>$val):
?>
    <option value="<?php echo $key?>" <?php if($status==$key) echo 'selected'; ?>><?php echo $val?></option>
<?php endforeach;?>
</select>

<input type="text" class="input" size="20" name="kwd" value="<?php echo $kwd ?>" /> 

<input type="submit"  class="btn3" value="查询订单" />
<input type="button" onclick="Boxy.load('?action=deldata&fdate=<?php echo $fdate ?>&tdate=<?php echo $tdate ?>&status=<?php echo $status ?>&state=<?php echo $state ?>&kwd=<?php echo $kwd ?>',{title:'清除订单记录'})"  class="btn1" value="清除订单" />&nbsp;

<input type="hidden" name="do" value="search" />
</form>
<!--####信息列表####-->
<table class="table_base table_list margin-top15">
<tr>
<th>选择</th>
<th>商户名称</th>
<th width="190">商品名称</th>
<th>买家旺旺</th>
<th>订单号</th>
<th>订单日期</th>
<th>订单金额</th>
<th>实际付款</th>
<th>订单状态</th>
<th>发货状态</th>
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
<?php if($row['is_state']==1): ?>
    <a <?php echo $row['is_state'] ? 'class="blue"' : '' ?> href="javascript:void(0)" onclick="Boxy.load('?action=getgoodinfo&orderid=<?php echo $row['tb_orderid'] ?>',{title:'<?php echo $row['goodname'] ?>'})"><?php echo $row['goodname'] ?></a>
    
<?php else: ?>
    <span class="gray"><?php echo $row['goodname'] ?></span>
<?php endif; ?>

(<span class="red"><?php echo $row['tb_quantity'] ?></span>张)</td>

<td><a class="line green" target="_blank" href="http://amos1.taobao.com/msg.ww?v=1&uid=<?php echo $row['buyer_nick'] ?>&s=1"><?php echo $row['buyer_nick'] ?></a></td>

<td><?php echo $row['tb_orderid'] ?></td>

<td><?php echo $row['addtime'] ?></td>

<td><?php echo $row['tb_price'] ?></td>
<td><span class="green"><?php echo $row['tb_paymoney'] ?></span> 元</td>

<td><?php echo $row['tb_status'] ?></td>

<td><?php echo $row['is_state'] ? '<span class="green">已发货</span>' : '未发货' ?></td>

<td width="80">

	<a class="line blue" href="users.php?action=loginusercenter&id=<?php echo $row['userid'] ?>" target="_blank" title="登录到<?php echo $row['username'] ?>的商户中心">登录</a>&nbsp;

	<a class="line red" href="javascript:void(0)" onclick="delData(<?php echo $row['id'] ?>)" title="删除此订单">删除</a>&nbsp;
</td>
</tr>

<?php
endforeach;
?>

<tr><td colspan="11" class="padding_top_bottom_5 whitebg left">
<input type="button" class="btn3" value="全选" id="selectall" />
<input type="button" class="btn2" value="反选" id="unselectall" />
<input type="submit" class="btn1" value="删除" onclick="if(!confirm('是否要执行 删除 操作？'))return false" />
</td>
</tr>
<tr><td colspan="11" class="h30 graybg"><?php echo $pagelist ?></td></tr>
</form>
<?php endif; ?>
</table>
</div>

<script>
function freeze(orderid,t){
    if(confirm('是否要执行此操作？')){

		$.get('orders.php',{action:'freeze',orderid:orderid,is_freeze:t},function(data){
		    if(data=='ok'){
				if(t==0){
					$('a#freeze'+orderid).attr('href','javascript:freeze("'+orderid+'",1)');
					$('a#freeze'+orderid).html('<span class="red">恢复</span>');
				} else {
					$('a#freeze'+orderid).html('<span class="gray">冻结</span>');
					$('a#freeze'+orderid).attr('href','javascript:freeze("'+orderid+'",0)');		    
				}			    
			} else {
			    alert(data);
			}
		})
	}
};

var ShowOrderDetail=function(id){
	showOptions();	
	$.get('orders.php',{action:'detail' , id:id},function(data){		
		$('#showcontent').html(data);
	});
};

var delData=function(id){
	if(confirm('是否要移除此订单？')){
		$.get('orders.php',{action:'del',id:id},function(data){
			if(data=='ok'){
				$('#r_'+id).fadeOut();
			} else {
				alert('订单移除失败！');
			}
		});
	}
};

var refoundData=function(orderid){
	if(confirm('是否要执行退款操作？')){
		$.get('orders.php',{action:'refound',orderid:orderid},function(data){
			if(data=='ok'){
				$('#refound_'+orderid).hide();
				$('#restore_'+orderid).show();
				$('#is_status_'+orderid).html('<span class="red">已退款</span>');
			} else {
				alert('退款失败！');
			}
		});
	}
};

var restoreData=function(orderid){
	if(confirm('是否要恢复退款操作？')){
		$.get('orders.php',{action:'restore',orderid:orderid},function(data){
			if(data=='ok'){
				$('#refound_'+orderid).show();
				$('#restore_'+orderid).hide();
				$('#is_status_'+orderid).html('<span class="blue">已付款</span>');
			} else {
				alert('恢复退款失败！');
			}
		});
	}
};

function user_status_menu(id){
	$('td ul').hide();
	$('#user_status_'+id).addClass('usms');
	$('#user_status_'+id).show();
	var doc_width=$(window).width();
	var ul_width=$('#user_status_'+id).width()+20;
	var left_width=(doc_width-ul_width);
	$('#user_status_'+id).css({'left':left_width});

};

$(window).resize(function(){
	$('td ul').each(function(){
		if($(this).hasClass('usms')){
			var ob=$(this).attr('id');
			var doc_width=$(window).width();
			var ul_width=$('#'+ob).width()+20;
			var left_width=(doc_width-ul_width);
			$('#'+ob).css({'left':left_width});
		}
	});
});
</script>

<script>
function copyToClipboard(txt) {   
     if(window.clipboardData) {    
             window.clipboardData.clearData();    
             window.clipboardData.setData("Text", txt);  
			 alert("成功复制到剪贴板！");
     } else if(navigator.userAgent.indexOf("Opera") != -1) {   
          window.location = txt;    
     } else if (window.netscape) {    
          try {    
               netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");    
          } catch (e) {    
               alert("被浏览器拒绝！\n请在浏览器地址栏输入'about:config'并回车\n然后将'signed.applets.codebase_principal_support'设置为'true'");    
          }    

          var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);   
          if (!clip)    
               return;    
          var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable); 
          if (!trans)    
               return;   
          trans.addDataFlavor('text/unicode');    
          var str = new Object();    
          var len = new Object();    
          var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);   
          var copytext = txt;    
          str.data = copytext;    
          trans.setTransferData("text/unicode",str,copytext.length*2);    
          var clipid = Components.interfaces.nsIClipboard; 
          if (!clip)    
               return false;    
          clip.setData(trans,null,clipid.kGlobalClipboard);    
          alert("成功复制到剪贴板！"); 
     }
};

var ctxt = "";
function cpcards(){
	copyToClipboard(ctxt);
};
</script>