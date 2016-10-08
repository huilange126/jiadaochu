<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>评优结果列表页面</title>
	<link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.5.2/css/amazeui.min.css" />
</head>
<body>
	<div class="am-g am-padding">
		<table class="am-table am-table-bordered am-table-striped am-table-hover">
			<thead>
				<tr class="am-warning">
					<th colspan="3">
						<?php echo ($term['name']); ?>评优结果列表
					</th>
				</tr>
				<tr class="am-success">
					<th style="width: 5%" class="am-text-center">序号</th>
					<th style="width: 20%" class="am-text-center">年级</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($nianji)): foreach($nianji as $key=>$v): ?><tr>
					<td class="am-text-center"><?php echo ++$key;?></td>
					<td class="am-text-center"><?php echo ($v['mingcheng']); ?></td>
					<td>
						<a href="<?php echo U(GROUP_NAME.'/Sanhao/result',array('nianji'=>$v['id'],'type'=>0));?>" class="am-btn am-btn-primary am-btn-xs">查看结果</a>
						<a href="<?php echo U(GROUP_NAME.'/Sanhao/result',array('nianji'=>$v['id'],'type'=>1));?>" class="am-btn am-btn-success am-btn-xs">下载报表</a>
						<a href="<?php echo U(GROUP_NAME.'/Sanhao/result',array('nianji'=>$v['id'],'type'=>2));?>" class="am-btn am-btn-warning am-btn-xs">导出EXCEL文件</a>
					</td>
				</tr><?php endforeach; endif; ?>
			</tbody>
		</table>
		<!-- 临时增加查询开始 -->
		<table class="am-table am-table-bordered am-table-striped am-table-hover">
		<thead>
				<tr class="am-warning">
					<th colspan="4">
						已进行评价查询
					</th>
				</tr>
				<tr class="am-success">
					<th style="width: 5%" class="am-text-center">序号</th>
					<th style="width: 10%" class="am-text-center">入学年</th>
					<th>学期</th>
					<th>操作</th>
				</tr>
				<tr>
					<td>1</td>
					<td>2014级</td>
					<td>2015-2016学年度第二学期评优结果</td>
					<td>
					<a href="<?php echo U(GROUP_NAME.'/Sanhao/resultPast',array('ruxuenian'=>2014,'nianji'=>2,'xueqi'=>6));?>" class="am-btn am-btn-primary am-btn-xs">查看详情</a>
					<a href="<?php echo U(GROUP_NAME.'/Sanhao/resultPast',array('ruxuenian'=>2014,'nianji'=>2,'xueqi'=>6,'type'=>1));?>" class="am-btn am-btn-primary am-btn-xs">下载报表</a>
					<a href="<?php echo U(GROUP_NAME.'/Sanhao/resultPast',array('ruxuenian'=>2014,'nianji'=>2,'xueqi'=>6,'type'=>2));?>" class="am-btn am-btn-primary am-btn-xs">导出EXCEL</a>
					</td>
				</tr>
				<tr>
					<td>2</td>
					<td>2015级</td>
					<td>2015-2016学年度第二学期评优结果</td>
					<td>
					<a href="<?php echo U(GROUP_NAME.'/Sanhao/resultPast',array('ruxuenian'=>2015,'nianji'=>1,'xueqi'=>6));?>" class="am-btn am-btn-primary am-btn-xs">查看详情</a>
					<a href="<?php echo U(GROUP_NAME.'/Sanhao/resultPast',array('ruxuenian'=>2015,'nianji'=>1,'xueqi'=>6,'type'=>1));?>" class="am-btn am-btn-primary am-btn-xs">下载报表</a>
					<a href="<?php echo U(GROUP_NAME.'/Sanhao/resultPast',array('ruxuenian'=>2015,'nianji'=>1,'xueqi'=>6,'type'=>2));?>" class="am-btn am-btn-primary am-btn-xs">导出EXCEL</a>
					</td>
				</tr>
			</thead>
		</table>
		<!-- 临时增加查询结束 -->
	</div>
</body>
</html>