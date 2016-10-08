<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>学生信息修改</title>
	<link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.5.1/css/amazeui.min.css" />
</head>
<body>
	<div class="am-g am-padding">
		<div class="am-panel am-panel-secondary">
			<div class="am-panel-hd">修改学生信息</div>
			<div class="am-panel-bd">
				<form class="am-form am-form-horizontal" method="POST" action="<?php echo U(GROUP_NAME.'/Student/modifyHandle');?>">				
					<div class="am-form-group">
						<label for="doc-ipt-3" class="am-u-sm-2 am-form-label">学号</label>
						<div class="am-u-sm-4 am-u-end">
							<input type="text" id="doc-ipt-3" name="xuehao" value="<?php echo ($student['xuehao']); ?>">
							<input type="hidden" name="id" value="<?php echo ($student['id']); ?>">
						</div>
					</div>
					<div class="am-form-group">
						<label for="doc-ipt-3" class="am-u-sm-2 am-form-label">姓名</label>
						<div class="am-u-sm-4 am-u-end">
							<input type="text" id="doc-ipt-3" name="name" value="<?php echo ($student['name']); ?>">
						</div>
					</div>
					<div class="am-form-group">
                        <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">性别</label>
                        <div class="am-u-sm-4 am-u-end">
                            <label class="am-radio-inline">
                                <input type="radio"  value="1" <?php if($student['xingbie'] == 1): ?>checked="checked"<?php endif; ?> name="xingbie"> 男
                            </label>
                            <label class="am-radio-inline">
                                <input type="radio" value="0"  <?php if($student['xingbie'] == 0): ?>checked="checked"<?php endif; ?>  name="xingbie"> 女
                            </label>
                        </div>
                    </div>
					<div class="am-form-group">
						<div class="am-u-sm-6 am-u-end">
							<button class="am-btn am-btn-primary am-center">提交修改信息</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>