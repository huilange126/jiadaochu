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
		<div class="am-panel-hd">管理员列表</div>
		<table class="am-table am-table-bordered am-table-striped am-table-hover">
			<thead>
				<tr>
					<th style="width: 5%;" class="am-text-center">序号</th>
					<th style="width: 10%;" class="am-text-center">用户名</th>
					<th>重置密码</th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($admin)): foreach($admin as $key=>$v): ?><tr>
					<td style="width: 5%;" class="am-text-center"><?php echo ++$num;?></td>
					<td style="width: 5%;" class="am-text-center"><?php echo ($v['username']); ?></td>
					<td>
						<a href="<?php echo U(GROUP_NAME.'/Admin/edit',array('id'=>$v['id']));?>" class="am-btn am-btn-success am-btn-xs">修改账户</a>
						<a href="<?php echo U(GROUP_NAME.'/Admin/del',array('id'=>$v['id']));?>" class="am-btn am-btn-danger am-btn-xs" onclick="return del();">删除账户</a>
					</td>
				</tr><?php endforeach; endif; ?>
				<tr class="am-active">
					<td colspan="3">
						<ul class="am-pagination">
							<?php echo ($show); ?>
						</ul>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
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
<script>
	function del(){
		return confirm('确定要删除？');
	}
</script>