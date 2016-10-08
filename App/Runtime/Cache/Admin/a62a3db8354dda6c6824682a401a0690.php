<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>报名任务添加页面</title>
	<link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.5.2/css/amazeui.min.css" />
	<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
	<script type="text/javascript" src="http://cdn.amazeui.org/amazeui/2.5.2/js/amazeui.min.js"></script>
</head>
<body>
	<div class="am-g am-padding">
		<div class="am-panel am-panel-secondary">
			<div class="am-panel-hd">报名任务搜索</div>
			<div class="am-panel-bd am-cf">
				<form class="am-form am-form-horizontal" method="POST" action="<?php echo U(GROUP_NAME.'/Enrollment/index');?>">
					<div class="am-form-group">
						<label for="doc-ipt-email-1" class="am-u-sm-2 am-text-right">搜索任务名称</label>
						<div class="am-u-sm-4 am-u-end">
							<input type="text" name="keywords" class="" id="doc-ipt-email-1" placeholder="输入搜索任务名称">
						</div>
					</div>
					<div class="am-form-group">
						<div class="am-u-sm-6 am-u-end">
							<button class="am-btn am-btn-primary am-center" id="btnadd">搜索报名任务</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="am-g am-padding">
		<table class="am-table am-table-bordered am-table-striped am-table-hover">
			<thead>
				<tr>
					<th colspan="7" class="am-success">报名任务列表</th>
				</tr>
				<tr>
					<th style="width:5%;">序号</th>
					<th style="width:15%;">报名任务名称</th>
					<th style="width:5%;">兼报数</th>
					<th style="width:8%;">开始时间</th>
					<th style="width:8%;">截止时间</th>
					<th style="width:5%;">状态</th>
					<th style="width:35%;">操作</th>
				</tr>
			</thead>
			<tbody>
			<?php if(is_array($enrollment)): foreach($enrollment as $key=>$v): ?><tr>
					<td><?php echo ++$num;?></td>
					<td><?php echo ($v['mingcheng']); ?></td>
					<td><?php echo ($v['renshu']); ?></td>
					<td><?php echo (date('Y-m-d',$v['start'])); ?></td>
					<td><?php echo (date('Y-m-d',$v['end'])); ?></td>
					<td>
						<?php if($v['status'] == 1): ?><span class="am-btn am-btn-success am-btn-xs">启用</span>
						<?php else: ?>
							<span class="am-btn am-btn-danger am-btn-xs">禁用</span><?php endif; ?>
					</td>
					<td>
						<a href="<?php echo U(GROUP_NAME.'/Enrollment/edit',array('id'=>$v['id']));?>" class="am-btn am-btn-primary am-btn-xs">编辑</a>
						<a href="<?php echo U(GROUP_NAME.'/EnrollmentContent/addHebing',array('id'=>$v['id']));?>" class="am-btn am-btn-warning am-btn-xs">添加合并分组</a>
						<a href="<?php echo U(GROUP_NAME.'/EnrollmentContent/add',array('id'=>$v['id']));?>" class="am-btn am-btn-success am-btn-xs">添加报名项目</a>
						<a href="<?php echo U(GROUP_NAME.'/Enrollment/detail',array('id'=>$v['id']));?>" class="am-btn am-btn-secondary am-btn-xs">报名任务详情</a>
						<a href="<?php echo U(GROUP_NAME.'/Enrollment/chakanType',array('id'=>$v['id']));?>" class="am-btn am-btn-warning am-btn-xs">查看报表</a>
						<a href="<?php echo U(GROUP_NAME.'/Enrollment/banjiDetail',array('id'=>$v['id']));?>" class="am-btn am-btn-success am-btn-xs">生成班级报名详情</a>
					</td>
				</tr><?php endforeach; endif; ?>
				<tr>
					<td colspan="7">
						<ul class="am-pagination am-pagination-left">
                            <?php echo ($show); ?>
                        </ul>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>