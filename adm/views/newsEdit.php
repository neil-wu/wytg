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
<style>
.block{display:inline-block;height:20px;width:20px;line-height:20px;text-align:center;background-color:#f1f1f1;border:1px solid #ccc;border-radius:2px;margin-left:5px;cursor:pointer}
#colors{width:88px;background-color:#f1f1f1;border:1px solid #ccc;border-radius:2px;padding:5px;position:absolute;margin-top:5px;margin-left:-40px;display:none;}
#colors a{display:inline-block;width:15px;height:15px;margin:2px;}
#is_color{background-color:#<?php echo $is_color ?>}
#is_bold{font-weight:<?php echo $is_bold ? 'bold' : '100' ?>}
</style>
<!--[if IE]>
<style>
#colors{margin-top:20px}
</style>
<![endif]-->
<script charset="utf-8" src="views/editor4/kindeditor-min.js"></script>
<script charset="utf-8" src="views/editor4/lang/zh_CN.js"></script>
		<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name="contenttext"]', {
					allowFileManager : false
				});
			});
		</script>
<div id="main_content">
<form name="add" method="post" action="?action=editsave&id=<?php echo $id ?>">
<table class="register">
<tr>
<td width="100" class="right">文章分类</td>
<td>
<select name="classid">
<?php
if($newsClass):
foreach($newsClass as $key => $val):
?>
<option value="<?php echo $val['id'] ?>" <?php echo $val['id']==$classid ? 'selected' : '' ?>><?php echo $val['classname'] ?></option>
<?php
endforeach;
endif;
?>
</select>
</td>
</tr>

<tr>
<td class="right">文章标题</td>
<td><input type="text" class="input" style="font-weight:<?php echo $is_bold ? 'bold' : '100' ?>;color:#<?php echo $is_color ?>" name="title" size="100" maxlength="90" value="<?php echo $title ?>" /><span class="block<?php echo $is_bold ? ' checked' : '' ?>" id="is_bold">B</span><span class="block" id="is_color">C<div id="colors">
<?php $colors=Options::getTitleColor();foreach($colors as $color): ?>
<a href="javascript:;" id="<?php echo $color ?>" style="background-color:#<?php echo $color ?>" title="#<?php echo $color ?>"></a>
<?php endforeach; ?>
</div></span></td>
</tr>

<tr>
<td class="right">添加日期</td>
<td><input type="text" class="input" name="addtime" size="100" maxlength="20" value="<?php echo $addtime ?>" /></td>
</tr>

<tr>
<td class="right">文章内容</td>
<td><textarea name="contenttext" style="width:700px;height:300px;visibility:hidden;"><?php echo $content ?></textarea></td>
</tr>

<tr>
<td class="right"></td>
<td>
<input type="checkbox" name="is_popup" value="1" <?php echo $is_popup==1 ? 'checked' : '' ?> id="c1" /> <label for="c1">允许动弹出此文章</label>
<input type="checkbox" name="is_display_home" value="1" <?php echo $is_display_home==1 ? 'checked' : '' ?> id="c2" /> <label for="c2">允许显示在首页</label>
</td>
</tr>

<tr>
<td class="right"></td>
<td><input type="submit" class="btn1" onclick="add()" value="保存文章" /></td>
</tr>
</table>
<input type="hidden" name="is_bold" value="<?php echo $is_bold ?>">
<input type="hidden" name="is_color" value="<?php echo $is_color ?>">
</form>
</div>

<script>
$('[type=submit]').click(function(){
	var $title=$.trim($('[name=title]').val());
	if($title==''){
		alert('公告标题不能为空！');
		$('[name=title]').focus();
		return false;
		}
	});
	
$(function(){
    $('#is_bold').click(function(){
		if($(this).hasClass('checked')){
			$('[name=title]').css({'font-weight':'100'});
			$(this).css({'font-weight':'100'});
			$(this).removeClass('checked');
			$('[name=is_bold]').val('');
		} else {
			$('[name=title]').css({'font-weight':'bold'});
			$(this).css({'font-weight':'bold'});
			$(this).addClass('checked');
			$('[name=is_bold]').val('bold');
		}
    });

	$('#is_color').click(function(){
	    $('#colors').show();
	});
	
	$('#colors a').click(function(){
		var color=$(this).attr('id');
	    $('[name=title]').css({'color':'#'+color});
		$('#is_color').css({'background-color':'#'+color});
		$('[name=is_color]').val(color);
	});
	
	$(document).mouseup(function(){
	    $('#colors').hide();
	});
});
</script>