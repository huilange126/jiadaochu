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
		<div class="am-panel-hd am-cf">考试成绩导入 <a href="<?php echo U(GROUP_NAME.'/Chengji/index');?>" class="am-btn am-btn-success am-margin-left am-btn-xs">返回考试列表</a></div>
		<div class="am-panel-bd">
			<form class="am-form am-form-horizontal" action="<?php echo U(GROUP_NAME.'/Chengji/daoruHandle');?>" method="POST"  enctype='multipart/form-data'>
				<input type="hidden" name="kaoshiId" value="<?php echo ($kaoshi['id']); ?>">
				<div class="am-form-group">
					<label for="doc-ipt-3" class="am-u-md-2 am-form-label">考试科目</label>
					<div class="am-u-md-3 am-u-end">
						<input type="text" readonly="" value="<?php echo ($kaoshi['xueke']); ?>">
					</div>
				</div>
				<div class="am-form-group">
					<label for="doc-ipt-3" class="am-u-md-2 am-form-label">考试时间</label>
					<div class="am-u-md-3 am-u-end">
						<input type="text" readonly="" value="<?php echo (date('Y-m-d',$kaoshi['shijian'])); ?>">
					</div>
				</div>
				<div class="am-form-group">
					<label for="doc-ipt-3" class="am-u-md-2 am-form-label">所属班级</label>
					<div class="am-u-md-3 am-u-end">
						<input type="text" readonly="" value="<?php echo ($kaoshi['ruxuenian']); ?>级<?php echo ($kaoshi['banji']); ?>班">
					</div>
				</div>
				<div class="am-form-group">
					<label for="doc-ipt-3" class="am-u-md-2 am-form-label">考试名称</label>
					<div class="am-u-md-6 am-u-end">
						<input type="text" readonly="" value="<?php echo ($kaoshi['mingcheng']); ?>">
					</div>
				</div>
				<div class="am-form-group">
					<label for="doc-ipt-file-2"  class="am-u-md-2 am-form-label">选择文件</label>
					<div  class="am-u-md-4 am-u-end">
						<input type="file" id="doc-ipt-file-1" name="excel">
						<p class="am-form-help">请选择要上传的文件...</p>
					</div>
				</div>
				<div class="am-form-group">
					<div class="am-u-md-6 am-u-end">
						<button class="am-btn am-btn-primary am-center" id="btnadd">导入成绩</button>
					</div>
				</div>
			</form>
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

			if($('input[type=file]').val()==''){
				$('.am-modal-bd').html('<h2 class="am-text-danger">请选择成绩文件</h2>');
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