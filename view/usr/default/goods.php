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
    <p class="local_addr gray">当前位置：<a class="blue" href="/user">账户中心</a> › <a class="blue" href="/goods">商品列表</a></p>
    <div class="btn_sit"><a href="/goods/add">添加商品</a></div>
    
    <div class="search_bg margin_top15">
        <form id="s" class="niceform" action="" method="get">
            
            商品状态：
            <select name="state">
                <option value="-1"<?php echo $search['state']==-1 ? ' selected' : '' ?>>全部</option>
                <option value="1"<?php echo $search['state']==1 ? ' selected' : '' ?>>已暂停</option>
                <option value="0"<?php echo $search['state']==0 ? ' selected' : '' ?>>出售中</option>
            </select>&nbsp;
            
            商品名称：
            <input type="text" class="input" name="kwd" size="20" value="<?php echo $search['kwd']?>">
            
            <input type="submit" class="btn btn-sm" value="查询">
        </form>
    </div>
<form id="delall" method="post" action="/goods/delall">    
    <table class="table margin_top15">
        <thead>
            <tr class="info">
                <th><input type="checkbox" id="checkall"></th>
                <th>商品图片</th>
                <th>商品名称</th>
                <th>商品售价</th>
                <th>状态</th>
                <th>卡密库存</th>
                <th>卡密销售</th>
                <th>操作</th>
            </tr>
        </thead>
        
        <tbody>
        <?php if($data):?>
            <?php foreach($data as $key=>$val):?>
                <tr class="lightbox">
                    <td><input type="checkbox" class="check" name="listid[]" value="<?php echo $val['id']?>"></td>
                    <td><img src="<?php echo $val['tb_img']?>" width="20"></td>
                    <td style="text-align:left"><a class="line blue" href="http://item.taobao.com/item.htm?id=<?php echo $val['tb_goodid']?>" target="_blank"><?php echo $val['tb_title']?></a></td>
                    <td><?php echo $val['tb_price']?> 元</td>
                    <td><?php echo $val['is_state'] ? '<span class="red">已下架</span>' : '<span class="green">出售中</span>' ?></td>
                    <td><a class="line green" href="/cards?goodid=<?php echo $val['tb_goodid']?>&state=0">查看(<?php echo $val['kucun']?>)</a></td>
                    <td><a class="line green" href="/cards?goodid=<?php echo $val['tb_goodid']?>&state=1">查看(<?php echo $val['sells']?>)</a></td>
                    <td><a class="line red" href="/goods/del/<?php echo $val['tb_goodid']?>" onclick="if(!confirm('是否要执行此操作？'))return false">删除</a><span class="line_vertical">|</span><a class="line blue" href="/goods/edit/<?php echo $val['tb_goodid']?>">配置</a><span class="line_vertical">|</span><a class="line blue" href="/cards/add/<?php echo $val['tb_goodid']?>">加库存</a></td>
                </tr>
            <?php endforeach;?>
            <tr><td colspan="8"><?php echo $pagelist ?></td></tr>
        <?php else:?>
            <tr><td colspan="8">no data.</td></tr>
        <?php endif; ?>
    </tbody>
    </table>
    <span class="hide delbtn margin_top15"><br><input type="submit" value="删除选中" class="btn btn-lg">&nbsp;</span>
</form>
</div>
<?php require_once 'footer.php'; ?>