<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo (C("webname")); ?>教导处管理平台</title>
	<link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.5.0/css/amazeui.min.css" />
	<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
	<script type="text/javascript" src="http://cdn.amazeui.org/amazeui/2.5.2/js/amazeui.min.js"></script>
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
	<div class="am-g am-g-fixed topheader">
		<div class="am-u-sm-2">
			<img src="__ROOT__/Uploads/<?php echo (C("logo")); ?>" class="am-img-responsive am-fr am-padding-top-xs" style="height:110px;" alt="">
		</div>
		<div class="am-u-sm-10">
			<h1 class="am-padding-top-xl banner"><?php echo (C("webname")); echo ($appname); ?></h1>
		</div>
	</div>
<div class="am-g am-g-fixed am-margin-top">
	<div class="am-panel am-panel-secondary">
		<div class="am-panel-hd am-cf">年级列表</div>
		<div class="am-panel-bd am-cf">
			<ul class="vedio-category-list">
				<?php if(is_array($nianji)): foreach($nianji as $key=>$v): ?><li>
					<a href="<?php echo U(GROUP_NAME.'/Pingyou/result',array('njid'=>$v['id']));?>"><?php echo ($v['mingcheng']); ?></a>
				</li><?php endforeach; endif; ?>
			</ul>
		</div>
	</div>
</div>
<div class="am-g am-g-fixed am-margin-top">
	<?php if(is_array($banji)): foreach($banji as $key=>$v): ?><table class="am-table am-table-bordered am-table-striped am-table-hover">
			<thead>
				<tr class="am-primary">
				<th colspan="6"><?php echo ($v['ruxuenian']); ?>级<?php echo ($v['banji']); ?>班</th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($sanhaoxiangmu)): foreach($sanhaoxiangmu as $key=>$m): ?><tr>
						<td colspan="6">
							<?php echo ($m['mingcheng']); ?>
						</td>
					</tr>
					<tr><td colspan="6">
					<?php
 if($m['zifenlei']!='0'){ $zifenlei = json_decode($m['zifenlei']); } foreach($v['result'] as $key=>$resultValue){ if($resultValue['sanhaoid']==$m['id']){ $str="<span class='am-u-sm-3 am-u-end '>"; $str=$str.$resultValue['xuehao'].$resultValue['name']; if($resultValue['zifenleiid']!=0){ $str = $str.'('.$zifenlei[$resultValue['zifenleiid']-1].')'; } $str=$str."</span>"; echo $str; } } ?>
					</td></tr><?php endforeach; endif; ?>
			</tbody>
		</table><?php endforeach; endif; ?>
</div>
<footer>
	<p class="am-text-center"><?php echo (C("copyright")); ?></p>
</footer>
</body>
</html>