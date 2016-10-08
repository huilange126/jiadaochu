<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>报名任务普通类型报表</title>
	<link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.5.2/css/amazeui.min.css" />
</head>
<body>
	<div class="am-g am-padding">
		<div class="am-panel am-panel-default">
			<div class="am-panel-bd">
				<a href="__ROOT__/Uploads/<?php echo ($file); ?>" class="am-btn am-btn am-btn-primary">导出WORD名单</a>
			</div>
		</div>
	</div>
	<div class="am-g am-padding">
		<?php if(is_array($jibu)): foreach($jibu as $key=>$v): ?><!-- 循环级部开始 -->
			<div class="am-panel am-panel-secondary">
				<div class="am-panel-hd">
					<h3 class="am-panel-title"><?php echo ($v['mingcheng']); ?></h3>
				</div>
				<?php if(is_array($v['xiangmu'])): foreach($v['xiangmu'] as $key=>$m): ?><!-- 循环项目开始 -->
					<table class="am-table am-table-bordered am-table-striped am-table-hover">
						<tr>
							<th colspan="5" class="am-success"><span class="am-padding-left"><?php echo ($m['mingcheng']); ?></span></th>
						</tr>
						<tr>
							<th>序号</th>
							<th>学号</th>
							<th>姓名</th>
							<th>性别</th>
							<th>备注</th>
						</tr>
						<?php if(is_array($m['student'])): foreach($m['student'] as $key=>$n): ?><!-- 循环学生开始 -->
						<tr>
							<td style="width: 5%"><?php echo ++$key;?></td>
							<td style="width: 10%"><?php echo ($n['xuehao']); ?></td>
							<td style="width: 5%">
								<?php if($n['xingbie'] == 1): ?>男
								<?php else: ?>
									女<?php endif; ?>
							</td>
							<td style="width: 10%"><?php echo ($n['name']); ?></td>
							<td></td>
						</tr>
						<!-- 循环学生结束 --><?php endforeach; endif; ?>
					</table>
				<!-- 循环项目结束 --><?php endforeach; endif; ?>
				<div class="am-panel-footer">...</div>
			</div>
		<!-- 循环级部结束 --><?php endforeach; endif; ?>
	</div>
</body>
</html>