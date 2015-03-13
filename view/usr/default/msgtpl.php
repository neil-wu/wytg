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
    <p class="local_addr gray">当前位置：<a class="blue" href="/user">账户中心</a> › <a class="blue" href="/user/set">消息模板</a></p>
    <!--#<div class="btn_sit"><a href="/goods/add">新增模板</a></div>-->
    <form id="add" method="post" action="/user/saveset">
        <input type="hidden" name="id" value="<?php echo $tplinfo ? $tplinfo['id'] : '' ?>">
    <table class="table_box">
        <tr><td colspan="2"></td></tr>
        <tr><td colspan="2"><h3><?php if($tplinfo): ?>修改模板<?php else: ?>新增模板<?php endif;?></h3></td></tr>
        <tr>
            <td width="90" class="text_right">模板名称：</td>
            <td><input class="input" type="text" name="tpl_name" size="40" value="<?php echo $tplinfo ? $tplinfo['name'] : ''?>"></td>
        </tr>
        <tr>
            <td class="text_right">消息标题：</td>
            <td><input class="input" type="text" name="tpl_title" size="40" value="<?php echo $tplinfo ? $tplinfo['title'] : ''?>"></td>
        </tr>
        <tr>
            <td class="text_right">模板内容：</td>
            <td><textarea class="t_a_t" name="tpl_content" cols="60" rows="10"><?php echo $tplinfo ? $tplinfo['tpl'] : '' ?></textarea></td>
        </tr>
        
        <tr>
            <td class="text_right">状态设置：</td>
            <td>
                <select name="tpl_state">
                    <option value="0"<?php echo $tplinfo && $tplinfo['is_state']==0 ? ' selected' : '' ?>>开启</option>
                    <option value="1"<?php echo $tplinfo && $tplinfo['is_state']==1 ? ' selected' : '' ?>>关闭</option>
                </select>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" class="btn btn-lg" value="立即保存"></td>
        </tr>
        <tr><td colspan="2"></td></tr>
    </table>
    </form>
 <form id="delall" method="post" action="/user/delall">   
    <table class="table margin_top20">
        <thead>
            <tr>
                <th><input type="checkbox" id="checkall"></th>
                <th>模板名称</th>
                <th>消息标题</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
        </thead>
        
        <tbody>
        <?php if($data):?>
            <?php foreach($data as $key=>$val):?>
                <tr class="lightbox">
                    <td><input type="checkbox" class="check" name="listid[]" value="<?php echo $val['id']?>"></td>
                    <td><?php echo $val['name']?></td>
                    <td width="400" style="text-align:left"><?php echo $val['title']?></td>
                    <td><?php echo $val['is_state'] ? '<span class="red">已关闭</span>' : '<span class="green">已开启</span>'?></td>
                    <td><a class="line blue" href="/user/set/<?php echo $val['id']?>">编辑</a><span class="line_vertical">|</span><a class="line red" href="/user/delset/<?php echo $val['id']?>">删除</a></td>
                </tr>
            <?php endforeach;?>
        <?php else:?>
            <tr><td colspan="5">no data.</td></tr>
        <?php endif; ?>
    </tbody>
    </table>
    <span class="hide delbtn margin_top15"><br><input type="submit" value="删除选中" class="btn btn-lg">&nbsp;</span>
</form>
</div>

<?php require_once 'footer.php'; ?>