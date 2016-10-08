<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="大眼仔~旭" />
    <!-- <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/public.css" /> -->
    <link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.5.2/css/amazeui.min.css" />
	<title>修改学科</title>
</head>

<body>
    <div class="am-g am-padding">
        <div class="am-panel am-panel-secondary">
            <div class="am-panel-hd">学科添加</div>
            <div class="am-panel-bd">
            <form  action="<?php echo U(GROUP_NAME.'/Xueke/updatexueke');?>" method="POST" class="am-form am-form-horizontal">
                <div class="am-form-group">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">学科名称</label>
                    <div class="am-u-sm-4 am-u-end">
                        <input type="hidden" name="id" value="<?php echo ($xueke['id']); ?>" />
                        <input type="text" name="xueke" value="<?php echo ($xueke['xueke']); ?>" />
                    </div>
                </div>
                <div class="am-form-group">
                    <div class="am-u-sm-6 am-u-end">
                        <button class="am-btn am-btn-primary am-center">修改学科</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>

</body>
</html>