<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>评优结果页面</title>
	<link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.5.2/css/amazeui.min.css" />
</head>
<body>
	<div class="am-g am-padding">
		<div class="am-panel am-panel-warning">
			<div class="am-panel-hd">评价结果</div>
		</div>
		<?php if(is_array($result)): foreach($result as $key=>$v): ?><div class="am-panel am-panel-secondary">
			<div class="am-panel-hd"><?php echo ($v['banji']['ruxuenian']); ?>级<?php echo ($v['banji']['banji']); ?>班</div>
			<?php if(is_array($v['student'])): foreach($v['student'] as $key=>$m): ?><div class="am-panel-hd"><?php echo ($m['mingcheng']); ?></div>
				<div class="am-panel-bd am-cf">
					<?php if(is_array($m['student'])): foreach($m['student'] as $key=>$n): ?><span class='am-u-sm-2 am-u-end '>
						<?php echo ($n['name']); ?>
						<?php if($n['zifenleiid'] != 0): ?>(<?php echo ($m['zifenlei'][$n['zifenleiid']-1]); ?>)<?php endif; ?>
						</span><?php endforeach; endif; ?>
				</div><?php endforeach; endif; ?>
		</div><?php endforeach; endif; ?>
	</div>
</body>
</html>