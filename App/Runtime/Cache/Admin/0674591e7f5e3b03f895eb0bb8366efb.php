<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>成绩导入页面</title>
	<link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.5.0/css/amazeui.min.css" />
</head>
<body>
	<div class="am-g am-padding">
		<div class="am-panel am-panel-secondary">
			<div class="am-panel-hd">学生成绩导入【Excel内容格式为：学号 姓名 成绩】</div>
			<div class="am-panel-bd am-cf">
				<form class="am-form am-form-horizontal" method="POST" action="<?php echo U(GROUP_NAME.'/Chengji/daoruHandle');?>"  enctype='multipart/form-data'>
					<div class="am-form-group">
						<label for="doc-ipt-3" class="am-u-sm-1 am-form-label">当前学期</label>
						<div class="am-u-sm-5 am-u-end">
							<input type="email" id="doc-ipt-3" value="<?php echo ($term['name']); ?>" readonly="">
							<input type="hidden" name="term" value="<?php echo ($term['id']); ?>">
						</div>
					</div>
					<div class="am-form-group">
						<label for="doc-select-1" class="am-u-sm-1 am-form-label">选择学科</label>
						<div class="am-u-sm-2 am-u-end">
							<select id="doc-select-1" name="xueke">
								<option value="0">请选择学科</option>
								<?php if(is_array($xueke)): foreach($xueke as $key=>$v): ?><option value="<?php echo ($v['id']); ?>"><?php echo ($v['xueke']); ?></option><?php endforeach; endif; ?>
							</select>
							<span class="am-form-caret"></span>	
						</div>
					</div>
					<div class="am-form-group">
						<label for="doc-ipt-file-2"  class="am-u-sm-1 am-form-label">选择文件</label>
						<div  class="am-u-sm-4 am-u-end">
							<input type="file" id="doc-ipt-file-1" name="excel">
							<p class="am-form-help">请选择要上传的文件...</p>
						</div>
					</div>
					<div class="am-form-group">
						<div class="am-u-sm-6 am-u-end am-text-center">
							<button class="am-btn am-btn-primary">导入学生成绩</button>
						</div>
					</div>
					</form>
			</div>
		</div>
	</div>
</body>
</html>