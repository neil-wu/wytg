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
<div style="padding:10px;width:350px">
    <table class="tablelistinfo">
	<tr>
	<td class="right bg" width="70">商户编号：</td>
	<td><?php echo $data['id'] ?></td>
	</tr>
	<tr>
	<td class="right bg">登录账号：</td>
	<td class="bold"><?php echo $data['username'] ?></td>
	</tr>
	<tr>
	<td class="right bg">联系手机：</td>
	<td><?php echo $data['tel'] ?></td>
	</tr>
	<tr>
	<td class="right bg">联系 QQ：</td>
	<td><?php echo $data['qq'] ?> <a target="blank" href="tencent://message/?uin=<?php echo $data['qq'] ?>&Site=&Menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=1:<?php echo $data['qq'] ?>:41" alt="点击这里给我发消息" align="absmiddle"></a></td>
	</tr>
	<tr>
	<td class="right bg">电子邮箱：</td>
	<td><?php echo $data['email'] ?></td>
	</tr>
	<tr>
	<td class="right bg">站点名称：</td>
	<td><?php echo $data['sitename'] ?></td>
	</tr>
	<tr>
	<td class="right bg">站点网址：</td>
	<td><a href="http://<?php echo $data['siteurl'] ?>" target="_blank"><?php echo $data['siteurl'] ?></a></td>
	</tr>
</div>