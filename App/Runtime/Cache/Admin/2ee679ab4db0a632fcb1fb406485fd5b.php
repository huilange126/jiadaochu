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
			<div class="am-panel-hd">报名任务项目添加</div>
			<div class="am-panel-bd am-cf">
				<form class="am-form am-form-horizontal" method="POST" action="<?php echo U(GROUP_NAME.'/EnrollmentContent/addHandle');?>">
					<div class="am-form-group">
						<label for="doc-ipt-email-1" class="am-u-sm-2 am-text-right">所属报名任务</label>
						<div class="am-u-sm-4 am-u-end">
							<?php echo ($enrollment['mingcheng']); ?>
							<input type="hidden" name="eid" value="<?php echo ($enrollment['id']); ?>">
						</div>
					</div>
					<div class="am-form-group">
						<label for="doc-ipt-email-1" class="am-u-sm-2 am-text-right">报名项目名称</label>
						<div class="am-u-sm-4 am-u-end">
							<input type="text" name="mingcheng" class="" id="doc-ipt-email-1" placeholder="输入报名项目名称">
						</div>
					</div>
					<div class="am-form-group">
						<label class="am-u-sm-2 am-text-right">选择年级</label>
						<div class="am-u-sm-4 am-u-end">
						<?php if(is_array($enrollment['nianji'])): foreach($enrollment['nianji'] as $key=>$v): ?><label class="am-checkbox-inline">
								<input type="checkbox" checked="checked" name="chkNianji[]" value="<?php echo ($v['id']); ?>"> <?php echo ($v['mingcheng']); ?>
							</label><?php endforeach; endif; ?>
						</div>
					</div>
					<div class="am-form-group">
						<label for="" class="am-u-sm-2 am-text-right">男女生项目</label>
						<div class="am-u-sm-4 am-u-end">
							<label class="am-radio-inline">
							<input type="radio" checked="checked"  name="nannv" value="2"> 男女均报
							</label>
							<label class="am-radio-inline">
								<input type="radio" name="nannv" value="1"> 男生项目
							</label>
							<label class="am-radio-inline">
								<input type="radio" name="nannv" value="0"> 女生项目
							</label>
							<label class="am-radio-inline">
								<input type="radio" name="nannv" value="3"> 无性别要求
							</label>
						</div>
					</div>
					<div class="am-form-group">
						<label for="doc-ipt-email-1" class="am-u-sm-2 am-text-right">限报人数</label>
						<div class="am-u-sm-1 am-u-end">
							<input type="text" name="renshu" value="0">
						</div>
					</div>
					<div class="am-form-group">
						<label for="doc-ipt-email-1" class="am-u-sm-2 am-text-right">男生可报数量</label>
						<div class="am-u-sm-1">
							<input type="text" name="nansheng" value="0">
						</div>
						<label for="doc-ipt-email-1" class="am-u-sm-2 am-text-right">女生可报数量</label>
						<div class="am-u-sm-1 am-u-end">
							<input type="text" name="nvsheng" value="0">
						</div>
					</div>
					<div class="am-form-group">
						<label for="doc-ipt-email-1" class="am-u-sm-2 am-text-right">项目类型</label>
						<div class="am-u-sm-4 am-u-end">
							<label class="am-radio-inline">
								<input type="radio" value="1" name="leixing"> 田赛
							</label>
							<label class="am-radio-inline">
								<input type="radio" value="2" name="leixing"> 径赛
							</label>
							<label class="am-radio-inline">
								<input type="radio" value="3" name="leixing"> 一般报名类型
							</label>
						</div>
					</div>
					<div class="am-form-group">
						<label for="" class="am-u-sm-2 am-text-right">集体项目</label>
						<div class="am-u-sm-4 am-u-end">
							<label class="am-radio-inline">
								<input type="radio" value="0" name="jiti" checked="checked"> 个人项目
							</label>
							<label class="am-radio-inline">
								<input type="radio" value="1" name="jiti"> 集体项目
							</label>
						</div>
					</div>
					<div class="am-form-group">
						<label for="doc-ipt-email-1" class="am-u-sm-2 am-text-right">状态</label>
						<div class="am-u-sm-2 am-u-end">
							<label class="am-radio-inline">
								<input type="radio" value="1" name="status"> 启用
							</label>
							<label class="am-radio-inline">
								<input type="radio" value="0" name="status"> 禁用
							</label>
						</div>
					</div>
					<div class="am-form-group">
						<div class="am-u-sm-6 am-u-end">
							<button class="am-btn am-btn-primary am-center" id="btnadd">添加报名项目</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script>
	$(function(){

		$('input[name=nannv]').click(function(event) {
			setNumber($(this).val());
		});
		$('input[name=renshu]').blur(function(event) {
			var renshu = parseInt($(this).val());
			if(renshu<0){
				alert('人数不能小于0');
				$(this).val(0);
				return;
			}
			var nannv = $('input[name=nannv]:checked').val();
			setNumber(nannv);
		});
		$('input[name=nansheng]').blur(function(event) {
			var nanshengshu = parseInt($(this).val());
			var allRenshu = parseInt($('input[name=renshu]').val());
			if(checkOver(nanshengshu)){
				$('input[name=nvsheng]').val(allRenshu-nanshengshu);
			}
		});
		$('input[name=nvsheng]').blur(function(event) {
			var nvshengshu = parseInt($(this).val());
			var allRenshu = parseInt($('input[name=renshu]').val());
			if(checkOver(nvshengshu)){
				$('input[name=nansheng]').val(allRenshu-nvshengshu);
			}
		});
		$('#btnadd').click(function(event) {
			//检测报名任务中的项目名称是否为空
			if($('input[name=mingcheng]').val()==''){
				alert('项目名称不能为空');
				return false;
			}
			//检测年级是否已经选定
			var ischecked = false;
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
			//检测状态是否已经选定
			if($('input[name=status]').is(':checked')==false){
				alert('请选择状态');
				return false;
			}
			//检测限报人数是否已经设定
			if($('input[name=renshu]').val()==0){
				alert('总人数不能为空');
				return false;
			}
		});
	});
	//检测输入数量是否超出总人数
	function checkOver(num){
		var allRenshu = $('input[name=renshu]').val();
		var nannv = $('input[name=nannv]:checked').val();
		if(num>allRenshu||num<0){
			alert('超出总人数限制或小于0了');
			setNumber(nannv);
			return false;
		}
		return true;
	}
	//根据性别设定相应性别的限报数量()
	function setNumber(sex){
		var allRenshu = $('input[name=renshu]').val();
		if(sex==2){
			var pingjun = allRenshu/2;
			$('input[name=nansheng]').val(pingjun);
			$('input[name=nvsheng]').val(pingjun);
		}
		if(sex==1){
			$('input[name=nansheng]').val(allRenshu);
			$('input[name=nvsheng]').val(0);
		}
		if(sex==0){
			$('input[name=nansheng]').val(0);
			$('input[name=nvsheng]').val(allRenshu);
		}
		if(sex==3){
			// 表示无性别要求 随便报名
			$('input[name=nansheng]').val(0);
			$('input[name=nvsheng]').val(0);
		}
	}
	</script>
</body>
</html>