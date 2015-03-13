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
h2{padding-left:15px;text-align:left;font-size:14px;color:#666;height:40px;line-height:40px;text-shadow:1px 1px 4px #ccc;font-weight:100;background-color:#fafafa;border-bottom:1px solid #e8e8e8;}
.content{padding:20px;}
</style>
<?php if($t):?>
<div id="main">
    <div class="box">
        <h2>操作提示</h2>
        <div class="content">
            <p class="red"><img src="<?php echo $this->config['staticurl'] ?>/static/tpl/default/images/<?php echo !isset($img) ? 'error' : 'success' ?>.gif" align="absmiddle" /> <?php echo isset($msg) && $msg ? $msg : '呼呼，要访问的页面似乎不见了。' ?></p>
        </div>
    </div>
</div>

<?php else:?>
    <div id="main">
        <div class="box">
            <h2>操作提示</h2>
            <div class="content">
                <p class="red"><img src="<?php echo $this->config['staticurl'] ?>/static/tpl/default/images/<?php echo !isset($img) ? 'error' : 'success' ?>.gif" align="absmiddle" /> <?php echo isset($msg) && $msg ? $msg : '呼呼，要访问的页面似乎不见了。' ?></p>
    	        <p class="margin_top15"><a class="line blue" href="<?php echo isset($url) && $url ? $url : '/' ?>">如果<span id="times">3</span>秒后没有跳转，请点击这里继续！</a></p>
            </div>
        </div>
    </div>
    <script>
    var JumpUrl=function(){
        window.location.href='<?php echo isset($url) && $url ? $url : '/' ?>';
    };
    $(function(){
    	setTimeout(changeTimes,1000);
    });

    var changeTimes=function(){
    	if($('#times').text()==0){
    	    JumpUrl();
    		return false;
    	} else {
            $('#times').text($('#times').text()-1);
    		setTimeout(changeTimes,1000);
    	}
    };
    </script>
<?php endif;?>
<?php require_once 'footer.php'; ?>