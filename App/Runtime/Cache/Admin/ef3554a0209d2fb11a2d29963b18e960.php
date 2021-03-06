<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>奖惩添加学生搜索</title>
	<link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.5.2/css/amazeui.min.css" />
</head>
<body>
	<div class="am-g am-padding">
		<div class="am-panel am-panel-secondary">
			<div class="am-panel-hd">学生搜索</div>
			<div class="am-panel-bd">
				<form class="am-form am-form-horizontal" method="POST" action="<?php echo U(GROUP_NAME.'/Deyu/searchStudent');?>">
					<div class="am-form-group">
						<label for="doc-ipt-3" class="am-u-sm-2 am-form-label">输入学号或者姓名</label>
						<div class="am-u-sm-4 am-u-end">
							<input type="text" name="keywords" class="am-form-field" placeholder="输入关键字"/>
						</div>
					</div>
					<div class="am-form-group">
						<div class="am-u-sm-6 am-u-end">
							<button class="am-btn am-btn-primary am-center">搜索学生</button>
						</div>
					</div>
				</form>
			</div>
			<?php if(empty($student) != true): ?><table class="am-table am-table-bordered am-table-striped am-table-hover">
				<thead>
					<tr class="am-success">
						<th style="width: 5%" class="am-text-center">序号</th>
						<th style="width: 10%" class="am-text-center">学号</th>
						<th style="width: 10%" class="am-text-center">姓名</th>
						<th style="width: 5%" class="am-text-center">性别</th>
						<th class="am-text-center">操作</th>
					</tr>
				</thead>
				<tbody>
				<?php if(is_array($student)): foreach($student as $key=>$v): ?><tr>
						<td class="am-text-center"><?php echo ++$key;?></td>
						<td class="am-text-center"><?php echo ($v['xuehao']); ?></td>
						<td class="am-text-center"><?php echo ($v['name']); ?></td>
						<td class="am-text-center">
							<?php if($v['xingbie'] == 1): ?>男生
							<?php else: ?>
							女生<?php endif; ?>
						</td>
						<td>
							<a href="<?php echo U(GROUP_NAME.'/Deyu/add',array('student'=>$v['id']));?>" class="am-btn am-btn-warning am-btn-sm">添加奖惩信息</a>
							<a href="#" class="am-btn am-btn-secondary am-btn-sm">生成素质报表</a>
						</td>
					</tr><?php endforeach; endif; ?>
				</tbody>
			</table><?php endif; ?>
		</div>
	</div>
</body>
</html>