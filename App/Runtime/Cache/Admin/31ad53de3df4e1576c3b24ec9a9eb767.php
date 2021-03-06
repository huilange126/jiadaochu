<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>添加合并项目分组</title>
	<link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.5.2/css/amazeui.min.css" />
</head>
<body>
	<div class="am-g am-padding">
		<div class="am-panel am-panel-secondary">
			<div class="am-panel-hd">添加合并分组</div>
			<div class="am-panel-bd">
				<form action="<?php echo U(GROUP_NAME.'/EnrollmentContent/hebingHandle');?>" method="POST" class="am-form am-form-horizontal">
					<div class="am-form-group">
						<label for="doc-ipt-email-1" class="am-u-sm-2 am-text-right">所属报名项目</label>
						<div class="am-u-sm-4 am-u-end">
							<input type="hidden" value="<?php echo ($enrollment['id']); ?>" name="eid">
							<input type="text" name="enrollment" value="<?php echo ($enrollment['mingcheng']); ?>" readonly="readonly">
						</div>
					</div>
					<div class="am-form-group">
						<label for="doc-ipt-email-1" class="am-u-sm-2 am-text-right">合并分组名称</label>
						<div class="am-u-sm-4 am-u-end">
							<input type="text" name="mingcheng" placeholder="添加合并分组名称">
						</div>
					</div>
					<div class="am-form-group">
						<div class="am-u-sm-6 am-u-end">
							<button class="am-btn am-btn-primary am-center">添加合并分组</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>