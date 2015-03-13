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
#main{width:650px;margin:auto}
.box{border:1px solid #e8e8e8;border-radius:3px;padding:1px;background-color:#fff;text-align:center;box-shadow:0px 0px 10px #ccc;}
h2{padding-left:15px;text-align:left;font-size:14px;color:#666;height:40px;line-height:40px;text-shadow:1px 1px 4px #ccc;font-weight:100;background-color:#fafafa;border-bottom:1px solid #e8e8e8;}
.content{padding:20px;text-align:left;line-height:28px;}
h1{text-align:center;}
.content p{}
</style>
<div class="wy_container margin_top15">
    <p style="text-align:center"><a class="blue" href="/user">← 返回</a></p>
    <div id="main">
    <div class="box margin_top15">
        <h2>平台公告</h2>
        <div class="content">
        <?php if($data):?>
            <h1 class="red"><?php echo $data['title']?></h1>
            <p class="margin_top20"><?php echo $data['content']?></p>
            <p class="margin_top20 gray" style="font-size:11px;text-align:right"><?php echo $this->config['sitename']?> <?php echo $data['addtime']?></p>
        <?php endif;?>
    </div>
    </div>
</div>
</div>
<?php require_once 'footer.php'; ?>