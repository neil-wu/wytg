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
.logo{text-align:center;margin-bottom:20px;}
</style>
<div id="main">
    
    <div class="box">
        <h2>Welcome</h2>
        <div class="content">
            <div class="logo"><img src="/static/tpl/default/images/wytg.png" width="80" height="80" alt="<?php echo $this->config['sitename']?>"></div>
            要使用此服务，请登录<a class="line blue" href="http://container.api.taobao.com/container?appkey=23058761">淘宝服务市场</a>。
        </div>
    </div>   
</div>
<?php require_once 'footer.php'; ?>