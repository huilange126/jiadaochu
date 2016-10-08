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
		<div class="am-panel-hd am-cf">学生成绩管理 <a href="<?php echo U(GROUP_NAME.'/Jiaodaochu/index');?>" class="am-btn am-btn-success am-margin-left am-btn-xs">返回班级首页</a></div>
		<table class="am-table am-table-bordered am-table-striped am-table-hover">
			<thead>
			<tr class="am-active">
					<th colspan="5">历次考试列表
					[<a href="<?php echo U(GROUP_NAME.'/Chengji/addKaoshi');?>">添加考试</a>]
					[<a href="<?php echo U(GROUP_NAME.'/Student/index');?>">学生列表</a>]
					</th>
				</tr>
			</thead>
			<tbody>
				<tr class="am-success">
					<td class="am-text-center" style="width:5%">序号</td>
					<td class="am-text-center" style="width:10%">科目</td>
					<td class="am-text-center" style="width:10%">考试时间</td>
					<td>考试名称</td>
					<td style="width:25%">操作</td>
				</tr>
				<?php if(is_array($kaoshi)): foreach($kaoshi as $key=>$v): ?><tr>
					<td class="am-text-center"><?php echo ++$num;?></td>
					<td class="am-text-center"><?php echo ($v['xueke']); ?></td>
					<td class="am-text-center"><?php echo (date('Y-m-d',$v['shijian'])); ?></td>
					<td><?php echo ($v['mingcheng']); ?></td>
					<td>
						<ul class="am-nav">
							<li class="am-dropdown" data-am-dropdown>
								<a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
									操作选项 <span class="am-icon-caret-down"></span>
								</a>
								<ul class="am-dropdown-content">
									<li><a href="<?php echo U(GROUP_NAME.'/Chengji/detail',array('id'=>$v['id']));?>">查看成绩</a></li>
									<li><a href="<?php echo U(GROUP_NAME.'/Chengji/daoru',array('id'=>$v['id']));?>">导入成绩</a></li>
									<li><a href="<?php echo U(GROUP_NAME.'/Chengji/dangechengji',array('id'=>$v['id']));?>">添加单个成绩</a></li>
									<li><a href="<?php echo U(GROUP_NAME.'/Chengji/modifyKaoshi',array('id'=>$v['id']));?>">编辑考试</a></li>
									<li><a href="<?php echo U(GROUP_NAME.'/Chengji/del',array('id'=>$v['id']));?>">删除考试</a></li>
								</ul>
							</li>
						</ul>
					<!-- <a href="<?php echo U(GROUP_NAME.'/Chengji/detail',array('id'=>$v['id']));?>" class="am-btn am-btn-success am-btn-xs">查看成绩</a>
					<a href="<?php echo U(GROUP_NAME.'/Chengji/daoru',array('id'=>$v['id']));?>" class="am-btn am-btn-success am-btn-xs">导入成绩</a>
					<a href="<?php echo U(GROUP_NAME.'/Chengji/dangechengji',array('id'=>$v['id']));?>" class="am-btn am-btn-success am-btn-xs">添加单个成绩</a>
					<a href="<?php echo U(GROUP_NAME.'/Chengji/modifyKaoshi',array('id'=>$v['id']));?>" class="am-btn am-btn-primary am-btn-xs">编辑考试</a>
					<a href="<?php echo U(GROUP_NAME.'/Chengji/del',array('id'=>$v['id']));?>" class="am-btn am-btn-danger am-btn-xs" name="del">删除考试</a> -->
					</td>
				</tr><?php endforeach; endif; ?>
				<tr>
					<td colspan="5" class="am-active">
						<ul class="am-pagination">
							<?php echo ($show); ?>
						</ul>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<script>
	$(function(){

		$('a[name=del]').click(function(event) {
			return confirm('确定要删除这个考试？');
		});
	});
</script>
<footer>
	<p class="am-text-center"><?php echo (C("copyright")); ?></p>
</footer>
</body>
</html>