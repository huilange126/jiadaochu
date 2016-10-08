<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>报表查看类型选择</title>
	<link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.5.2/css/amazeui.min.css" />
</head>
<body>
	<div class="am-g am-padding">
		<div class="am-panel am-panel-secondary">
			<div class="am-panel-hd">
			<h3 class="am-panel-title">报名结果查看报表类型选择</h3>
			</div>
			<ul class="am-list">
				<?php if(is_array($type)): foreach($type as $key=>$v): ?><li><a href="<?php echo U(GROUP_NAME.'/Enrollment/chakan',array('type'=>$v['type'],'id'=>$v['eid']));?>"><span class="am-badge am-badge-primary am-margin-right"><?php echo ++$key;?></span><?php echo ($v['title']); ?></a></li><?php endforeach; endif; ?>
			</ul>
		</div>
	</div>
</body>
</html>