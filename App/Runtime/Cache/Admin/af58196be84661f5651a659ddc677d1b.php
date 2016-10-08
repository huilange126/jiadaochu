<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="大眼仔~旭" />
    <!-- <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/public.css" /> -->
    <link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.1.0/css/amazeui.min.css" />
    <title>学生列表页面</title>
</head>

<body>
    <div class="am-g am-padding">
        <div class="am-panel am-panel-secondary">
          <div class="am-panel-hd">
              学号信息设置
          </div>
          <div class="am-panel-bd">
                <form class="am-form am-form-horizontal" method="POST" action="<?php echo U(GROUP_NAME.'/Student/setHandle');?>">
                    <div class="am-form-group">
                        <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">班级开始位</label>
                        <div class="am-u-sm-4 am-u-end">
                          <input type="text" id="doc-ipt-3" name="banjistart" placeholder="请输代表班级起始位" value="<?php echo (C("banjistart")); ?>">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">班级位长度</label>
                        <div class="am-u-sm-4 am-u-end">
                          <input type="text" id="doc-ipt-3" name="banjilength" placeholder="请输代表班级位长度" value="<?php echo (C("banjilength")); ?>">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <div class="am-u-sm-6 am-u-end">
                            <button class="am-btn am-btn-primary am-center">
                                设置
                            </button>
                        </div>
                    </div>
                </form>
          </div>
        </div>
    </div>
</body>
</html>