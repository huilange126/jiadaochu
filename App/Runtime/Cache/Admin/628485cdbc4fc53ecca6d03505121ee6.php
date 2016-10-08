<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script type="text/javascript" src="__PUBLIC__/Admin/Js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/Admin/Js/index.js"></script>
<link rel="stylesheet" href="__PUBLIC__/Admin/Css/public.css" />
<link rel="stylesheet" href="__PUBLIC__/Admin/Css/index.css" />
<link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.5.2/css/amazeui.min.css" />
<script type="text/javascript" src="http://cdn.amazeui.org/amazeui/2.5.2/js/amazeui.min.js"></script>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<base target="iframe"/>
<title>后台管理</title>
<head>
</head>
<style>
	dt{
		cursor: pointer;
	}
</style>
<script>
	$(function(){
		$('dl').find('dd').hide();

		$('dl').find('dt').toggle(function(){
			$(this).parent("dl").find('dd').show();
		},function(){
			$(this).parent("dl").find('dd').hide();
		});
	});
</script>

<body>
	<div id="top">
		<img class="logo" src="__ROOT__/Uploads/<?php echo (C("logo")); ?>" alt="" />
		<span class="logo-title"><?php echo (C("webname")); ?>：：<?php echo (C("sysname")); ?>：：后台管理</span>
		<div class="exit">
			<a href="<?php echo U(GROUP_NAME.'/Index/logout');?>" target="_self">退出</a>
		</div>
	</div>
	<div id="left">
		<dl>
			<dt><i class="am-icon-book am-icon-sm am-margin-right-xs"></i>基础信息管理</dt>
            <dd><a href="<?php echo U(GROUP_NAME.'/Term/index');?>">学期列表</a></dd>
			<dd><a href="<?php echo U(GROUP_NAME.'/Xueke/index');?>">学科列表</a></dd>
            <dd><a href="<?php echo U(GROUP_NAME.'/Teacher/index');?>">教师列表</a></dd>
			<dd><a href="<?php echo U(GROUP_NAME.'/Teacher/teacher');?>">添加教师</a></dd>
		</dl>
		<dl>
			<dt><i class="am-icon-home am-icon-sm am-margin-right-xs"></i>班级管理</dt>
			<dd><a href="<?php echo U(GROUP_NAME.'/Banji/nianji');?>">设定当前年级</a></dd>
			<dd><a href="<?php echo U(GROUP_NAME.'/Banji/index');?>">班级列表</a></dd>
			<dd><a href="<?php echo U(GROUP_NAME.'/Banji/banji');?>">添加年级</a></dd>
            <dd><a href="<?php echo U(GROUP_NAME.'/Renke/renke');?>">新学期任教管理</a></dd>
		</dl>
		<dl>
			<dt><i class="am-icon-child am-icon-sm am-margin-right-xs"></i>学生管理</dt>
			<dd><a href="<?php echo U(GROUP_NAME.'/Student/set');?>">学号信息设置</a></dd>
			<dd><a href="<?php echo U(GROUP_NAME.'/Student/index');?>">学生列表</a></dd>
			<dd><a href="<?php echo U(GROUP_NAME.'/Student/export');?>">导入学生</a></dd>
			<dd><a href="<?php echo U(GROUP_NAME.'/Student/add');?>">单个学生添加</a></dd>
		</dl>
		<dl>
			<dt><i class="am-icon-area-chart am-icon-sm am-margin-right-xs"></i>成绩管理</dt>
			<dd><a href="<?php echo U(GROUP_NAME.'/Chengji/index');?>">修改成绩</a></dd>
			<dd><a href="<?php echo U(GROUP_NAME.'/Chengji/daoru');?>">导入成绩</a></dd>
		</dl>
		<dl>
			<dt><i class="am-icon-database am-icon-sm am-margin-right-xs"></i>德育管理</dt>
			<dd><a href="<?php echo U(GROUP_NAME.'/Deyu/searchStudent');?>">添加奖惩</a></dd>
			<dd><a href="<?php echo U(GROUP_NAME.'/Deyu/index');?>">奖惩列表</a></dd>
		</dl>
        <dl>
            <dt><i class="am-icon-heart am-icon-sm am-margin-right-xs"></i>评价项目管理</dt>
            <dd><a href="<?php echo U(GROUP_NAME.'/Project/index');?>">项目列表</a></dd>
            <dd><a href="<?php echo U(GROUP_NAME.'/Project/project');?>">添加项目</a></dd>
            <!-- <dd><a href="<?php echo U(GROUP_NAME.'/Project/optionList');?>">选项列表</a></dd> -->
        </dl>
        <dl>
        	<dt><i class="am-icon-cubes am-icon-sm am-margin-right-xs"></i>报名任务管理</dt>
        	<dd><a href="<?php echo U(GROUP_NAME.'/Enrollment/add');?>">添加报名任务</a></dd>
        	<dd><a href="<?php echo U(GROUP_NAME.'/Enrollment/index');?>">报名任务列表</a></dd>
        </dl>
        <dl>
        	<dt><i class="am-icon-flag am-icon-sm am-margin-right-xs"></i>学生评优管理</dt>
        	<dd><a href="<?php echo U(GROUP_NAME.'/Sanhao/index');?>">评优项目列表</a></dd>
        	<dd><a href="<?php echo U(GROUP_NAME.'/Sanhao/add');?>">添加评优项目</a></dd>
        	<dd><a href="<?php echo U(GROUP_NAME.'/Sanhao/termList');?>">评优结果列表</a></dd>
        </dl>
        <dl>
            <dt><i class="am-icon-magic am-icon-sm am-margin-right-xs"></i>优秀班集体评价</dt>
            <dd><a href="<?php echo U(GROUP_NAME.'/Pingyou/setsystem');?>">设置评分项分值</a></dd>
            <dd><a href="<?php echo U(GROUP_NAME.'/Pingyou/index');?>">教师状态列表</a></dd>
            <dd><a href="<?php echo U(GROUP_NAME.'/Pingyou/result');?>">优秀班集体评价结果</a></dd>
        </dl>
        <dl>
            <dt><i class="am-icon-cog am-icon-sm am-margin-right-xs"></i>系统设置</dt>
            <dd><a href="<?php echo U(GROUP_NAME.'/System/index');?>">系统设置</a></dd>
        </dl>
        <dl>
        	<dt><i class="am-icon-group am-icon-sm am-margin-right-xs"></i>管理员设置</dt>
        	<dd><a href="<?php echo U(GROUP_NAME.'/Admin/index');?>">管理员列表</a></dd>
        	<dd><a href="<?php echo U(GROUP_NAME.'/Admin/add');?>">添加管理员</a></dd>
        </dl>
	</div>
	<div id="right">
		<iframe name="iframe" src="<?php echo U(GROUP_NAME.'/System/index');?>"></iframe>
	</div>
</body>
</html>