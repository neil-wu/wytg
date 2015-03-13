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
<style>
#main{width:650px;margin:auto;margin-top:120px;}
.box{border:1px solid #e8e8e8;border-radius:3px;padding:1px;background-color:#fff;text-align:center;box-shadow:0px 0px 10px #ccc;}
.input{border:1px solid #ccc;height:33px;line-height:33px;padding:0 10px;}
h2{padding-left:15px;text-align:left;font-size:14px;color:#666;height:40px;line-height:40px;text-shadow:1px 1px 4px #ccc;font-weight:100;background-color:#fafafa;border-bottom:1px solid #e8e8e8;}
.content{padding:20px;}
.hide{display:none;}
.input-red{border-color:red;}
</style>
<div id="main">
    
    <div class="box">
        <h2>领取卡密商品</h2>
        <div class="content">
            <input class="input" type="text" name="nick" id="nick" maxlength="30" placeholder="淘宝旺旺号">&nbsp;&nbsp;<input class="input" type="text" name"orderid" id="orderid" maxlength="20" placeholder="淘宝订单号">&nbsp;&nbsp;<input class="input" type="text" name"chkcode" id="chkcode" size="9" maxlength="5" placeholder="验证码">&nbsp;<img src="/chkcode" id="getchkcode" onclick="javascript:this.src=this.src+'?t=new Date().getTime()';" align="absmiddle">&nbsp;&nbsp;<input type="submit" class="btn btn-lg" value="立即领取">
        </div>
    </div>
    <br>
    <br>
    <div class="result box hide">
        <h2>卡密商品信息</h2>
        <div class="content goods">
            
        </div>
    </div>
</div>
<script>
$(function(){
    $('input, textarea').placeholder();
    $('.btn').click(function(){
        $('.input').removeClass('input-red');
        var nick=$.trim($('#nick').val());
        var orderid=$.trim($('#orderid').val());
        var chkcode=$.trim($('#chkcode').val());

        if(nick==''){
            $('#nick').addClass('input-red');
            return false;
        }
        if(orderid==''){
            $('#orderid').addClass('input-red');
            return false;
        }
        var reg=/^([0-9a-zA-Z]+){5}$/;
        if(chkcode=='' || !reg.test(chkcode)){
            $('#chkcode').addClass('input-red');
            return false;
        }
        
        $('.input').val('');
        $('#getchkcode').attr('src','/chkcode?t='+new Date().getTime());
        $('.result').show();
        $('.goods').html('<img src="/static/tpl/default/images/ajaxLoader.gif" align="absmiddle"> 正在处理...');
        $.post('/get/search/<?php echo $token?>',{nick:nick,orderid:orderid,chkcode:chkcode},function(data){
            if(data){
                $('.goods').html(data);
            }
            
        });
    });
});
</script>
<?php require_once 'footer.php'; ?>