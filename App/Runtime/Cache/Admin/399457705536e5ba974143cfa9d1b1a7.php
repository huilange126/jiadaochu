<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="大眼仔~旭" />
    <!-- <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/public.css" /> -->
    <link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.5.2/css/amazeui.min.css" />
	<title>修改学期</title>
</head>

<body>
    <div class="am-g am-padding">
        <div class="am-panel am-panel-secondary">
          <div class="am-panel-hd">
            学期添加
          </div>
          <div class="am-panel-bd">
            <form  action="<?php echo U(GROUP_NAME.'/Term/update');?>" method="POST" class="am-form am-form-horizontal">
                <div class="am-form-group">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">学期名称</label>
                    <div class="am-u-sm-4 am-u-end">
                      <input type="text" name="name" value="<?php echo ($term['name']); ?>" /><input type="hidden" name="id" value="<?php echo ($term['id']); ?>" />
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">学期状态</label>
                    <div class="am-u-sm-4 am-u-end">
                      <label class="am-radio-inline">
                        <input type="radio" name="status" <?php if($term['status'] == 0): ?>checked="checked"<?php endif; ?> value="0" />禁用
                      </label>
                      <label class="am-radio-inline">
                        <input type="radio" <?php if($term['status'] == 1): ?>checked="checked"<?php endif; ?>  name="status" value="1" />启用(注：只有一个启用学期，一个启用其他都会禁用)
                      </label>
                    </div>
                </div>
                <div class="am-form-group">
                    <div class="am-u-sm-6 am-u-end">
                        <button class="am-btn am-btn-primary am-center">修改学期</button>
                    </div>
                </div>
            </form>
          </div>
        </div>
    </div>


</body>
</html>