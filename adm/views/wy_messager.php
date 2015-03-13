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
<div id="main_content" style="padding:50px 0;text-align:center;font-size:14px">
<img src="/static/adm/images/<?php echo !isset($img) ? 'error' : 'success' ?>.gif" align="absmiddle" /> <?php echo isset($msg) && $msg ? $msg : '呼呼，要访问的页面似乎不见了。' ?>

<p style="font-size:12px;margin-top:20px"><a href="<?php echo isset($url) && $url ? $url : './' ?>">如果3秒后没有跳转，请点击这里继续！</a></p>
</div>
<script>
var JumpUrl=function(){
	window.location.href='<?php echo isset($url) && $url ? $url : './' ?>';
};
$(function(){setTimeout(JumpUrl,3000);})
</script>