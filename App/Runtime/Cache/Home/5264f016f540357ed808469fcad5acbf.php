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
		<div class="am-panel-bd">
		[<?php echo ($enrollment['mingcheng']); ?>]相关说明：每人限报<?php echo ($enrollment['renshu']); ?>个项目。开始时间<?php echo (date('Y-m-d',$enrollment['start'])); ?>；截止时间<?php echo (date('Y-m-d',$enrollment['end'])); ?>。
		</div>
	</div>
	<div class="am-panel am-panel-secondary">
		<div class="am-panel-hd am-cf">
		[<?php echo ($enrollment['mingcheng']); ?>]项目列表
		<a href="<?php echo U(GROUP_NAME.'/Enrollment/bmlist',array('eid'=>$enrollment['id'],'type'=>1));?>" class="am-btn am-btn-success am-btn-xs " target="_blank">查看报名情况</a>
		<a href="<?php echo U(GROUP_NAME.'/Jiaodaochu/index');?>" class="am-btn am-btn-warning am-btn-xs">返回班级首页</a>
		</div>
		<div class="am-panel-bd am-cf">
			<ul class="vedio-category-list">
				<?php if(is_array($content)): foreach($content as $key=>$v): ?><li><a href="<?php echo U(GROUP_NAME.'/Enrollment/index',array('id'=>$enrollment['id'],'nid'=>$v['id']));?>"><?php echo ($v['mingcheng']); ?></a></li><?php endforeach; endif; ?>
			</ul>
		</div>
	</div>
	<div class="am-panel am-panel-secondary">
		<div class="am-panel-hd am-cf">
		<?php if(empty($nowContent)): ?>请选择报名项目
		<?php else: ?>
			正在进行：<span class="am-text-danger"><?php echo (getcontent($nowContent)); ?></span><?php endif; ?>
		</div>
		<div class="am-panel-bd am-cf">
			<form action="" method="POST" class="am-form">
				<div class="am-g">
					<div class="am-u-sm-5">
						<div class="am-form-group">
						<label for="doc-select-2">班级学生列表</label>
							<select multiple size="20" name="student" class="" id="doc-select-2">
								<?php if(is_array($student)): foreach($student as $key=>$v): ?><option value="<?php echo ($v['id']); ?>">&nbsp;<?php echo ($v['xuehao']); ?>&nbsp;&nbsp;<?php if($v['xingbie'] == 1): ?>男<?php else: ?>女<?php endif; ?>&nbsp;&nbsp;<?php echo ($v['name']); ?></option><?php endforeach; endif; ?>
							</select>
						</div>
					</div>
					<div class="am-u-sm-2">
						<div class="am-form-group am-text-center">
							<label for="">操作</label>
							<button type="button" id="btnadd" class="am-btn am-btn-primary am-margin-top">添加>>>></button>
							<button type="button" id="btnremove" class="am-btn am-btn-warning am-margin-top"><<<<移除</button>
							<label for="" class="am-margin-top">提示：双击学生名也可以进行操作</label>
						</div>
					</div>
					<div class="am-u-sm-5">
						<div class="am-form-group">
						<label for="doc-select-2">已报学生列表</label>
							<select multiple name="addlist" size="20" class="" id="doc-select-2">
							<?php if(is_array($enrollStudent)): foreach($enrollStudent as $key=>$v): ?><option value="<?php echo ($v['id']); ?>">&nbsp;<?php echo ($v['xuehao']); ?>&nbsp;&nbsp;<?php if($v['xingbie'] == 1): ?>男<?php else: ?>女<?php endif; ?>&nbsp;&nbsp;<?php echo ($v['name']); ?></option><?php endforeach; endif; ?>
							</select>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
		var enrollment = "<?php echo ($enrollment['id']); ?>";
		var content = "<?php echo ($nowContent['id']); ?>";
		var banji = "<?php echo ($banji['id']); ?>";

		var url = "<?php echo U(GROUP_NAME.'/Enrollment/ajaxAdd');?>";
		// var enrollment = "<?php echo ($nowContent['id']); ?>";
</script>
<script type="text/javascript" src="__PUBLIC__/Js/enrollment.js"></script>
<div class="am-modal am-modal-alert" tabindex="-1" id="my-alert">
  <div class="am-modal-dialog" style="width: 500px;">
    <div class="am-modal-hd" style="background-color: #F37B1D;border-bottom: solid 1px #efefef;">提示信息</div>
    <div class="am-modal-bd am-text-left" style="padding-top: 30px;padding-bottom: 30px;">
      Hello world！
    </div>
    <div class="am-modal-footer">
      <span class="am-modal-btn">确定</span>
    </div>
  </div>
</div>
<footer>
	<p class="am-text-center"><?php echo (C("copyright")); ?></p>
</footer>
</body>
</html>