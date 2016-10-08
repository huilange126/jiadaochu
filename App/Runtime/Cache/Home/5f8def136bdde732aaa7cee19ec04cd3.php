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
	<div class="am-panel am-panel-secondary">
		<div class="am-panel-hd am-cf">
			<?php echo ($enrollment['mingcheng']); ?>报名情况查看
			<a href="<?php echo U(GROUP_NAME.'/Enrollment/bmlist',array('eid'=>$enrollment['id'],'type'=>1));?>" class="am-btn am-btn-success am-btn-xs am-margin-left">按照项目查看</a>
			<a href="<?php echo U(GROUP_NAME.'/Enrollment/bmlist',array('eid'=>$enrollment['id'],'type'=>0));?>" class="am-btn am-margin-left am-btn-secondary am-btn-xs ">按照学生查看</a>
			<a href="<?php echo U(GROUP_NAME.'/Enrollment/bmlist',array('eid'=>$enrollment['id'],'type'=>2));?>" class="am-btn am-margin-left am-btn-warning am-btn-xs ">导出学生报名情况</a>

		</div>
		<div class="am-panel-bd am-cf">
			<?php if($type == 1): if(is_array($enrollment['content'])): foreach($enrollment['content'] as $key=>$v): ?><div class="am-panel am-panel-default">
						<div class="am-panel-hd"><?php echo ($v['mingcheng']); ?></div>
						<div class="am-panel-bd am-cf">
							<?php if(is_array($v['student'])): foreach($v['student'] as $key=>$m): ?><div class="am-u-sm-3 am-u-end">
									<?php echo ($m['xuehao']); echo ($m['name']); ?>
								</div><?php endforeach; endif; ?>
						</div>
					</div><?php endforeach; endif; endif; ?>
			<?php if($type == 0): ?><ul class="am-list am-list-static">
					<?php if(is_array($student)): foreach($student as $key=>$v): ?><li>
						<div class="am-g">
						<div class="am-u-sm-2 am-u-end">
							<?php echo ($v['xuehao']); echo ($v['name']); ?>
						</div>
						<div class="am-u-sm-10">
							<?php if(is_array($v['enrollment'])): foreach($v['enrollment'] as $key=>$m): ?><span class="am-text-warning am-padding-left am-padding-right"><?php echo ($m['mingcheng']); ?></span><?php endforeach; endif; ?>		
						</div>
						</div>
						</li><?php endforeach; endif; ?>
				</ul><?php endif; ?>
		</div>
	</div>
</div>
<footer>
	<p class="am-text-center"><?php echo (C("copyright")); ?></p>
</footer>
</body>
</html>