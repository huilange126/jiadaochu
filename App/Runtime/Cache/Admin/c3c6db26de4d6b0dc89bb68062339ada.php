<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo ($pageName); ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="format-detection" content="telephone=no">
	<meta name="renderer" content="webkit">
	<meta http-equiv="Cache-Control" content="no-siteapp"/>
	<link rel="stylesheet" type="text/css" href="__PUBLIC__/amazeui2.6/css/amazeui.min.css" />
</head>
<body>
<div class="am-g am-padding">
	<div class="am-panel am-panel-secondary">
		<div class="am-panel-hd">德育奖惩信息搜索</div>
		<!-- 学生信息搜索框开始 -->
		<div class="am-panel-bd">
			<form class="am-form am-form-horizontal" method="POST" action="<?php echo U(GROUP_NAME.'/Deyu/index');?>">
				<div class="am-form-group">
					<label for="doc-ipt-3" class="am-u-sm-2 am-form-label">输入学号或者姓名</label>
					<div class="am-u-sm-4 am-u-end">
						<input type="text" name="keywords" class="am-form-field" placeholder="输入关键字"/>
					</div>
				</div>
				<div class="am-form-group">
					<label for="doc-ipt-3" class="am-u-sm-2 am-form-label">输入描述信息关键字</label>
					<div class="am-u-sm-4 am-u-end">
						<input type="text" name="miaoshu" class="am-form-field" placeholder="输入描述信息关键字"/>
					</div>
				</div>
				<div class="am-form-group">
					<label for="doc-ipt-3" class="am-u-sm-2 am-form-label">选择开始日期</label>
					<div class="am-u-sm-2 am-u-end">
						<input type="text" name="shijianStart" class="am-form-field" placeholder="选择开始日期" data-am-datepicker readonly required value="" />
					</div>
					<label for="doc-ipt-3" class="am-u-sm-2 am-form-label">选择截止日期</label>
					<div class="am-u-sm-2 am-u-end">
						<input type="text" name="shijianEnd" class="am-form-field" placeholder="选择截止日期" data-am-datepicker readonly required value="" />
					</div>
				</div>
				<div class="am-form-group">
					<label for="doc-ipt-3" class="am-u-sm-2 am-form-label">信息类型</label>
					<div class="am-u-sm-4 am-u-end">
						<div class="am-form-group">
							<label class="am-radio-inline">
								<input type="radio" value="1" name="leixing"> 奖励信息
							</label>
							<label class="am-radio-inline">
								<input type="radio" value="2" name="leixing"> 惩罚信息
							</label>
							<label class="am-radio-inline">
								<input type="radio" value="3" name="leixing"> 其他
							</label>
							<label class="am-radio-inline">
								<input type="radio" checked="checked"  value="0" name="leixing"> 不限
							</label>
						</div>
					</div>
				</div>
				<div class="am-form-group">
					<div class="am-u-sm-6 am-u-end">
						<button class="am-btn am-btn-primary am-center">搜索德育奖惩信息</button>
					</div>
				</div>
			</form>
		</div>
		<!-- 学生信息搜索框结束 -->
		<!-- 搜索结果列表开始 -->
		<!-- 导出EXCEL结果 -->
		<table class="am-table am-table-bordered am-table-striped am-table-hover">
			<thead>
				<tr class="am-primary">
					<th class="am-text-center" style="width: 5%">序号</th>
					<th class="am-text-center" style="width: 10%">学号</th>
					<th class="am-text-center" style="width: 10%">姓名</th>
					<th class="am-text-center" style="width: 5%">性别</th>
					<th class="am-text-center" style="width: 5%">类型</th>
					<th class="am-text-center" style="width: 10%">添加时间</th>
					<th>描述信息</th>
					<th>操作
					<?php if($jiangchengIdList != ''): ?><a href="<?php echo U(GROUP_NAME.'/Deyu/daochuExcel',array('search'=>$jiangchengIdList));?>" class="am-btn am-btn-warning am-btn-xs am-fr">导出EXCEL结果</a><?php endif; ?>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($jiangcheng)): foreach($jiangcheng as $key=>$v): ?><tr class="am-active">
					<td class="am-text-center"><?php echo ++$num;?></td>
					<td class="am-text-center"><?php echo ($v['student']['xuehao']); ?></td>
					<td class="am-text-center"><?php echo ($v['student']['name']); ?></td>
					<td class="am-text-center"><?php echo (getsex($v['student']['xingbie'])); ?></td>
					<td class="am-text-center"><?php echo (getjiangchengleixing($v['leixing'])); ?></td>
					<td class="am-text-center"><?php echo (date('Y-m-d',$v['riqi'])); ?></td>
					<td><?php echo ($v['miaoshu']); ?></td>
					<td>
						<a href="<?php echo U(GROUP_NAME.'/Deyu/detail',array('id'=>$v['student']['id']));?>" class="am-btn am-btn-primary am-btn-xs">查看该学生德育报告</a>
						<a href="<?php echo U(GROUP_NAME.'/Deyu/edit',array('id'=>$v['id']));?>" class="am-btn am-btn-success am-btn-xs">编辑</a>
						<a href="<?php echo U(GROUP_NAME.'/Deyu/del',array('id'=>$v['id']));?>" onclick="return del();" class="am-btn am-btn-danger am-btn-xs">删除</a>
					</td>
				</tr><?php endforeach; endif; ?>
				<tr>
					<td colspan="8">
						<ul class="am-pagination">
						<?php echo ($show); ?>
						</ul>
					</td>
				</tr>
			</tbody>
		</table>
		<!-- 搜索结果列表结束 -->
	</div>
</div>
	<script>
		function del(){
			return confirm('确定要删除么？');
		}
	</script>
<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="__PUBLIC__/amazeui2.6/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="__PUBLIC__/amazeui2.6/js/amazeui.min.js"></script>
</body>
</html>