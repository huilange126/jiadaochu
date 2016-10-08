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
<script type="text/javascript" src="__PUBLIC__/echart/echarts.common.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/echart/shine.js"></script>
    
<div class="am-g am-g-fixed am-margin-top">
	<div class="am-panel am-panel-secondary">
		<div class="am-panel-hd am-cf">学生基础信息<a href="<?php echo U(GROUP_NAME.'/Login/logout');?>" class="am-btn am-btn-primary am-btn-xs am-fr ">退出系统</a></div>
		<div class="am-panel-bd am-cf">
			<div class="am-u-md-2 am-u-sm-12">
				<label for="">学号</label>
				<?php echo ($student['xuehao']); ?>
			</div>
			<div class="am-u-md-2 am-u-sm-12">
				<label for="">姓名</label>
				<?php echo ($student['name']); ?>
			</div>
			<div class="am-u-md-4 am-u-sm-12 am-u-end">
				<label for="">班级</label>
				<?php echo ($student['ruxuenian']); ?>级<?php echo ($student['banji']); ?>班
			</div>
		</div>	
	</div>	
</div>
<div class="am-g am-g-fixed">
	<!-- 左侧导航栏开始 -->
	<div class="am-u-md-3 am-show-md-up">
	<div class="am-g">
		<div class="am-panel am-panel-secondary am-margin-right">
			<div class="am-panel-hd">右侧导航栏</div>
			<ul class="am-list am-list-border am-list-striped">
				<li><a href="#"><span class="am-icon-television am-success am-margin-right"></span>作业和完成情况</a></li>
				<li><a href="<?php echo U(GROUP_NAME.'/Index/index');?>"><span class="am-icon-television am-success am-margin-right"></span>平时练习成绩</a></li>
				<li><a href="#"><span class="am-icon-television am-success am-margin-right"></span>期末考试成绩</a></li>
				<li><a href="#"><span class="am-icon-television am-success am-margin-right"></span>个人信息</a></li>
			</ul>
		</div>
	</div>
</div>
	<!-- 左侧导航栏结束 -->
	<!-- 右侧主面板开始 -->
	<div class="am-u-md-9 am-u-sm-12">
		<div class="am-g">
			<div class="am-panel am-panel-secondary">
				<div class="am-panel-hd">考试成绩列表</div>
				<div class="am-panel-bd am-cf">
					<div class="am-g">
						<div class="am-u-sm-4 am-text-right">
							<label for="">学科：</label>
						</div>
						<div class="am-u-sm-8">
							<?php echo ($kaoshi['xueke']); ?>
						</div>
					</div>
					<div class="am-g">
						<div class="am-u-sm-4 am-text-right">
							<label for="">考试名称：</label>
						</div>
						<div class="am-u-sm-8">
							<?php echo ($kaoshi['mingcheng']); ?>
						</div>
					</div>
					<div class="am-g">
						<div class="am-u-sm-4 am-text-right">
							<label for="">考试时间：</label>
						</div>
						<div class="am-u-sm-8">
							<?php echo (date('Y-m-d',$kaoshi['shijian'])); ?>
						</div>
					</div>
					<div class="am-g">
						<div class="am-u-sm-4 am-text-right">
							<label for="">得分：</label>
						</div>
						<div class="am-u-sm-8">
							<?php echo ($kaoshi['defen']); ?>
						</div>
					</div>
					<div class="am-g">
						<div class="am-u-sm-4 am-text-right">
							<label for="">名次：</label>
						</div>
						<div class="am-u-sm-8">
							第<?php echo ($kaoshi['mingci']); ?>名
						</div>
					</div>
				</div>
			</div>
			<div class="am-u-sm-12">
				<div id="main123" style="width: 100%;height: 400px;overflow: hidden;margin:0;"></div>
			</div>
			
		</div>
	</div>
	<!-- 右侧主面板结束 -->
</div>
<script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('main123'),'shine');

        // 指定图表的配置项和数据
        option = {
        	title : {

        		text: '数据统计',
        		subtext: '得分分段',
        		x:'center'
        	},
        	tooltip : {
        		trigger: 'item',
        		formatter: "{a} <br/>{b} : {c} ({d}%)"
        	},
        	legend: {
        		
        		top:60,
        		show:true,
        		orient: 'horizontal',
        		left: 'center',
        		data: [<?php echo ($echartTitle); ?>]
        	},
        	series : [
        	{
        		name: '人数',
        		type: 'pie',
        		radius : '55%',
        		center: ['50%', '60%'],
        		data:[
        		<?php echo ($echartData); ?>
        		],
        		itemStyle: {
        			emphasis: {
        				shadowBlur: 10,
        				shadowOffsetX: 0,
        				shadowColor: 'rgba(0, 0, 0, 0.5)'
        			}
        		}
        	}
        	]
        };

        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    </script>
<footer>
	<p class="am-text-center"><?php echo (C("copyright")); ?></p>
</footer>
</body>
</html>