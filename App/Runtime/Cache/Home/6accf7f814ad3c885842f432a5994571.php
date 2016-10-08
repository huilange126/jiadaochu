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
		<div class="am-panel-hd am-cf">学生成绩列表 <a href="<?php echo U(GROUP_NAME.'/Student/index');?>" class="am-btn am-btn-warning am-margin-left am-btn-xs">返回学生列表</a></div>
		<table class="am-table am-table-bordered am-table-striped am-table-hover">
		<thead>
			<tr>
				<th colspan="7" class="am-active">
					学生信息：<?php echo ($student['xuehao']); echo ($student['name']); ?>
				</th>
			</tr>
			<tr>
				<th style="width:5%" class="am-text-center">序号</th>
				<th style="width:5%" class="am-text-center">学科</th>
				<th style="width:10%" class="am-text-center">考试日期</th>
				<th style="width:5%" class="am-text-center">分数</th>
				<th style="width:5%" class="am-text-center">名次</th>
				<th class="am-text-center">考试名称</th>
				
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if(is_array($kaoshi)): foreach($kaoshi as $key=>$v): ?><tr>
				<td class="am-text-center"><?php echo ++$num;?></td>
				<td class="am-text-center"><?php echo ($v['xueke']); ?></td>
				<td class="am-text-center"><?php echo (date('Y-m-d',$v['shijian'])); ?></td>
				<td class="am-text-center"><?php echo ($v['fenshu']); ?></td>
				<td class="am-text-center"><?php echo ($v['mingci']); ?></td>
				<td><?php echo ($v['mingcheng']); ?></td>
				
				<td>1</td>
			</tr><?php endforeach; endif; ?>
			<tr>
				<td colspan="7" class="am-active">
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