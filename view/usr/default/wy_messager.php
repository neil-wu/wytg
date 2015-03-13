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
require_once 'header.php'; ?>
<div class="wy_container margin_top15">
<p class="local_addr gray">当前位置：<a class="blue" href="/user">账户中心</a> › <a class="blue" href="<?php echo isset($url) && $url ? $url : '/user' ?>">跳转提示</a></p>
<div class="main margin_top15" style="padding:50px 0;border:1px solid #e8e8e8">
<table style="width:60%;margin:auto">
<tr>
<td style="text-align:center;line-height:22px"><img src="/static/usr/default/images/<?php echo !isset($img) || $img=='' ? 'success' : $img ?>.gif" align="absmiddle" /> <?php echo isset($msg) && $msg ? $msg : '呼呼，要访问的页面似乎不见了。' ?></td>
</tr>
<tr>
<td><p style="font-size:12px;text-align:center;margin-top:20px;"><a href="<?php echo isset($url) && $url ? $url : '/user' ?>">如果3秒后没有跳转，请点击这里继续！</a></p></td>
</tr>
</table>
</div>
</div>
<script>
var JumpUrl=function(){
	window.location.href='<?php echo isset($url) && $url ? $url : '/user' ?>';
};
$(function(){setTimeout(JumpUrl,3000);});
</script>
<?php require_once 'footer.php'; ?>