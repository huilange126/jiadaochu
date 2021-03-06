<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="大眼仔~旭" />
    <link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.5.1/css/amazeui.min.css" />
    <!-- <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/public.css" /> -->
	<title>单个学生添加</title>
</head>

<body>
    <div class="am-g am-padding">
        <div class="am-panel am-panel-secondary">
            <div class="am-panel-hd">单个学生添加</div>
            <div class="am-panel-bd">
                <form action="<?php echo U(GROUP_NAME.'/Student/addHandle');?>" method="POST" class="am-form am-form-horizontal">
                    <div class="am-form-group">
                        <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">班级</label>
                        <div class="am-u-sm-2 am-u-end">
                            <select name="banji" id="">
                                <option value="0">请选择班级</option>
                                <?php if(is_array($banji)): foreach($banji as $key=>$v): ?><option value="<?php echo ($v['id']); ?>"><?php echo ($v['ruxuenian']); ?>级<?php echo ($v['banji']); ?>班</option><?php endforeach; endif; ?>
                            </select>
                            <span class="am-form-caret"></span>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">学号</label>
                        <div class="am-u-sm-4 am-u-end">
                            <input type="text" name="xuehao" />
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">姓名</label>
                        <div class="am-u-sm-4 am-u-end">
                            <input type="text" name="xingming" palaceholder="姓名">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">性别</label>
                        <div class="am-u-sm-4 am-u-end">
                            <label class="am-radio-inline">
                                <input type="radio"  value="1" checked="checked" name="xingbie"> 男
                            </label>
                            <label class="am-radio-inline">
                                <input type="radio" value="0" name="xingbie"> 女
                            </label>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <div class="am-u-sm-6 am-u-end">
                            <button class="am-btn am-btn-primary am-center">提交学生信息</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>