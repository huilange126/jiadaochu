<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>报名任务详细信息</title>
	<link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.5.2/css/amazeui.min.css" />
	<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>
	<div class="am-g am-padding">
		<div class="am-panel am-panel-secondary">
		<div class="am-panel-hd">报名任务信息</div>
			<div class="am-panel-bd">
				<div class="am-g">
					<label for="" class="am-u-sm-2 am-text-right">报名任务名称</label>
					<div class="am-u-sm-4 am-u-end">
						<?php echo ($enrollment['mingcheng']); ?>
					</div>
				</div>
				<div class="am-g">
					<label for="" class="am-u-sm-2 am-text-right">参加报名年级</label>
					<div class="am-u-sm-10">
						<?php if(is_array($enrollment['nianji'])): foreach($enrollment['nianji'] as $key=>$v): ?>[<?php echo ($v['mingcheng']); ?>]<?php endforeach; endif; ?>
					</div>
				</div>
				<div class="am-g">
					<label for="" class="am-u-sm-2 am-text-right">兼报项目数量</label>
					<div class="am-u-sm-4 am-u-end">
						<?php echo ($enrollment['renshu']); ?>
					</div>
				</div>
				<div class="am-g">
					<label for="" class="am-u-sm-2 am-text-right">报名开始日期</label>
					<div class="am-u-sm-4 am-u-end">
						<?php echo (date('Y-m-d',$enrollment['start'])); ?>
					</div>
				</div>
				<div class="am-g">
					<label for="" class="am-u-sm-2 am-text-right">报名截止日期</label>
					<div class="am-u-sm-4 am-u-end">
						<?php echo (date('Y-m-d',$enrollment['end'])); ?>
					</div>
				</div>
				<div class="am-g">
					<label for="" class="am-u-sm-2 am-text-right">报名任务状态</label>
					<div class="am-u-sm-4 am-u-end">
						<?php if($enrollment['status'] == 1): ?>启用<?php else: ?>禁用<?php endif; ?>
					</div>
				</div>
			</div>
			<table class="am-table am-table-bordered am-table-striped am-table-hover">
				<tr class="am-success">
					<th colspan="3">
					合并分组列表[<a href="<?php echo U(GROUP_NAME.'/EnrollmentContent/addHebing',array('id'=>$enrollment['id']));?>">添加合并分组</a>]
					</th>
				</tr>
				<?php if(empty($enrollment['hebing']) == true): ?><td colspan="3">无合并分组</td>
					<?php else: ?>
					<tr>
						<td style="width: 5%">序号</td>
						<td style="width: 20%">名称</td>
						<td>操作</td>
					</tr>
					<?php if(is_array($enrollment['hebing'])): foreach($enrollment['hebing'] as $key=>$v): ?><tr>
							<td><?php echo ++$key;?></td>
							<td><?php echo ($v['mingcheng']); ?></td>
							<td>
								<a href="<?php echo U(GROUP_NAME.'/EnrollmentContent/editHebing',array('id'=>$v['id']));?>" class="am-btn am-btn-primary am-btn-xs">编辑</a>
								<a href="<?php echo U(GROUP_NAME.'/EnrollmentContent/delHebing',array('id'=>$v['id']));?>" class="am-btn am-btn-danger am-btn-xs" onclick="return del();">删除</a>
							</td>
						</tr><?php endforeach; endif; endif; ?>
			</table>
			<table class="am-table am-table-bordered am-table-striped am-table-hover">
				<thead>
					<tr>
						<th colspan="11" class="am-success">报名项目列表[<a href="<?php echo U(GROUP_NAME.'/EnrollmentContent/add',array('id'=>$enrollment['id']));?>">添加报名项目</a>]</th>
					</tr>
					<tr>
						<th style="width: 5%">序号</th>
						<th style="width: 15%">项目名称</th>
						<th style="width: 20%">参加年级</th>
						<th style="width: 10%">性别要求</th>
						<th style="width: 5%">限人数</th>
						<th style="width: 5%">男生数</th>
						<th style="width: 5%">女生数</th>
						<th style="width: 5%">状态</th>
						<th style="width: 5%">类型</th>
						<th>指定分组</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
				<?php if(is_array($enrollment['content'])): foreach($enrollment['content'] as $key=>$v): ?><tr>
						<td><?php echo ++$key;?></td>
						<td><?php echo ($v['mingcheng']); ?></td>
						<td><?php echo (getnianji($v['nianji'])); ?></td>
						<td><?php echo ($v['nannv']); ?></td>
						<td><?php echo ($v['renshu']); ?></td>
						<td><?php echo ($v['nansheng']); ?></td>
						<td><?php echo ($v['nvsheng']); ?></td>
						<td><?php echo ($v['status']); ?></td>
						<td><?php echo ($v['leixing']); ?></td>
						<td>
							<?php if(empty($enrollment['hebing']) == false): ?><form action="" class="am-form">
								<div class="am-form-group">
									<select id="doc-select-1">
										<option value="0">选择合并分组</option>
										<?php if(is_array($enrollment['hebing'])): foreach($enrollment['hebing'] as $key=>$m): ?><option <?php if($v['fenzu'] == $m['id']): ?>selected="selected"<?php endif; ?> attr="<?php echo ($v['id']); ?>" value="<?php echo ($m['id']); ?>" onclick="ajaxadd(this);"><?php echo ($m['mingcheng']); ?></option><?php endforeach; endif; ?>
									</select>
									<span class="am-form-caret"></span>
								</div>
								</form><?php endif; ?>
						</td>
						<td>
						<a href="<?php echo U(GROUP_NAME.'/EnrollmentContent/edit',array('id'=>$v['id']));?>" class="am-btn am-btn-primary am-btn-xs">编辑</a>
						<a href="#" class="am-btn am-btn-danger am-btn-xs">删除</a>
						</td>
					</tr><?php endforeach; endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</body>
<script>
	function ajaxadd(obj){
		var fenzuid = $(obj).val();
		var contentid = $(obj).attr('attr');
		var url = "<?php echo U(GROUP_NAME.'/EnrollmentContent/ajaxAdd');?>";
		// alert(contentid);
		$.ajax({
		  type: 'POST',
		  url: url,
		  data: {contentid:contentid,fenzuid:fenzuid},
		  success: function(data){
		  	if(data.status==0){
		  		alert(data.message);
		  	}
		  },
		  dataType: 'json'
		});
	}
	function del(){
		return confirm('确定要删除？');
	}
</script>
</html>