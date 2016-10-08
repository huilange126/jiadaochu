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
	<div class="am-panel am-panel-warning">
		<div class="am-panel-hd am-cf">添加新的考试 <a href="<?php echo U(GROUP_NAME.'/Chengji/index');?>" class="am-btn am-btn-success am-margin-left am-btn-xs">返回考试管理</a></div>
		<div class="am-panel-bd">
			<form class="am-form am-form-horizontal" action="<?php echo U(GROUP_NAME.'/Chengji/addHandle');?>" method="POST">
				<div class="am-form-group">
					<label for="doc-ipt-3" class="am-u-md-2 am-form-label">考试科目</label>
					<div class="am-u-md-3 am-u-end">
						<select id="doc-select-1" name="xueke">
							<option value="0">请选择学科</option>
							<?php if(is_array($xueke)): foreach($xueke as $key=>$v): ?><option value="<?php echo ($v['id']); ?>"><?php echo ($v['xueke']); ?></option><?php endforeach; endif; ?>
						</select>
						<span class="am-form-caret"></span>
					</div>
				</div>
				<div class="am-form-group">
					<label for="doc-ipt-3" class="am-u-md-2 am-form-label">考试名称</label>
					<div class="am-u-md-6 am-u-end">
						<input type="text" name="mingcheng" placeholder="请添加考试名称">
					</div>
				</div>
				<div class="am-form-group">
					<label for="doc-ipt-3" class="am-u-md-2 am-form-label">考试时间</label>
					<div class="am-u-md-2 am-u-end">
						<input type="text" name="shijian" class="am-form-field" placeholder="考试时间" data-am-datepicker readonly required />
					</div>
				</div>
				<div class="am-form-group">
					<label for="doc-ipt-3" class="am-u-md-2 am-form-label">满分</label>
					<div class="am-u-md-2 am-u-end">
						<input type="text" name="manfen" class="am-form-field" placeholder="满分值" />
					</div>
				</div>
				<div class="am-form-group">
					<div class="am-u-md-6 am-u-end">
						<button class="am-btn am-btn-primary am-center" id="btnadd">添加考试</button>
					</div>
				</div>
			</div>
	</div>
</div>
<div class="am-modal am-modal-alert" tabindex="-1" id="my-alert">
	<div class="am-modal-dialog">
		<div class="am-modal-hd">提示信息</div>
		<div class="am-modal-bd">
			Hello world！
		</div>
		<div class="am-modal-footer">
			<span class="am-modal-btn">确定</span>
		</div>
	</div>
</div>
<script>
	$(function(){
		$('#btnadd').click(function(){
			if($('select[name=xueke]').val()==0){
				$('.am-modal-bd').html('<h2 class="am-text-danger">请选择学科</h2>');
				$('#my-alert').modal();
				return false;
			}
			if($('input[name=mingcheng]').val()==''){
				$('.am-modal-bd').html('<h2 class="am-text-danger">请添加考试名称</h2>');
				$('#my-alert').modal();
				return false;
			}
			if($('input[name=shijian]').val()==''){
				$('.am-modal-bd').html('<h2 class="am-text-danger">请选择考试时间</h2>');
				$('#my-alert').modal();
				return false;
			}
			
		});
	});
</script>
<footer>
	<p class="am-text-center"><?php echo (C("copyright")); ?></p>
</footer>
</body>
</html>