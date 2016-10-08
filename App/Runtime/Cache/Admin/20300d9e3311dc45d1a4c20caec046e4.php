<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="大眼仔~旭" />
    <!-- <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/public.css" /> -->
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/amazeui2.6/css/amazeui.min.css" />
	<title>评价任务添加</title>
</head>

<body>
    <form action="<?php echo U(GROUP_NAME.'/Project/addProject');?>" method="POST" class="am-form am-form-horizontal">
        <div class="am-panel am-panel-secondary am-margin">
            <div class="am-panel-hd">评价任务添加</div>
            <div class="am-panel-bd">
                <div class="am-form-group">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">学期</label>
                    <div class="am-u-sm-4 am-u-end">
                    <input type="text" value="<?php echo ($term['name']); ?>" readonly="" />
                    <input type="hidden" name="term" value="<?php echo ($term['id']); ?>" />
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">评价项目名称</label>
                    <div class="am-u-sm-4 am-u-end">
                    <input type="text" name="name" />
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">参加年级</label>
                    <div class="am-u-sm-4 am-u-end">
                     <?php if(is_array($nianji)): foreach($nianji as $key=>$v): ?><label  class="am-checkbox-inline">
                        <input type="checkbox" name="nianji[]" value="<?php echo ($v['id']); ?>" /><?php echo ($v['mingcheng']); ?>(<?php echo ($v['ruxuenian']); ?>级)</label><?php endforeach; endif; ?>
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">类型</label>
                    <div class="am-u-sm-4 am-u-end">
                        <label class="am-radio-inline">
                            <input type="radio"  value="0" name="leixing" checked="checked"> 评价任课老师
                        </label>
                        <label class="am-radio-inline">
                            <input type="radio" value="1" name="leixing"> 评价班主任
                        </label>
                    </div>
                </div>
                <div class="am-form-group">
                    <div class="am-u-sm-6 am-u-end">
                        <button class="am-btn am-btn-primary am-center">添加评价任务</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
</html>