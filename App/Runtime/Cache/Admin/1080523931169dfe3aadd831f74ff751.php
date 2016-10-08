<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>趣味运动会报表</title>
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
<?php if(is_array($jibu)): foreach($jibu as $key=>$v): ?><div class="am-g am-padding">
		<div class="am-panel am-panel-secondary">
			<div class="am-panel-hd">
				<h3 class="am-panel-title"><?php echo ($v['mingcheng']); ?>报表信息</h3>
			</div>
			<?php if(is_array($v['xiangmu'])): foreach($v['xiangmu'] as $key=>$m): ?><table class="am-table am-table-bordered am-table-striped am-table-hover">
					<tr class="am-success">
						<th colspan="4"><?php echo ($m['mingcheng']); ?></th>
					</tr>
					<tr class="am-warning">
						<td style="width: 5%">序号</td>
						<td style="width: 15%">班级</td>
						<td>人员</td>
						<td style="width: 10%">计分</td>
					</tr>
					<?php if($m['jiti'] == 1): ?><!-- 表示是集体项目 -->
						<?php if($m['fenzu'] == 0): ?><!-- 不分组 -->
						<?php if(is_array($m['student'])): foreach($m['student'] as $ni=>$n): ?><tr>
								<td><?php echo ++$ni;?></td>
								<td><?php echo ($n['banji']['username']); ?></td>
								<td>
									<?php
 foreach($n['student'] as $value){ echo $value['name']."&nbsp;&nbsp;"; } ?>
								</td>
								<td></td>
							</tr><?php endforeach; endif; ?>
						<?php else: ?>
						<?php if(is_array($m['content'])): foreach($m['content'] as $key=>$n): ?><tr>
								<td><?php echo ++$ni;?></td>
								<td><?php echo ($n['mingcheng']); ?></td>
								<td>
									<?php
 shuffle($n['student']); foreach($n['student'] as $value){ echo $value['banji']['username']."&nbsp;&nbsp;"; foreach($value['student'] as $mvalue){ echo $mvalue['name']."&nbsp;&nbsp;"; } echo '<br>'; } ?>
								</td>
								<td></td>
							</tr><?php endforeach; endif; endif; ?>
					<?php else: ?>
						<!-- 表示是个人项目 -->
						<?php
 shuffle($m['student']); ?>
						<?php if(is_array($m['student'])): foreach($m['student'] as $key=>$n): ?><tr>
							<td><?php echo ++$ni;?></td>
							<td><?php echo (getbanji($n['bid'])); ?></td>
							<td>
								<?php echo ($n['xuehao']); echo ($n['name']); ?>
							</td>
							<td></td>
						</tr><?php endforeach; endif; endif; ?>
				</table><?php endforeach; endif; ?>
			<div class="am-panel-footer">报表结束</div>
		</div>
	</div><?php endforeach; endif; ?>
</body>
</html>