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
    <p class="local_addr gray">当前位置：<a class="blue" href="/user">账户中心</a> › <a class="blue" href="/orders">交易订单列表</a></p>
    <div class="search_bg margin_top15">
        <form id="s" class="niceform" action="" method="get">
            按商品：
            <select name="goodid">
                <option value="">全部</option>
                <?php 
                if($goods):
                    foreach($goods as $key=>$val):
                ?>
                    <option value="<?php echo $val['tb_goodid']?>"<?php echo $search['goodid']==$val['tb_goodid'] ? ' selected' : '' ?>><?php echo $val['tb_title']?></option>
                <?php
                    endforeach;
                endif;
                ?>
            </select>&nbsp;
            
            订单状态：
            <select name="status">
                <option value="">全部</option>
                <?php $status=TB::GetStatus();foreach($status as $key=>$val): ?>
                    <option value="<?php echo $key ?>"<?php echo $search['status']==$key ? ' selected' : '' ?>><?php echo $val ?></option>
                <?php endforeach;?>
            </select>&nbsp;
            
            发货状态：
            <select name="state">
                <option value="-1"<?php echo $search['state']==-1 ? ' selected' : '' ?>>全部</option>
                <option value="0"<?php echo $search['state']==0 ? ' selected' : '' ?>>未发货</option>
                <option value="1"<?php echo $search['state']==1 ? ' selected' : '' ?>>已发货</option>
            </select>&nbsp;
            
            交易日期：
            <input type="text" name="fdate" id="txtDate" onclick="SelectDate(this)" size="12" readonly="readonly" value="<?php echo $search['fdate'] ?>" />&nbsp;
            至 <input type="text" name="tdate" id="txtDate1" onclick="SelectDate(this)" size="12" readonly="readonly" value="<?php echo $search['tdate'] ?>" />&nbsp;
            
            <input type="submit" class="btn btn-sm" value="查询">
        </form>
    </div>
    
    <table class="table">
        <thead>
            <tr class="info">
                <th>买家</th>
                <th>订单号</th>
                <th>商品名称</th>
                <th>购买数量</th>
                <th>订单金额</th>
                <th>实际付款</th>
                <th>订单状态</th>
                <th>是否发货</th>
                <th>交易日期</th>
                <th>操作</th>
            </tr>
        </thead>
        <?php if($data):?>
            <?php foreach($data as $key=>$val):?>
                <tr class="lightbox">
                    <td><a class="line green" href="<?php echo TB::IM($val['buyer_nick']); ?>" target="_blank"><?php echo $val['buyer_nick']?></a></td>
                    <td><?php echo $val['tb_orderid']?></td>
                    <td><a class="line blue" href="http://item.taobao.com/item.html?id=<?php echo $val['tb_goodid']?>"><?php echo $val['tb_title']?></a></td>
                    <td><?php echo $val['tb_quantity']?></td>
                    <td><span class="red"><?php echo $val['tb_price']?></span></td>
                    <td><span class="green"><?php echo $val['tb_paymoney']?></span></td>
                    <td><?php echo $val['tb_status']?></td>
                    <td><?php echo $val['is_state'] ? '<span class="green">已发货</span>' : '-'?></td>
                    <td><?php echo $val['tb_addtime']?></td>
                    <td id="td<?php echo $val['tb_orderid']?>">
                        <?php if($val['is_state']):?>
                            <span class="red">已发</span>
                        <?php else:?>
                            <?php if($val['tb_status']=='TRADE_FINISHED'):?>
                                <a href="javascript:;" onclick="sendGoods('<?php echo $val['tb_orderid']?>')" class="line blue">发货</a>
                            <?php else: ?>
                                -
                            <?php endif;?>
                        <?php endif;?>
                    </td>
                </tr>
            <?php endforeach;?>
            <tr><td colspan="10"><?php echo $pagelist ?></td></tr>
        <?php else:?>
            <tr><td colspan="10">no data.</td></tr>
        <?php endif; ?>

    </table>
</div>
<script>
function sendGoods(orderid){
    $.post('/orders/send',{orderid:orderid,t:new Date().getTime()},function(data){
        alert('订单发货请求已提交。');
    });
}
</script>
<?php require_once 'footer.php'; ?>