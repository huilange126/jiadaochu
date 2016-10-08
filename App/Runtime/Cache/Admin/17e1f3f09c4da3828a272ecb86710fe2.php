<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="大眼仔~旭" />
    <!-- <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/public.css" /> -->
    <link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.5.2/css/amazeui.min.css" />
	<title>教师添加页面</title>
</head>

<body>
<div class="am-g am-padding">
    <div class="am-panel am-panel-secondary">
        <div class="am-panel-hd">教师添加</div>
        <div class="am-panel-bd">
            <form action="<?php echo U(GROUP_NAME.'/Teacher/addTeacher');?>" method="POST" class="am-form am-form-horizontal">
                <div class="am-form-group">
                  <label class="am-u-sm-2 am-form-label">学科</label>
                  <div class="am-u-sm-2 am-u-end">
                    <select id="doc-select-1"  name="xueke">
                        <option value="0">选择学科</option>
                        <?php if(is_array($xueke)): foreach($xueke as $key=>$v): ?><option value="<?php echo ($v['id']); ?>"><?php echo ($v['xueke']); ?></option><?php endforeach; endif; ?>
                    </select>
                    <span class="am-form-caret"></span>
                  </div>
                  
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">姓名</label>
                    <div class="am-u-sm-4 am-u-end">
                        <input type="text" name="name" />
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">身份证号</label>
                    <div class="am-u-sm-4 am-u-end">
                        <input type="text" name="cid" />
                    </div>
                </div>
                <div class="am-form-group">
                    <div class="am-u-sm-6 am-u-end">
                        <button class="am-btn am-btn-primary am-center">添加教师</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>