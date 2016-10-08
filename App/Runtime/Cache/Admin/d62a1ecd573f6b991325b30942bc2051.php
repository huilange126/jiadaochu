<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo ($pageName); ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="format-detection" content="telephone=no">
	<meta name="renderer" content="webkit">
	<meta http-equiv="Cache-Control" content="no-siteapp"/>
	<link rel="stylesheet" type="text/css" href="__PUBLIC__/amazeui2.6/css/amazeui.min.css" />
</head>
<body>
<div class="am-g am-padding">
	<div class="am-panel am-panel-secondary">
		<div class="am-panel-hd">管理员添加</div>
		<div class="am-panel-bd">
			<form class="am-form am-form-horizontal" method="POST" action="<?php echo U(GROUP_NAME.'/Admin/addHandle');?>">
				<div class="am-form-group">
					<label for="doc-ipt-3" class="am-u-sm-2 am-form-label">账号</label>
					<div class="am-u-sm-4 am-u-end">
						<input type="text" name="username" id="doc-ipt-3" placeholder="管理员账号">
					</div>
				</div>
				<div class="am-form-group">
					<label for="doc-ipt-3" class="am-u-sm-2 am-form-label">密码</label>
					<div class="am-u-sm-4 am-u-end">
						<input type="password" name="password" id="doc-ipt-3" placeholder="请输入密码">
					</div>
				</div>
				<div class="am-form-group">
					<label for="doc-ipt-3" class="am-u-sm-2 am-form-label">密码确认</label>
					<div class="am-u-sm-4 am-u-end">
						<input type="password" name="repassword" id="doc-ipt-3" placeholder="请输入密码">
					</div>
				</div>
				<div class="am-form-group">
					<div class="am-u-sm-6 am-u-end">
						<button class="am-btn am-btn-primary am-center">添加管理员</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="__PUBLIC__/amazeui2.6/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="__PUBLIC__/amazeui2.6/js/amazeui.min.js"></script>
</body>
</html>