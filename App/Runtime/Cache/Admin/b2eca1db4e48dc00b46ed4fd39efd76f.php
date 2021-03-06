<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="大眼仔~旭" />
    <!-- <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/public.css" /> -->
    <link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.5.2/css/amazeui.min.css" />
    <title>学科列表</title>
</head>

<body>
    <div class="am-g am-padding">
        <div class="am-panel am-panel-secondary">
            <div class="am-panel-hd">学科添加</div>
            <div class="am-panel-bd">
            <form  action="<?php echo U(GROUP_NAME.'/Xueke/addXueke');?>" method="POST" class="am-form am-form-horizontal">
                <div class="am-form-group">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">学科名称</label>
                    <div class="am-u-sm-4 am-u-end">
                        <input type="text" name="xueke" />
                    </div>
                </div>
                <div class="am-form-group">
                    <div class="am-u-sm-6 am-u-end">
                        <button class="am-btn am-btn-primary am-center">添加学科</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
    <div class="am-g am-padding">
    <table class="am-table am-table-bordered am-table-striped am-table-hover">
            <thead>
                <tr class="am-primary">
                    <th colspan="3">学科列表</th>
                </tr>
                <tr class="am-success">
                    <th>ID</th>
                    <th>学科名</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($xueke)): foreach($xueke as $key=>$v): ?><tr>
                        <td width="5%" class="am-text-center"><?php echo ($v['id']); ?></td>
                        <td width="10%" class="am-text-center"><?php echo ($v['xueke']); ?></td>
                        <td>
                        <a class="am-btn am-btn-success am-btn-xs"  href="<?php echo U(GROUP_NAME.'/Xueke/modify',array('id'=>$v['id']));?>">修改</a>
                        <a class="am-btn am-btn-danger am-btn-xs" href="<?php echo U(GROUP_NAME.'/Xueke/del',array('id'=>$v['id']));?>">删除</a>
                        
                        </td>
                    </tr><?php endforeach; endif; ?>
            </tbody>

        </table>
    </div>
</body>
</html>