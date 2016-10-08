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
			<div class="am-panel-hd">报名任务添加</div>
			<div class="am-panel-bd am-cf">
				<form class="am-form am-form-horizontal" method="POST" action="<?php echo U(GROUP_NAME.'/Enrollment/addHandle');?>">
					<div class="am-form-group">
						<label for="doc-ipt-email-1" class="am-u-sm-2 am-text-right">报名任务名称</label>
						<div class="am-u-sm-4 am-u-end">
							<input type="text" name="txtMingcheng" class="" id="doc-ipt-email-1" placeholder="输入报名任务名称">
						</div>
					</div>
					<div class="am-form-group">
						<label class="am-u-sm-2 am-text-right">选择年级</label>
						<div class="am-u-sm-4 am-u-end">
						<?php if(is_array($nianji)): foreach($nianji as $key=>$v): ?><label class="am-checkbox-inline">
								<input type="checkbox" name="chkNianji[]" value="<?php echo ($v['id']); ?>"> <?php echo ($v['mingcheng']); ?>
							</label><?php endforeach; endif; ?>
						</div>
					</div>
					<div class="am-form-group">
						<label for="doc-ipt-email-1" class="am-u-sm-2 am-text-right">每个学生限报项目数</label>
						<div class="am-u-sm-1 am-u-end">
							<select id="doc-select-1" name="selNum" class="am-padding-left">
								<?php $__FOR_START_16433__=1;$__FOR_END_16433__=11;for($i=$__FOR_START_16433__;$i < $__FOR_END_16433__;$i+=1){ ?><option value="<?php echo ($i); ?>"  class="am-padding-left"><?php echo ($i); ?></option><?php } ?>
							</select>
							<span class="am-form-caret"></span>
						</div>
					</div>
					<div class="am-form-group">
						<label for="doc-ipt-email-1" class="am-u-sm-2 am-text-right">报名开始时间</label>
						<div class="am-u-sm-2 am-u-end">
							 <input type="text" name="txtStart" class="am-form-field" placeholder="开始时间" data-am-datepicker readonly required />
						</div>
					</div>
					<div class="am-form-group">
						<label for="doc-ipt-email-1" class="am-u-sm-2 am-text-right">报名截止时间</label>
						<div class="am-u-sm-2 am-u-end">
							 <input type="text" name="txtEnd" class="am-form-field" placeholder="截止时间" data-am-datepicker readonly required />
						</div>
					</div>
					<div class="am-form-group">
						<label for="doc-ipt-email-1" class="am-u-sm-2 am-text-right">状态</label>
						<div class="am-u-sm-2 am-u-end">
							<label class="am-radio-inline">
								<input type="radio" checked="checked"  value="1" name="status"> 启用
							</label>
							<label class="am-radio-inline">
								<input type="radio" value="0" name="status"> 禁用
							</label>
						</div>
					</div>
					<div class="am-form-group">
						<div class="am-u-sm-6 am-u-end">
							<button class="am-btn am-btn-primary am-center" id="btnadd">添加报名任务</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		$(function(){
			$('#btnadd').click(function(){
				var ischecked = false;
				if($('input[name=txtMingcheng]').val()==''){
					alert('名称不能为空');
					return false;
				}
				$.each($('input[type=checkbox]'), function(index, val) {
					 //$(val).attr('checked',true);
					 if($(val).is(':checked')){
					 //if($(val).checked){
					 	ischecked = true;
					 	//break;
					 }
				});
				if(ischecked==false){
					alert('请选择年级');
					return false;
				}
				//如果开始时间没有选择
				if($('input[name=txtStart]').val()==''){
					alert('请选择开始时间');
					return false;
				}
				//如果结束时间没有选择
				if($('input[name=txtEnd]').val()==''){
					alert('请选择结束时间');
					return false;
				}
			});

		});
	</script>
</body>
</html>