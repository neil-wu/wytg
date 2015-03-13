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
require_once 'header.php';?>

<div class="wy_container margin_top15">
    <p class="local_addr gray">当前位置：<a class="blue" href="/user">账户中心</a> › <a class="blue" href="/cards">卡密库存</a> › <a class="blue" href="/cards/add">添加卡密</a></p>
				    <form name="cate" class="niceform" method="post" onsubmit="return checkform()" enctype="multipart/form-data" action="/cards/addsave">
				    <table class="table_box">
                        <tr><td colspan="2"></td></tr>
					    <tr>
						<td width="90" class="text_right">商品名称:</td>
						<td>
						<select name="goodid">
						<option value="">请选择商品</option>
						<?php 
						if($goodList):
						foreach($goodList as $key=>$val):
						?>
						<option value="<?php echo $val['tb_goodid'] ?>" <?php echo $val['tb_goodid']==$goodid ? 'selected' : '' ?>><?php echo $val['tb_title'] ?></option>
						<?php
						endforeach;
						endif;
						?>
						</select>
						</td>
						</tr>

						<tr><td></td><td height="30" style="font-size:14px;font-weight:bold;color:#ff0000">卡密格式：卡号+空格+密码，一行一张卡，如：A1B2C3D4F5E8 9876543210</td></tr>

						<tr>
						<td class="text_right">添加方式:</td>
						<td>
						    <input type="radio" name="importfrom" value="1" onclick="selecttype(1)" id="r1" /> <label for="r1">使用TXT文件导入</label>
							&nbsp;&nbsp;
							<input type="radio" name="importfrom" value="2" onclick="selecttype(2)"  id="r2" checked /> <label for="r2">使用输入框添加</label>
						</td>
						</tr>

						<tr>
						<td class="text_right">卡密内容:</td>
						<td>
					        <div id="addtype_r1" style="display:none">
							<input type="file" name="f" class="input">
							<div class="blue">注意：上传的TXT文件最大100KB</div>
							</div>

						    <div id="addtype_r2">
							<textarea class="t_a_t" name="content" style="border:1px solid #ccc" cols="90" rows="23"></textarea>
							</div>
						</td>
						</tr>

						<tr>
						<td class="text_right">注意事项:</td>
						<td style="color:blue">输入框添加卡密最多一次添加500张(500行)，TXT文件上传最多支持100KB。</td>
						</tr>

						<tr>
						<td class="text_right"></td>
						<td height="30"><input type="checkbox" name="is_check_repeat" id="is_check_repeat" value="1"><label for="is_check_repeat"><span class="bold" style="color:#770000;"> 检查重复的卡密(选中后表示重复的卡密将不会加入库存中)</span> </label></td>
						</tr>

						<tr>
						<td class="bold text_right"></td>
						<td><input type="submit" class="btn btn-lg" value="添加卡密" /></td>
						</tr>
                        <tr><td colspan="2"></td></tr>
					</table>
					</form>

				<script>
				    var selecttype=function(t){
						if(t==1){
						    $('#addtype_r1').css({'display':'block'});
							$('#addtype_r2').css({'display':'none'});
						} else {
						    $('#addtype_r2').css({'display':'block'});
							$('#addtype_r1').css({'display':'none'});
						}
					};

					var checkform=function(){
						var goodid=$('[name=goodid]').val();
						if(goodid==''){
						    alert('请选择商品名称');
							$('[name=goodid]').focus();
							return false;
						};
						var msg=true;
						$('[type=radio]').each(function(){
						    if($(this).attr('checked')){
							    var id=$(this).attr('id');
								if(id=='r1'){
								    var file=$('[name=filefrom]').val();
									if(file==''){
									    alert('请选择要上传的TXT文件！');
										$('[name=filefrom]').focus();
										msg=false;
									}
								} else if(id=='r2'){
								    var text=$.trim($('[name=content]').val());
									if(text==''){
									    alert('请填写卡密内容！');
										$('[name=content]').focus();
										msg=false;
									}
								}
							}
						});
						return msg;
					};
					</script>
</div>

<?php require_once 'footer.php'; ?>