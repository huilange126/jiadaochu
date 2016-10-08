<?php if (!defined('THINK_PATH')) exit();?>	<!DOCTYPE html>
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
			<h1 class="am-padding-top-xl banner"><?php echo (C("webname")); echo ($appname); ?></h1>
		</div>
	</div>
	<div class="am-g am-g-fixed am-margin-top">
		<div class="am-panel am-panel-secondary">
		<div class="am-panel-hd am-cf">教师信息<a href="<?php echo U(GROUP_NAME.'/Banji/logout');?>" class="am-btn am-btn-primary am-btn-xs am-fr">退出评价</a></div>
			<div class="am-panel-bd">
				姓名：<?php echo ($teacher['name']); ?>
			</div>
		</div>
	</div>
	<div class="am-g am-g-fixed am-margin-top">
		<div class="am-panel am-panel-secondary">
		<div class="am-panel-hd"><?php echo ($term['name']); ?>任课班级列表<span class=" am-margin-left am-text-danger"><?php if($status == true): ?>已经评价<?php else: ?>还未评价<?php endif; ?></span></div>
			<div class="am-panel-bd">
				<form action="<?php echo U(GROUP_NAME.'/Banji/pingjiaHandle');?>" method="POST" class="am-form">
				<input type="hidden" name="banjicount" value="<?php echo ($banjicount); ?>">
				<input type="hidden" name="term" value="<?php echo ($term['id']); ?>">
				<input type="hidden" name="teacher" value="<?php echo ($teacher['id']); ?>">
				<?php if(is_array($teacher['banji'])): foreach($teacher['banji'] as $key=>$v): ?><div class="am-form-group">
						<label for="doc-ipt-file-1"><?php echo ($v['ruxuenian']); ?>级<?php echo ($v['banji']); ?>班</label><br>
						<?php if(is_array($mingcheng)): foreach($mingcheng as $xxkey=>$m): ?><label class="am-radio-inline">
							<input type="radio" name="pingjia[<?php echo ($v['id']); ?>]" value="<?php echo ($fenzhi[$xxkey]); ?>" <?php if($v['defen'] == $fenzhi[$xxkey]): ?>checked='checked'<?php endif; ?>> <?php echo ($m); ?>
							</label><?php endforeach; endif; ?>
					</div><?php endforeach; endif; ?>
				<div class="am-form-group">
						<button class="am-btn am-btn-primary" id="btn" type="submit">评价班级</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script>
		$(function(){
			var banjicount = "<?php echo ($banjicount); ?>";
			var jishu = 0;
			$('#btn').click(function(){
				var allbanji = $('input[type=radio]:checked');
				if(allbanji.length!=banjicount){
					alert('有班级还没有评');
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