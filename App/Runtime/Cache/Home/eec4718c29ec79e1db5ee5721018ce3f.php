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
		<div class="am-panel-hd am-cf">教导处平台导航</div>
		<div class="am-panel-bd am-cf">
			<ul class="vedio-category-list">
				<li><a href="<?php echo U(GROUP_NAME.'/Pingyou/pingyou');?>">学生评优系统</a></li>
				<?php if(is_array($renwu)): foreach($renwu as $key=>$v): ?><li><a href="<?php echo U(GROUP_NAME.'/Enrollment/index',array('id'=>$v['id']));?>"><?php echo ($v['mingcheng']); ?></a></li><?php endforeach; endif; ?>
				<li><a href="<?php echo U(GROUP_NAME.'/Student/index');?>">本班学生列表</a></li>
			</ul>
		</div>
	</div>
	<div class="am-panel am-panel-secondary">
		<div class="am-panel-hd am-cf">修改密码</div>
		<div class="am-panel-bd am-cf">
			<form action="<?php echo U(GROUP_NAME.'/Jiaodaochu/password');?>" method="POST" class="am-form am-form-horizontal">
				<div class="am-form-group">
					<label for="doc-ipt-pwd-2" class="am-u-sm-2 am-form-label">密码</label>
					<div class="am-u-sm-4 am-u-end">
						<input type="password" name="password"  maxlength="10" id="doc-ipt-pwd-2" placeholder="设置一个新密码">
					</div>
				</div>
				<div class="am-form-group">
					<label for="doc-ipt-pwd-2" class="am-u-sm-2 am-form-label">重复密码</label>
					<div class="am-u-sm-4 am-u-end">
						<input type="password" name="repassword" maxlength="10" id="doc-ipt-pwd-2" placeholder="重复刚才密码">
					</div>
				</div>
				<div class="am-form-group">
					<div class="am-u-sm-6 am-u-end">
						<button type="submit" id="btnpassword" class="am-btn am-btn-primary am-center">更新密码</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$(function(){
		$('#btnpassword').click(function(event) {
			var pattern = /^[a-zA-Z0-9]{6,10}$/;
			var password = $('input[name=password]');
			var repassword = $('input[name=repassword]');
			//检测密码是否为空
			if(password.val()==''||repassword.val()==''){
				alert('请输入密码');
				return false;
			}
			if(password.val()!=repassword.val()){
				alert('两次密码不一致');
				return false;
			}
			password = password.val();
			var r = password.match(pattern);
			if(r==null){
				alert('请输入6-10位的数字字母密码');
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