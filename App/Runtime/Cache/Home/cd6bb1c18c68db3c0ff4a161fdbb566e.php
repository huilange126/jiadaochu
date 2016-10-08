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
		<div class="am-u-sm-2">
			<img src="__ROOT__/Uploads/<?php echo (C("logo")); ?>" class="am-img-responsive am-fr am-padding-top-xs" style="height:110px;" alt="">
		</div>
		<div class="am-u-sm-10">
			<h1 class="am-padding-top-xl banner"><?php echo (C("webname")); ?>::<?php echo (C("sysname")); ?></h1>
		</div>
	</div>
<div class="am-g am-g-fixed am-margin-top">
	<?php echo W('BanjiInfo');?>
	<div class="am-panel am-panel-success">
		<div class="am-panel-hd am-cf">班级学生列表 <a href="<?php echo U(GROUP_NAME.'/Chengji/detail',array('id'=>$kaoshi['id']));?>" class="am-btn am-btn-warning am-margin-left am-btn-xs">返回考试成绩列表</a></div>
		<div class="am-panel-bd">
			<form class="am-form am-form-horizontal" action="<?php echo U(GROUP_NAME.'/Chengji/dangechengjiHandle');?>" method="POST">
				<div class="am-form-group">
					<label for="doc-ipt-3" class="am-u-md-2 am-form-label">学号</label>
					<div class="am-u-md-3 am-u-end">
						<select id="doc-select-1" name="student">
							<option value="0">请选择学生</option>
							<?php if(is_array($student)): foreach($student as $key=>$v): ?><option value="<?php echo ($v['id']); ?>"><?php echo ($v['xuehao']); echo ($v['name']); ?></option><?php endforeach; endif; ?>
						</select>
						<span class="am-form-caret"></span>
					</div>
				</div>
				<div class="am-form-group">
					<label for="doc-ipt-3" class="am-u-md-2 am-form-label">考试名称</label>
					<div class="am-u-md-3 am-u-end">
						<input type="text" readonly="" value="<?php echo ($kaoshi['mingcheng']); ?>">
					</div>
				</div>
				<div class="am-form-group">
					<label for="doc-ipt-3" class="am-u-md-2 am-form-label">考试时间</label>
					<div class="am-u-md-3 am-u-end">
						<input type="text" readonly="" value="<?php echo (date('Y-m-d',$kaoshi['shijian'])); ?>">
					</div>
				</div>
				<div class="am-form-group">
					<label for="doc-ipt-3" class="am-u-md-2 am-form-label">得分</label>
					<div class="am-u-md-3 am-u-end">
						<input type="hidden" name="kaoshi" value="<?php echo ($kaoshi['id']); ?>">
						<input type="text" value="<?php echo ($chengji['fenshu']); ?>" name="fenshu">
					</div>
				</div>
				<div class="am-form-group">
					<div class="am-u-md-6 am-u-end">
						<button class="am-btn am-btn-primary am-center" id="btnadd">修改成绩</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<footer>
	<p class="am-text-center"><?php echo (C("copyright")); ?></p>
</footer>
</body>
</html>