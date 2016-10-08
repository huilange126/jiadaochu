<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="大眼仔~旭" />
    <!-- <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/public.css" /> -->
    <link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.1.0/css/amazeui.min.css" />
	<title>学生名单导入</title>
</head>

<body>
    <div class="am-g am-padding">
        <div class="am-panel am-panel-secondary">
            <div class="am-panel-hd">导入学生名单【Excel格式为：学号 姓名 性别(男/女)】</div>
            <div class="am-panel-bd">
                <form method="POST" action="<?php echo U(GROUP_NAME.'/Student/upload');?>"  enctype="multipart/form-data" class="am-form am-form-horizontal">
                    <div class="am-form-group">
                        <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">选择年级</label>
                        <div class="am-u-sm-4 am-u-end">
                            <select  name="nianji">
                                <option value="0">----选择年级----</option>
                                <?php if(is_array($nianji)): foreach($nianji as $key=>$v): ?><option value="<?php echo ($v['ruxuenian']); ?>"><?php echo ($v['mingcheng']); ?></option><?php endforeach; endif; ?>
                            </select>
                            <span class="am-form-caret"></span>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">选择文件</label>
                        <div class="am-u-sm-4 am-u-end">
                            <input type="file" name="file" />
                        </div>
                    </div>
                    <div class="am-form-group">
                        <div class="am-u-sm-6 am-u-end">
                            <button class="am-btn am-btn-primary am-center">导入学生信息</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>