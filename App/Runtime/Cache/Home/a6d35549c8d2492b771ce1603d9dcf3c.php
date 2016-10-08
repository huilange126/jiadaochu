<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo (C("webname")); ?>教导处管理平台</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
	<link rel="stylesheet" type="text/css" href="__PUBLIC__/amazeui2.6/css/amazeui.min.css" />
	<link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/app.css" />

</head>
<style>
	.topheader{
		height:120px;
		background-color:#0e90d2;
		border:1px solid #efefef;
		},
	body{
			background-color: #efefef;
		}
	.banner{
		color: #ffffff;
	}
</style>
<body>
	<!--[if lt IE 9]>
	<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
	<script src="assets/js/amazeui.ie8polyfill.min.js"></script>
	<![endif]-->

	<!--[if (gte IE 9)|!(IE)]><!-->
	<script src="__PUBLIC__/amazeui2.6/js/jquery.min.js"></script>
	
	<!--<![endif]-->
	<script src="__PUBLIC__/amazeui2.6/js/amazeui.min.js"></script>
	<div class="am-g am-g-fixed topheader">
		<div class="am-u-md-2 am-u-sm-4">
			<img src="__ROOT__/Uploads/<?php echo (C("logo")); ?>" class="am-img-responsive am-fr am-padding-top-xs" style="height:110px;" alt="">
		</div>
		<div class="am-u-md-10 am-u-sm-8">
			<div class="am-g am-padding-left">
				<h1 class="am-padding-top-sm banner"><?php echo (C("webname")); ?></h1>
			</div>
			<div class="am-g am-padding-left">
				<h1 class=" banner"><?php echo (C("sysname")); ?></h1>
			</div>
		</div>
	</div>
<div class="am-g am-g-fixed am-margin-top">
	<?php echo W('BanjiInfo');?>
	<div class="am-panel am-panel-success">
		<div class="am-panel-hd am-cf">班级学生列表 <a href="<?php echo U(GROUP_NAME.'/Jiaodaochu/index');?>" class="am-btn am-btn-warning am-margin-left am-btn-xs">返回班级首页</a><a href="<?php echo U(GROUP_NAME.'/Chengji/index');?>" class="am-btn am-btn-success am-margin-left am-btn-xs">返回考试管理</a></div>
		<table class="am-table am-table-bordered am-table-striped am-table-hover">
		<thead>
			<tr>
				<th style="width:5%" class="am-text-center">序号</th>
				<th style="width:5%" class="am-text-center">学号</th>
				<th style="width:10%" class="am-text-center">姓名</th>
				<th style="width:5%" class="am-text-center">性别</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if(is_array($student)): foreach($student as $key=>$v): ?><tr>
				<td class="am-text-center"><?php echo ++$num;?></td>
				<td class="am-text-center"><?php echo ($v['xuehao']); ?></td>
				<td class="am-text-center"><?php echo ($v['name']); ?></td>
				<td class="am-text-center">
					<?php if($v['xingbie'] == 0): ?>女
					<?php else: ?>
						男<?php endif; ?>
				</td>
				<td>
					<a href="#" class="am-btn am-btn-primary am-btn-xs">基本信息</a>
					<a href="<?php echo U(GROUP_NAME.'/StudentFenshu/fenshuList',array('student'=>$v['id']));?>" class="am-btn am-btn-success am-btn-xs">考试成绩</a>
				</td>
			</tr><?php endforeach; endif; ?>
			<tr>
				<td colspan="5">
					<ul class="am-pagination">
					<?php echo ($show); ?>
					</ul>
				</td>
			</tr>
		</tbody>
		</table>
	</div>
</div>
<footer>
	<p class="am-text-center"><?php echo (C("copyright")); ?></p>
</footer>
</body>
</html>