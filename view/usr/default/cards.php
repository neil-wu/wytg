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
    <p class="local_addr gray">当前位置：<a class="blue" href="/user">账户中心</a> › <a class="blue" href="/cards">卡密库存列表</a></p>
    <div class="btn_sit"><a href="/cards/add">添加库存</a></div>
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
            
            卡密状态：
            <select name="state">
                <option value="-1"<?php echo $search['state']==-1 ? ' selected' : '' ?>>全部</option>
                <option value="0"<?php echo $search['state']==0 ? ' selected' : '' ?>>未出售</option>
                <option value="1"<?php echo $search['state']==1 ? ' selected' : '' ?>>已出售</option>
            </select>&nbsp;
            
            日期：
            <input type="text" name="fdate" id="txtDate" onclick="SelectDate(this)" size="12" readonly="readonly" value="<?php echo $search['fdate'] ?>" />&nbsp;
            至 <input type="text" name="tdate" id="txtDate1" onclick="SelectDate(this)" size="12" readonly="readonly" value="<?php echo $search['tdate'] ?>" />&nbsp;
            
            <input type="submit" class="btn btn-sm" value="查询">
        </form>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>商品名称</th>
                <th>卡号</th>
                <th>卡密</th>
                <th>状态</th>
                <th>增加日期</th>
                <th>出售日期</th>
                <th>操作</th>
            </tr>
        </thead>
        
        <tbody>
        <?php if($data):?>
            <?php foreach($data as $key=>$val):?>
                <tr class="lightbox">
                    <td style="text-align:left"><a class="line blue" href="http://item.taobao.com/item.htm?id=<?php echo $val['num_iid']?>" target="_blank"><?php echo $val['tb_title']?></a></td>
                    <td><?php echo $val['cardnum']?></a></td>
                    <td><?php echo $val['cardpwd']?></td>
                    <td><?php echo $val['is_state'] ? '<span class="red">已售</span>' : '<span class="green">正常</span>'?></td>
                    <td><?php echo $val['addtime']?></td>
                    <td><?php echo $val['selltime']?></td>
                    <td></td>
                </tr>
            <?php endforeach;?>
            <tr><td colspan="7"><?php echo $pagelist ?></td></tr>
        <?php else:?>
            <tr><td colspan="7">no data.</td></tr>
        <?php endif; ?>
    </tbody>
    </table>
</div>

<?php require_once 'footer.php'; ?>