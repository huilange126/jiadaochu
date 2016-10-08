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
<style>
	.mytable{
		border: 1px solid #efefef;
	}
</style>
<div class="am-g am-padding">
		<div class="am-panel am-panel-default">
			<div class="am-panel-bd">
				<a href="__ROOT__/Uploads/<?php echo ($file['zhixuce']); ?>" class="am-btn am-btn am-btn-primary">导出秩序册</a>
				<a href="__ROOT__/Uploads/<?php echo ($file['tiansai']); ?>" class="am-btn am-btn am-btn-primary">导出田赛成绩表</a>
				<a href="__ROOT__/Uploads/<?php echo ($file['jingsai']); ?>" class="am-btn am-btn am-btn-primary">导出径赛检录单</a>
			</div>
		</div>
	</div>
<div class="am-g am-padding">
	<div class="am-panel am-panel-secondary">
		<div class="am-panel-hd">运动会报名报表</div>
		<?php if(is_array($jibu)): foreach($jibu as $key=>$v): ?><div class="am-panel-bd">
				<?php echo ($v['mingcheng']); ?>
			</div>
			<?php if(is_array($v['xiangmu'])): foreach($v['xiangmu'] as $key=>$m): if($m['nannv'] == 2): ?><!-- 表示该项目有男女分组 -->
			<?php
 $xuesheng = $m['student']; $nvsheng = array(); $nansheng = array(); foreach($xuesheng as $key=>$value){ if($value['xingbie']==0){ $nvsheng[] = $value; }else{ $nansheng[] = $value; } } shuffle($nvsheng); shuffle($nansheng); ?>
			<?php if($m['leixing'] == 2): ?><!-- 表示是径赛 -->
			
				<table class="am-table am-table-bordered am-table-striped am-table-hover mytable">
					<thead>
						<tr>
							<th colspan="9"><?php echo ($m['mingcheng']); ?>男子组</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="width: 10%;" class="am-text-center">组/道次</td>
							<td style="width: 10%;" class="am-text-center">一</td>
							<td style="width: 10%;" class="am-text-center">二</td>
							<td style="width: 10%;" class="am-text-center">三</td>
							<td style="width: 10%;" class="am-text-center">四</td>
							<td style="width: 10%;" class="am-text-center">五</td>
							<td style="width: 10%;" class="am-text-center">六</td>
							<td style="width: 10%;" class="am-text-center">七</td>
							<td style="width: 10%;" class="am-text-center">八</td>
						</tr>
						<?php
 $studentCount = count($nansheng); if($studentCount%8==0){ $rowCount = $studentCount/8; }else{ $rowCount = floor($studentCount/8)+1; } $yushu = $studentCount%8; if($yushu>=4&&$yushu<8){ $weizhi = ($rowCount-1)*8; array_splice($nansheng, $weizhi,0, array('name'=>'')); } if($yushu<4){ $daoshudierzu = ceil((8+$yushu)/2); $zuihouyizu = (8+$yushu)-$daoshudierzu; $weizhi = ($rowCount-2)*8; array_splice($nansheng, $weizhi,0, array('name'=>'')); $chazhi = 8-1-$daoshudierzu; for($i=0;$i<$chazhi;$i++){ $weizhi = ($rowCount-2)*8+$daoshudierzu+i+1; array_splice($nansheng, $weizhi,0, array('name'=>'')); } $weizhi = ($rowCount-1)*8; array_splice($nansheng, $weizhi,0, array('name'=>'')); } for($i=0;$i<$rowCount;$i++){ ?>
						<tr>
							<td class="am-text-center"><?php echo ($i+1); echo $zuihouyizu ?></td>
							<?php
 for($j=0;$j<8;$j++){ ?>
								<td class="am-text-center">
									<?php
 echo $nansheng[$i*8+$j]['xuehao']; echo '<br>'; echo $nansheng[$i*8+$j]['name']; ?>
								</td>
							<?php
 } ?>
						</tr>
						<?php
 } ?>
					</tbody>
				</table>
				<br>
				<table class="am-table am-table-bordered am-table-striped am-table-hover">
					<thead>
						<tr>
							<th colspan="9"><?php echo ($m['mingcheng']); ?>女子组</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="width: 10%;" class="am-text-center">组/道次</td>
							<td style="width: 10%;" class="am-text-center">一</td>
							<td style="width: 10%;" class="am-text-center">二</td>
							<td style="width: 10%;" class="am-text-center">三</td>
							<td style="width: 10%;" class="am-text-center">四</td>
							<td style="width: 10%;" class="am-text-center">五</td>
							<td style="width: 10%;" class="am-text-center">六</td>
							<td style="width: 10%;" class="am-text-center">七</td>
							<td style="width: 10%;" class="am-text-center">八</td>
						</tr>
						<?php
 $studentCount = count($nvsheng); if($studentCount%8==0){ $rowCount = $studentCount/8; }else{ $rowCount = floor($studentCount/8)+1; } $yushu = $studentCount%8; if($yushu>=4&&$yushu<8){ $weizhi = ($rowCount-1)*8; array_splice($nvsheng, $weizhi,0, array('name'=>'')); } if($yushu<4){ $daoshudierzu = ceil((8+$yushu)/2); $zuihouyizu = (8+$yushu)-$daoshudierzu; $weizhi = ($rowCount-2)*8; array_splice($nvsheng, $weizhi,0, array('name'=>'')); $chazhi = 8-1-$daoshudierzu; for($i=0;$i<$chazhi;$i++){ $weizhi = ($rowCount-2)*8+$daoshudierzu+i+1; array_splice($nvsheng, $weizhi,0, array('name'=>'')); } $weizhi = ($rowCount-1)*8; array_splice($nvsheng, $weizhi,0, array('name'=>'')); } for($i=0;$i<$rowCount;$i++){ ?>
						<tr>
							<td class="am-text-center"><?php echo ($i+1); ?></td>
							<?php
 for($j=0;$j<8;$j++){ ?>
								<td class="am-text-center">
									<?php
 echo $nvsheng[$i*8+$j]['xuehao']; echo '<br>'; echo $nvsheng[$i*8+$j]['name']; ?>
								</td>
							<?php
 } ?>
						</tr>
						<?php
 } ?>
					</tbody>
				</table>
				<br><?php endif; ?>
			<?php if($m['leixing'] == 1): ?><!-- 表示是田赛 -->
			<table class="am-table am-table-bordered am-table-striped am-table-hover">
					<thead>
						<tr>
							<th colspan="9"><?php echo ($m['mingcheng']); ?>男子组</th>
						</tr>
					</thead>
					<tbody>
						<?php
 $studentCount = count($nansheng); if($studentCount%8==0){ $rowCount = $studentCount/8; }else{ $rowCount = floor($studentCount/8)+1; } ?>
						<?php
 for($i=0;$i<$rowCount;$i++){ ?>
						<tr>
							<?php
 for($j=0;$j<8;$j++){ ?>
								<td style="width: 10%;" class="am-text-center">
									<?php
 echo $nansheng[$i*8+$j]['xuehao']; echo '<br>'; echo $nansheng[$i*8+$j]['name']; ?>
								</td>
								<?php
 } ?>
						</tr>
						<?php
 } ?>
					</tbody>
			</table>
			<br>
			<table class="am-table am-table-bordered am-table-striped am-table-hover">
					<thead>
						<tr>
							<th colspan="9"><?php echo ($m['mingcheng']); ?>女子组</th>
						</tr>
					</thead>
					<tbody>
						<?php
 $studentCount = count($nvsheng); if($studentCount%8==0){ $rowCount = $studentCount/8; }else{ $rowCount = floor($studentCount/8)+1; } ?>
						<?php
 for($i=0;$i<$rowCount;$i++){ ?>
						<tr>
							<?php
 for($j=0;$j<8;$j++){ ?>
								<td style="width: 10%;" class="am-text-center">
									<?php
 echo $nvsheng[$i*8+$j]['xuehao']; echo '<br>'; echo $nvsheng[$i*8+$j]['name']; ?>
								</td>
								<?php
 } ?>
						</tr>
						<?php
 } ?>
					</tbody>
			</table>
			<br><?php endif; endif; endforeach; endif; endforeach; endif; ?>
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