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
    <?php if($t=='userLogs'): ?>
	<form name="form1" method="post" action="?action=exedeldata">
	<input type="hidden" name="username" value="<?php echo $username ?>">
    <table class="tablelistinfo">
	<tr>
	<td class="right bg" width="70">登录用户：</td>
	<td><?php echo $username ? $username : '全部' ?></td>
	</tr>
	<tr>
	<td class="right bg">时间范围：</td>
	<td><input type="text" name="fdate" class="input" id="txtDate" onclick="SelectDate(this)" size="12" readonly="readonly" value="<?php echo $fdate ?>" />&nbsp;
至 <input type="text" name="tdate" class="input" id="txtDate1" onclick="SelectDate(this)" size="12" readonly="readonly" value="<?php echo $tdate ?>" /></td>
	</tr>
	<tr>
	<td class="right bg"></td>
	<td><input type="submit" class="btn1" onclick="if(confirm('是否要执行此操作？')){form1.submit();}else{return false;}" value="清除记录" /></td>
	</tr>
	</table>
	</form>

    <?php elseif($t=='adminlogs'): ?>
	<form name="form1" method="post" action="?action=exedeldatalogs">
	<input type="hidden" name="username" value="<?php echo $username ?>">
    <table class="tablelistinfo">
	<tr>
	<td class="right bg" width="70">登录用户：</td>
	<td><?php echo $username ? $username : '全部' ?></td>
	</tr>
	<tr>
	<td class="right bg">时间范围：</td>
	<td><input type="text" name="fdate" class="input" id="txtDate" onclick="SelectDate(this)" size="12" readonly="readonly" value="<?php echo $fdate ?>" />&nbsp;
至 <input type="text" name="tdate" class="input" id="txtDate1" onclick="SelectDate(this)" size="12" readonly="readonly" value="<?php echo $tdate ?>" /></td>
	</tr>
	<tr>
	<td class="right bg"></td>
	<td><input type="submit" class="btn1" onclick="if(confirm('是否要执行此操作？')){form1.submit();}else{return false;}" value="清除记录" /></td>
	</tr>
	</table>
	</form>

	<?php elseif($t=='users'): ?>
	<form name="form1" method="post" action="?action=exedeldata">
    <table class="tablelistinfo">
	<tr>
	<td class="right bg">选择条件：</td>
	<td>清除最近<select name="day">
	    <option value="15">15天</option>
		<option value="30" selected>30天</option>
		<option value="60">60天</option>
		<option value="90">90天</option>
		<option value="180">180天</option>
	</select>未登录的商户</td>
	</tr>
	<tr>
	<td class="right bg"></td>
	<td><input type="submit" class="btn1" onclick="if(confirm('是否要执行此操作？')){form1.submit();}else{return false;}" value="清除记录" /></td>
	</tr>
	</table>
	</form>

    <?php elseif($t=='orders'): ?>
	<form name="form1" method="post" action="?action=exedeldata">
    <table class="tablelistinfo">
	<tr>
	<td class="right bg" width="70">时间范围：</td>
	<td><input type="text" name="fdate" class="input" id="txtDate" onclick="SelectDate(this)" size="12" readonly="readonly" value="<?php echo $fdate ?>" />&nbsp;
至 <input type="text" name="tdate" class="input" id="txtDate1" onclick="SelectDate(this)" size="12" readonly="readonly" value="<?php echo $tdate ?>" /></td>
	</tr>
	<tr>
	<td class="right bg">发货状态：</td>
	<td>
        <select name="state">
            <option value="-1" <?php if($state==-1) echo 'selected'; ?>>全部</option>
            <option value="0" <?php if($state==0) echo 'selected'; ?>>未发货</option>
            <option value="1" <?php if($state==1) echo 'selected'; ?>>已发货</option>
        </select>
    </td>
	</tr>
	<tr>
	<td class="right bg">订单状态：</td>
	<td>
<select name="status">
<option value="" <?php if($status=='') echo 'selected'; ?>>全部</option>
<?php
$AllStatus=TB::GetStatus();
foreach($AllStatus as $key=>$val):
?>
    <option value="<?php echo $key?>" <?php if($status==$key) echo 'selected'; ?>><?php echo $val?></option>
<?php endforeach;?>
</select>
    </td>
	</tr>
	<tr>
	<td class="right bg">关键字：</td>
	<td>
		<input type="text" class="input" size="20" name="kwd" value="<?php echo $kwd ?>" /> 
    </td>
	</tr>
	<tr>
	<td class="right bg"></td>
	<td><input type="submit" class="btn1" onclick="if(confirm('是否要执行此操作？')){form1.submit();}else{return false;}" value="清除记录" /></td>
	</tr>
	</table>
	</form>

    <?php elseif($t=='closeorders'): ?>
	<form name="form1" method="post" action="?action=closeAllData">
    <table class="tablelistinfo">
	<tr>
	<td class="right bg" width="70">时间范围：</td>
	<td><input type="text" name="fdate" class="input" id="txtDate" onclick="SelectDate(this)" size="12" readonly="readonly" value="<?php echo $fdate ?>" />&nbsp;
至 <input type="text" name="tdate" class="input" id="txtDate1" onclick="SelectDate(this)" size="12" readonly="readonly" value="<?php echo $tdate ?>" /></td>
	</tr>
	<tr>
	<td class="right bg">支付状态：</td>
	<td>
		<select name="is_status" class="input">
		<option value="" <?php if($is_status=='') echo 'selected'; ?>>全部</option>
		<option value="s1" <?php if($is_status=='s1') echo 'selected'; ?>>未付款</option>
		<option value="s2" <?php if($is_status=='s2') echo 'selected'; ?>>部分付款</option>
		<option value="s3" <?php if($is_status=='s3') echo 'selected'; ?>>已付款</option>
		<option value="s4" <?php if($is_status=='s4') echo 'selected'; ?>>已退款</option>
		</select>
    </td>
	</tr>
	<tr>
	<td class="right bg">支付类型：</td>
	<td>
		<select name="channelid" class="input">
		<option value="">所有</option>
		<?php
		if($channels):
		foreach($channels as $key => $val):
		$selected= $val['id']==$channelid ? 'selected' : '';
		?>
		<option value="<?php echo $val['id'] ?>" <?php echo $selected ?>><?php echo $val['channelname'] ?></option>
		<?php
		endforeach;
		endif;
		?>
		</select>
    </td>
	</tr>
	<tr>
	<td class="right bg">其他条件：</td>
	<td>
		<select name="searchtype" class="input">
		<option value="t0" <?php if($searchtype=='t0') echo 'selected'; ?>>商户名</option>
		<option value="t2" <?php if($searchtype=='t2') echo 'selected'; ?>>订单号</option>
		<option value="t3" <?php if($searchtype=='t3') echo 'selected'; ?>>联系方式</option>
		<option value="t4" <?php if($searchtype=='t4') echo 'selected'; ?>>充值卡号</option>
		</select> = 
		<input type="text" class="input" size="20" name="searchtext" value="<?php echo $searchtext ?>" /> 
    </td>
	</tr>
	<tr>
	<td class="right bg"></td>
	<td><input type="submit" class="btn1" onclick="if(confirm('是否要执行此操作？')){form1.submit();}else{return false;}" value="关闭订单" /></td>
	</tr>
	</table>
	</form>

	<?php elseif($t=='users'): ?>
	<form name="form1" method="post" action="?action=exedeldata">
    <table class="tablelistinfo">
	<tr>
	<td class="right bg">选择条件：</td>
	<td>清除最近<select name="day">
	    <option value="15">15天</option>
		<option value="30" selected>30天</option>
		<option value="60">60天</option>
		<option value="90">90天</option>
		<option value="180">180天</option>
	</select>未登录的商户</td>
	</tr>
	<tr>
	<td class="right bg"></td>
	<td><input type="submit" class="btn1" onclick="if(confirm('是否要执行此操作？')){form1.submit();}else{return false;}" value="清除记录" /></td>
	</tr>
	</table>
	</form>

    <?php elseif($t=='payments'): ?>
	<form name="form1" method="post" action="?action=exedeldata">
    <table class="tablelistinfo">
	<tr>
	<td class="right bg" width="70">时间范围：</td>
	<td><input type="text" name="fdate" class="input" id="txtDate" onclick="SelectDate(this)" size="12" readonly="readonly" value="<?php echo $fdate ?>" />&nbsp;
至 <input type="text" name="tdate" class="input" id="txtDate1" onclick="SelectDate(this)" size="12" readonly="readonly" value="<?php echo $tdate ?>" /></td>
	</tr>
	<tr>
	<td class="right bg">处理状态：</td>
	<td>
		<select name="is_state" class="input">
		<option value="" <?php if($is_state=='') echo 'selected'; ?>>所有</option>
		<option value="s0" <?php if($is_state=='s0') echo 'selected'; ?>>待处理</option>
		<option value="s1" <?php if($is_state=='s1') echo 'selected'; ?>>成功</option>
		<option value="s2" <?php if($is_state=='s2') echo 'selected'; ?>>已取消</option>
		</select>
    </td>
	</tr>
	<tr>
	<td class="right bg">结算类型：</td>
	<td>
		<select name="paycid" class="input">
			<option value="" <?php if($paycid=='') echo 'selected'; ?>>所有</option>
			<option value="t1" <?php if($paycid=='t1') echo 'selected'; ?>>平台结算</option>
			<option value="t2" <?php if($paycid=='t2') echo 'selected'; ?>>商户提款</option>
		</select>
    </td>
	</tr>
	<tr>
	<td class="right bg">商户名称：</td>
	<td><input type="text" class="input" size="20" name="username" value="<?php echo $username ?>" /></td>
	</tr>
	<tr>
	<td class="right bg"></td>
	<td><input type="submit" class="btn1" onclick="if(confirm('是否要执行此操作？')){form1.submit();}else{return false;}" value="清除记录" /></td>
	</tr>
	</table>
	</form>

	<?php endif; ?>
</div>