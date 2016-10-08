<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="大眼仔~旭" />
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/amazeui2.6/css/amazeui.min.css" />
    <!-- <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/public.css" /> -->
	<title>项目列表</title>
</head>

<body>
<div class="am-g am-padding">
    <div class="am-panel am-panel-secondary">
      <div class="am-panel-hd">
        <h3 class="am-panel-title">评价项目列表</h3>
    </div>
    <table class="am-table am-table-bordered am-table-striped">
        <tr>
            <td width="5%">序号</td>
            <td width="10%">学期</td>
            <td width="10%">名称</td>
            <td width="10%">参加年级</td>
            <td>评价内容</td>
            <td width="15%">操作</td>
        </tr>
        <?php if(is_array($project)): foreach($project as $key=>$v): ?><tr>
            <td><?php echo ++$key;?></td>
            <td><?php echo ($v['term']); ?></td>
            <td><?php echo ($v['name']); ?></td>
            <td>
                <?php if(is_array($v['ruxuenian'])): foreach($v['ruxuenian'] as $key=>$m): ?>[<span class="am-text-danger"><?php echo (getnianjimingcheng($m['ruxuenian'])); ?></span>]<br><?php endforeach; endif; ?>
            </td>
            <td>
                <ul class="am-list am-list-static">
                <?php if(is_array($v['choose'])): foreach($v['choose'] as $key=>$c): ?><li><?php echo ++$key;?>.<?php echo ($c['name']); ?></li><?php endforeach; endif; ?>
                </ul>
            </td>
            <td>
                <a href="<?php echo U(GROUP_NAME.'/Project/option',array('pid'=>$v['id']));?>" class="am-btn am-btn-primary">添加选项</a><br>
                <a href="<?php echo U(GROUP_NAME.'/Project/modify',array('id'=>$v['id']));?>" class=" am-margin-top am-btn am-btn-success">修改评价任务</a>
                <a href="<?php echo U(GROUP_NAME.'/Project/ajaxResult',array('id'=>$v['id']));?>" class="am-btn am-btn-warning am-margin-top">生成评价结果</a>
            </td>
        </tr><?php endforeach; endif; ?>
        <tr><td colspan="6">
            <ul class="am-pagination am-pagination-left">
                <?php echo ($show); ?>
            </ul>
        </td></tr>
    </table>
</div>
</div>
</body>
</html>