<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>班级评优教师状态</title>
	<link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.5.0/css/amazeui.min.css" />
</head>
<body>
	<div class="am-container">
		<div class="am-panel am-panel-secondary am-margin-top">
			<div class="am-panel-hd"><?php echo ($term['name']); ?>优秀班集体评价概况</div>
			<div class="am-panel-bd">
				共有教师：<?php echo ($count); ?>名，评价完成的有<?php echo ($finish); ?>名。
			</div>
		</div>
		<table class="am-table am-table-bordered am-table-striped am-table-hover">
			<thead>
				<tr class="am-primary">
					<th>序号</th>
					<th>姓名</th>
					<th>学科</th>
					<th>状态</th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($teacher)): foreach($teacher as $key=>$v): ?><tr>
						<td><?php echo ++$num;?></td>
						<td><?php echo ($v['name']); ?></td>
						<td><?php echo ($v['xueke']); ?></td>
						<td>
							<?php if($v['status'] == 1): ?><span class="am-text-success">已经完成评价</span>
							<?php else: ?>
								<span class="am-text-danger">还未完成评价</span><?php endif; ?>
						</td>
					</tr><?php endforeach; endif; ?>
				<tr>
					<td colspan="4">
						<ul class="am-pagination am-pagination-left">
							<?php echo ($show); ?>
						</ul>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>