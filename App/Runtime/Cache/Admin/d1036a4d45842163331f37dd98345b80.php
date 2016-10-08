<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>系统设置评优</title>
	<link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.5.0/css/amazeui.min.css" />
</head>
<body>
	<div class="am-g am-padding">
		<div class="am-panel am-panel-secondary">
		<div class="am-panel-hd">优秀班集体评分项分值设定</div>
			<div class="am-panel-bd am-cf">
				<form action="<?php echo U(GROUP_NAME.'/Pingyou/setsystemHandle');?>" method="POST" class="am-form am-form-horizontal">
					<div class="am-form-group">
						<label for="doc-ipt-email-1"class="am-u-sm-1 am-text-right">选项1</label>
						<div class="am-u-sm-2">
							<input type="text" value="<?php echo (C("mingcheng.0")); ?>" class="" id="doc-ipt-email-1" name="mingcheng[]" placeholder="名称">
						</div>
						<div class="am-u-sm-2 am-u-end">
							<input type="text"  value="<?php echo (C("fenzhi.0")); ?>"  class="" id="doc-ipt-email-1" name="fenzhi[]" placeholder="分值">
						</div>
					</div>
					<div class="am-form-group">
						<label for="doc-ipt-email-1"class="am-u-sm-1 am-text-right">选项2</label>
						<div class="am-u-sm-2">
							<input type="text" class="" value="<?php echo (C("mingcheng.1")); ?>"  id="doc-ipt-email-1" name="mingcheng[]" placeholder="名称">
						</div>
						<div class="am-u-sm-2 am-u-end">
							<input type="text"   value="<?php echo (C("fenzhi.1")); ?>" class="" id="doc-ipt-email-1" name="fenzhi[]" placeholder="分值">
						</div>
					</div>
					<div class="am-form-group">
						<label for="doc-ipt-email-1"class="am-u-sm-1 am-text-right">选项3</label>
						<div class="am-u-sm-2">
							<input type="text" value="<?php echo (C("mingcheng.2")); ?>"  class="" id="doc-ipt-email-1" name="mingcheng[]" placeholder="名称">
						</div>
						<div class="am-u-sm-2 am-u-end">
							<input type="text"   value="<?php echo (C("fenzhi.2")); ?>" class="" id="doc-ipt-email-1" name="fenzhi[]" placeholder="分值">
						</div>
					</div>
					<div class="am-form-group">
						<label for="doc-ipt-email-1"class="am-u-sm-1 am-text-right">选项4</label>
						<div class="am-u-sm-2">
							<input type="text" value="<?php echo (C("mingcheng.3")); ?>"  class="" id="doc-ipt-email-1" name="mingcheng[]" placeholder="名称">
						</div>
						<div class="am-u-sm-2 am-u-end">
							<input type="text"   value="<?php echo (C("fenzhi.3")); ?>" class="" id="doc-ipt-email-1" name="fenzhi[]" placeholder="分值">
						</div>
					</div>
					<div class="am-form-group">
						<div class="am-u-sm-5 am-u-end am-text-center">
							<button type="submit" class="am-btn am-btn-primary">设置项目分值</button>
						</div>		
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>