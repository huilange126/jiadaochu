<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>班级评优结果</title>
	<link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.5.0/css/amazeui.min.css" />
</head>
<body>
	<div class="am-g am-padding-left am-padding-right">
		<div class="am-panel am-panel-secondary am-margin-top">
			<div class="am-panel-hd"><?php echo ($term['name']); ?>优秀班集体评价结果</div>
		</div>
		<?php if(is_array($result)): foreach($result as $key=>$v): ?><table class="am-table am-table-bordered am-table-striped am-table-hover">
				<thead>
					<tr>
					<th colspan="3"><?php echo ($v['nianjimingcheng']); ?>(<?php echo ($v['ruxuenianfen']); ?>)</th>
					</tr>
					<tr>
						<th style="width:10%;">入学年份</th>
						<th style="width:10%;">班级</th>
						<th>得分</th>
					</tr>
				</thead>
				<tbody>
				<?php if(is_array($v['banji'])): foreach($v['banji'] as $key=>$m): ?><tr>
						<td><?php echo ($m['ruxuenian']); ?></td>
						<td><?php echo ($m['banji']); ?></td>
						<td><?php echo ($m['defen']); ?></td>
					</tr><?php endforeach; endif; ?>
				</tbody>
			</table><?php endforeach; endif; ?>
	</div>
</body>
</html>