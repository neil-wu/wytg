<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

if(!defined('WY_ROOT')) exit;
if(_G('op_suc')) echo '<div class="actived">配置成功！</div>';
?>

<div id="main_content">
<form name="add" method="post" onsubmit="return checkForm()" action="?action=save">
<div class="options">
    <a href="javascript:void(0)" id="set01" class="current">基本设置</a>&nbsp;
	<a href="javascript:void(0)" id="set03">联系方式</a>&nbsp;
	<a href="javascript:void(0)" id="set05">邮件服务</a>&nbsp;
</div>

<table class="tableset" id="dis_set01">
<tr>
<td width="120" class="right">站点名称</td>
<td><input type="text" class="input" name="config[sitename]" id="sitename" size="60" value="<?php echo isset($sitename) ? $sitename : '' ?>"></td>
</tr>
<tr>
<td width="120" class="right">标题说明</td>
<td><input type="text" class="input" name="config[sitetitle]" id="sitetitle" size="60" value="<?php echo isset($sitetitle) ? $sitetitle : '' ?>"></td>
</tr>
<tr>
<td class="right">站点URL</td>
<td><input type="text" class="input" name="config[siteurl]" id="siteurl" size="60" value="<?php echo isset($siteurl) ? $siteurl : '' ?>"></td>
</tr>
<tr>
<td class="right">StaticUrl</td>
<td><input type="text" class="input" name="config[staticurl]" id="staticurl" size="60" value="<?php echo isset($staticurl) ? $staticurl : '' ?>"></td>
</tr>
<tr>
<td class="right">关键字</td>
<td><input type="text" class="input" name="config[keyword]" id="keyword" size="60" value="<?php echo isset($keyword) ? $keyword : '' ?>"></td>
</tr>
<tr>
<td class="right">站点简介</td>
<td><textarea name="config[description]" id="description" cols="58" rows="3"><?php echo isset($description) ? $description : '' ?></textarea></td>
</tr>


<tr>
<td class="right">站点开关</td>
<td>
<select name="config[sitestate]">
<option value="0" <?php if(isset($sitestate) && $sitestate=='0') echo "selected" ?>>站点开启</option>
<option value="1" <?php if(isset($sitestate) && $sitestate=='1') echo "selected" ?>>站点关闭</option>
</select> 
</td>
</tr>

<tr>
<td class="right">站点关闭提示</td>
<td><textarea name="config[msgtip]" id="msgtip" cols="58" rows="3" ><?php echo isset($msgtip) ? $msgtip : '' ?></textarea></td>
</tr>

<tr>
<td class="right">统计代码</td>
<td><textarea name="config[tongji]" id="tongji" cols="58" rows="3" ><?php echo isset($tongji) ? stripslashes($tongji) : '' ?></textarea></td>
</tr>
</table>


<table class="tableset" id="dis_set03" style="display:none">
<tr>
<td width="120" class="right">客服电话</td>
<td><input type="text" class="input" name="config[tel]" size="60" value="<?php echo isset($tel) ? $tel :'' ?>"></td>
</tr>
<tr>
<td class="right">客服QQ</td>
<td><input type="text" class="input" name="config[qq]" size="60" value="<?php echo isset($qq) ? $qq :'' ?>"></td>
</tr>
<tr>
<td class="right">联系地址</td>
<td><input type="text" class="input" name="config[address]" size="60" value="<?php echo isset($address) ? $address :'' ?>"></td>
</tr>
<tr>
<td class="right">客服邮箱</td>
<td><input type="text" class="input" name="config[servicemail]" size="60" value="<?php echo isset($servicemail) ? $servicemail :'' ?>"></td>
</tr>
<tr>
<td class="right">版权信息</td>
<td><input type="text" class="input" name="config[copyright]" size="60" value="<?php echo isset($copyright) ? $copyright : '' ?>"></td>
</tr>

<tr>
<td class="right">备案号码</td>
<td><input type="text" class="input" name="config[icp]" size="60" maxlength="20" value="<?php echo isset($icp) ? $icp : '' ?>"></td>
</tr>

</table>

<table class="tableset" id="dis_set05" style="display:none">
<tr>
<td width="120" class="right">SMTP服务器</td>
<td><input type="text" class="input" name="config[smtp]" size="60" maxlength="50" value="<?php echo isset($smtp) ? $smtp : '' ?>"></td>
</tr>
<tr>
<td class="right">邮箱账号</td>
<td><input type="text" class="input" name="config[email]" size="60" maxlength="50" autocomplete="off" value="<?php echo isset($email) ? $email : '' ?>"></td>
</tr>
<tr>
<td class="right">邮箱账号密码</td>
<td><input type="password" class="input" name="config[authkey]" size="60" maxlength="50" autocomplete="off" value="<?php echo isset($authkey) ? $authkey : '' ?>"></td>
</tr>
</table>

<table>
<tr>
<td width="120" height="15"></td>
<td></td>
</tr>
<tr>
<td class="right"></td>
<td style="padding-left:20px"><input type="submit" name="submit" class="btn1" value="保存设置" /></td>
</tr>
</table>
<input type="hidden" name="action" value="save" />
</form>
</div>

<script>
setTimeout(hideMsg,2600);

$('.options a').each(function(){
    $(this).click(function(){
		$('.options a').removeClass('current');
		$(this).addClass('current');
	    var cname=$(this).attr('id');
		$('table.tableset').hide();
		$('#dis_'+cname).show();
		$.cookie('set_options',cname,{expires:365})
	});
	var cname=$(this).attr('id');
	if($.cookie('set_options')==cname){
		$('.options a').removeClass('current');
		$(this).addClass('current');
	    var cname=$(this).attr('id');
		$('table.tableset').hide();
		$('#dis_'+cname).show();
	};
});

function checkForm(){
    var sitename=$('#sitename').val();
	if(sitename==''){
	    alert('站点名称不能为空！');
		$('#sitename').focus();
		return false;
	};

	if(sitename.length>=90){
	    alert('站点名称最多90个字符！');
		$('#sitename').focus();
		return false;
	};

    var sitetitle=$('#sitetitle').val();
	if(sitetitle!='' && sitetitle.length>=90){
	    alert('站点标题说明最多90个字符！');
		$('#sitetitle').focus();
		return false;
	};

    var siteurl=$('#siteurl').val();
	if(siteurl==''){
	    alert('站点URL不能为空！');
		$('#siteurl').focus();
		return false;
	};

	if(siteurl.length>=50){
	    alert('站点URL最多50个字符！');
		$('#siteurl').focus();
		return false;
	};

    var keyword=$('#keyword').val();
	if(keyword!='' && keyword.length>=100){
	    alert('站点关键字最多100个字符！');
		$('#keyword').focus();
		return false;
	};

    var description=$('#description').val();
	if(description!='' && description.length>=100){
	    alert('站点简介说明最多100个字符！');
		$('#description').focus();
		return false;
	};

    var msgtip=$('#msgtip').val();
	if(msgtip==''){
	    alert('站点关闭提示不能为空！');
		$('#msgtip').focus();
		return false;
	};

	if(msgtip.length>=400){
	    alert('站点关闭提示最多400个字符！');
		$('#msgtip').focus();
		return false;
	};

    var tongji=$('#tongji').val();
	if(tongji!='' && tongji.length>=300){
	    alert('统计代码最多300个字符！');
		$('#tongji').focus();
		return false;
	};
};
</script>