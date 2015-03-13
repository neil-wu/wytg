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
<p class="local_addr gray">当前位置：<a class="blue" href="/user">账户中心</a> › <a class="blue" href="/goods">商品列表</a> › <a class="blue" href="/goods/add">增加商品</a></p>
        <form id="set" method="post" action="/goods/addsave">
            
            <table class="table_box">
                <tr><td colspan="2"></td></tr>
                <tr>
                    <td width="90" class="text_right">选择商品：</td>
                    <td>
                        <select name="goodid">
                           <?php if($data):?>
                               <?php foreach($data as $key=>$val):?>
                                   <option value="<?php echo $val['num_iid']?>"><?php echo $val['title']?>(<?php echo $val['price']?>)</option>
                               <?php endforeach;?>
                           <?php endif;?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td  class="text_right">发货类型：</td>
                    <td><label><input type="radio" name="is_card" value="0"> 自动发货</label> <label><input checked type="radio" name="is_card" value="1"> 非自动发货(使用通知引导)</label></td>
                </tr>
                
                <tr class="tr_remark">
                    <td  class="text_right" valign="top">引导内容：</td>
                    <td><textarea class="t_a_t" name="remark" cols="90" rows="10" placeholder="感谢您购买我们的商品和服务，请尽快联系我们的客服。"></textarea></td>
                </tr>
                
                <tr>
                    <td class="text_right">发货方式：</td>
                    <td><label><input type="checkbox" name="gettype[]" value="1"> 淘宝邮箱</label> <label><input type="checkbox" name="gettype[]" value="2"> 支付宝邮箱</label> <label><input type="checkbox" name="gettype[]" value="3"> 留言中的邮箱(留言只能填写一个邮箱)</label> <label><input type="checkbox" name="gettype[]" value="4" checked> 买家自己领取</label></td>
                </tr>
                
                <tr>
                    <td  class="text_right">内容模板：</td>
                    <td><select name="tplid">
                        <?php if($tplinfo):?>
                            <?php foreach($tplinfo as $key=>$val):?>
                                <option value="<?php echo $val['id'] ?>"><?php echo $val['name'] ?></option>
                            <?php endforeach;?>
                        <?php endif;?>
                    </select></td>
                </tr>
                
                <tr>
                    <td  class="text_right">商品状态：</td>
                    <td>
                        <select name="is_state">
                            <option value="0">上架</option>
                            <option value="1">下架</option>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td></td>
                    <td><input type="submit" class="btn btn-lg" value="保存设置"></td>
                </tr>
                <tr><td colspan="2"></td></tr>
            </table>
        </form>

</div>
<script>
$(function(){
    $('textarea').placeholder();
    $('[type=submit]').click(function(){
        if($('[name=is_card]:checked').val()==1){
            if($.trim($('[name=remark]').val())==''){
                alert('您选择了非自动发货，请填写引导内容。');
                $('[name=remark]').focus();
                return false;
            }
        } 
    });
});
</script>
<?php require_once 'footer.php'; ?>