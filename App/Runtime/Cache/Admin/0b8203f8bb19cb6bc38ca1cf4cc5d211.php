<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo ($pageName); ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="format-detection" content="telephone=no">
	<meta name="renderer" content="webkit">
	<meta http-equiv="Cache-Control" content="no-siteapp"/>
	<link rel="stylesheet" type="text/css" href="__PUBLIC__/amazeui2.6/css/amazeui.min.css" />
</head>
<body>
<div class="am-g am-padding">
	<div class="am-panel am-panel-secondary">
		<div class="am-panel-hd">学生德育信息表</div>
		<table class="am-table am-table-bordered">
			<tbody>
				<tr class="am-active">
					<td>学号</td>
					<td><?php echo ($student['xuehao']); ?></td>
					<td>姓名</td>
					<td><?php echo ($student['name']); ?></td>
					<td>性别</td>
					<td><?php echo (getsex($student['xingbie'])); ?></td>
				</tr>
				<tr>
					<td>德育信息</td>
					<td colspan="5">
						<?php if(is_array($student['jiangcheng'])): foreach($student['jiangcheng'] as $key=>$v): echo (date('Y-m-d',$v['riqi'])); ?>
							<?php echo (getjiangchengleixing($v['leixing'])); ?>
							<?php echo ($v['miaoshu']); endforeach; endif; ?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="__PUBLIC__/amazeui2.6/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="__PUBLIC__/amazeui2.6/js/amazeui.min.js"></script>
</body>
</html>