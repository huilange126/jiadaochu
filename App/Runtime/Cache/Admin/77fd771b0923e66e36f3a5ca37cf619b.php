<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="选项列表" />
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/amazeui2.6/css/amazeui.min.css" />
    <!-- <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/public.css" /> -->
	<title>选项列表</title>
</head>

<body>
    <form method="POST" action="<?php echo U(GROUP_NAME.'/Project/addOption');?>"  class="am-form am-form-horizontal">
        <div class="am-panel am-panel-secondary am-margin">
            <div class="am-panel-hd">评价具体项添加</div>
            <div class="am-panel-bd">
                <div class="am-form-group">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">选项名称</label>
                    <div class="am-u-sm-8 am-u-end">
                        <input type="hidden" name="pid" value="<?php echo ($pid); ?>" />
                        <input type="text" name="optionname" />
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">排序</label>
                    <div class="am-u-sm-1 am-u-end">
                        <input type="text" name="optionsort" size="3" />
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">选项1</label>
                    <div class="am-u-sm-3 am-u-end">
                        <input type="text" name="c1" />
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">选项2</label>
                    <div class="am-u-sm-3 am-u-end">
                        <input type="text" name="c2" />
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">选项3</label>
                    <div class="am-u-sm-3 am-u-end">
                        <input type="text" name="c3" />
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">选项4</label>
                    <div class="am-u-sm-3 am-u-end">
                        <input type="text" name="c4" />
                    </div>
                </div>
                <div class="am-form-group">
                    <div class="am-u-sm-6 am-u-end">
                        <button class="am-btn am-btn-primary am-center">添加评优内容</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
<div class="am-g am-padding">
    <form action="<?php echo U(GROUP_NAME.'/Project/sort');?>" method="POST"  class="am-form am-form-horizontal">
        <table class="am-table am-table-bordered am-table-striped">
            <thead>
                <tr>
                    <td colspan="4" class="am-success">选项列表</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="am-text-center" " width="5%">序号</td>
                    <td width="60%">选项</td>
                    <td width="5%">排序</td>
                    <td>选项</td>
                </tr>
                <?php if(is_array($option)): foreach($option as $key=>$v): ?><tr>
                        <td class="am-text-center"><?php echo ($v['id']); ?></td>
                        <td><?php echo ($v['name']); ?><input type="hidden" name="pid" value="<?php echo ($pid); ?>" /></td>
                        <td><input type="text" size="3" value="<?php echo ($v['sort']); ?>" name="<?php echo ($v['id']); ?>" /></td>
                        <td>A:<?php echo ($v['c1']); ?>&nbsp;&nbsp;B:<?php echo ($v['c2']); ?>&nbsp;&nbsp;C:<?php echo ($v['c3']); ?>&nbsp;&nbsp;D:<?php echo ($v['c4']); ?></td>
                    </tr><?php endforeach; endif; ?>
                <tr>
                    <td colspan="4"><input class="am-btn am-btn-primary am-center" type="submit" value="修改排序" /></td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
    

</body>
</html>