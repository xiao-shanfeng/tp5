<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"E:\vhost\tpshop\public/../application/admin\view\attribute\getAttr.html";i:1551790250;}*/ ?>
<table class="table table-border table-bordered table-bg">
    <thead>
    <tr>
        <th scope="col" colspan="9">属性列表</th>
    </tr>
    <tr class="text-c">
        <th width="25"><input type="checkbox" name="" value=""></th>
        <th width="40">ID</th>
        <th width="150">属性名称</th>
        <th width="90">所属类型</th>
        <th width="150">属性类型</th>
        <th>录入方式</th>
        <th>可选值</th>
        <th width="130">加入时间</th>
        <th width="100">是否已启用</th>
        <th width="100">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($data as $v): ?>
    <tr class="text-c">
        <td><input type="checkbox" value="1" name=""></td>
        <td><?php echo $v['id']; ?></td>
        <td><?php echo $v['attr_name']; ?></td>
        <td><?php echo $v['type']['type_name']; ?></td>
        <td><?php echo $v['attr_type']==0?"唯一属性":"单选属性"; ?></td>
        <td><?php echo $v['attr_input_type']==0?"手工录入":"列表选择"; ?></td>
        <td><?php echo $v['attr_value']; ?></td>
        <td><?php echo $v['create_time']; ?></td>
        <td class="td-status"><span class="label label-success radius">已启用</span></td>
        <td class="td-manage"><a style="text-decoration:none" onClick="admin_stop(this,'10001')" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a> <a title="编辑" href="javascript:;" onclick="admin_edit('管理员编辑','admin-add.html','1','800','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>