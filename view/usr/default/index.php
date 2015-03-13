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
<style>
.data_list{width:100%;border-collapse:collapse;}
.box{border:1px solid #e8e8e8;padding:1px;}
.box h2{background-color:#fafafa;font-size:14px;font-weight:100;padding:8px 10px;border-bottom:1px solid #e8e8e8;}
.content{padding:20px;font-size:12px;color:#666;}
.content span{font-size:18px;color:#d95c5c;}
.margin{margin:auto 15px;}
.td td{height:27px;}
.td span{font-size:12px;color:#000;}
.link a{font-size:16px;}
.link a:hover{color:#000;}
</style>
<div class="wy_container margin_top20">
    <table class="data_list">
        <tr>
            <td valign="top" width="250">
                <div class="box">
                    <h2>账户信息</h2>
                    <div class="content">
                        <table class="data_list td">
                            <tr>
                                <td rowspan="6" width="90" valign="top">
                                    <img src="<?php echo $users['avatar']?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h3>欢迎您</h3>
                                </td>
                            </tr>
                        
                            <tr>
                                <td>
                                    店铺：<span><?php echo $users['shop']?></span>
                                </td>
                            </tr>
                        
                            <tr>
                                <td>
                                    账号：<span><?php echo $users['username']?></span>
                                </td>
                            </tr>
                        
                            <tr>
                                <td>
                                    到期：<span>
                                        <?php $days=(($users['expiretime']-time())/60/60/24); ?>
                                        
                                        <?php if($days>0):?>
                                            还有<?php echo intval($days) ?>天
                                        <?php elseif($days==0):?>
                                            <span class="gray">即将到期</span> <a class="line red" href="<?php echo TB::FW();?>">续费</a>
                                        <?php else:?>
                                            <a class="line red" href="<?php echo TB::FW();?>">已过期，续费</a>
                                        <?php endif;?>
                                        </span>
                                </td>
                            </tr>
                        
                            <tr>
                                <td>
                                    <a class="btn btn-sm" href="/get/<?php echo $users['usercode']?>" target="_blank"><img src="/static/usr/default/images/i03.png" width="10"> 领取卡密地址</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
            <td valign="top" width="400">
                <div class="box margin">
                    <h2>交易信息</h2>
                    <div class="content">
                        <table class="data_list">
                            <tr>
                                <td>今日交易订单：<span><?php echo $data['today_orders_total']?></span>个</td>
                                <td>今日成功订单：<span><?php echo $data['today_orders_success']?></span>个</td>
                                <td>今日卡密销售：<span><?php echo $data['today_cards_total']?></span>个</td>
                            </tr>
                            <tr>
                                <td>昨日交易订单：<span><?php echo $data['yestoday_orders_total']?></span>个</td>
                                <td>昨日成功订单：<span><?php echo $data['yestoday_orders_success']?></span>个</td>
                                <td>昨日卡密销售：<span><?php echo $data['yestoday_cards_total']?></span>个</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="box margin" style="margin-top:15px">
                    <div class="content">
                        <table class="data_list link">
                            <tr>
                                <td><a class="gray" href="/goods/add"><img src="/static/usr/default/images/i02.png" height="28" align="absmiddle"> 新增商品</a></td>
                                <td style="text-align:center"><a class="gray" href="/cards/add"><img src="/static/usr/default/images/i01.png" height="25" align="absmiddle"> 添加卡密</a></td>
                                <td style="text-align:right"><a class="gray" href="/user/set"><img src="/static/usr/default/images/i06.png" height="25" align="absmiddle"> 发信模板配置</a></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
            <td valign="top" width="250">
                <div class="box">
                    <h2>平台公告</h2>
                    <div class="content">
                        <table class="data_list">
                            <?php if($news):?>
                                <?php foreach($news as $key=>$val):?>
                                    <tr>
                                        <td height="23"><a class="line" style="color:#<?php echo $val['is_color'] ?><?php echo $val['is_bold'] ? ';font-weight:bold' : '' ?>" href="/user/view/<?php echo $val['id']?>"><?php echo $val['title']?></a></td>
                                        <td class="text_right"><?php echo $val['addtimeforuser']?></td>
                                    </tr>
                                <?php endforeach;?>
                            <?php endif;?>
                        </table>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>

<?php require_once 'footer.php'; ?>