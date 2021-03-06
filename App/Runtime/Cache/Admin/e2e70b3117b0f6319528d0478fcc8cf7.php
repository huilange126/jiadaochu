<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>德育管理奖惩添加</title>
	<link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.5.2/css/amazeui.min.css" />
	<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
	<script type="text/javascript" src="http://cdn.amazeui.org/amazeui/2.5.2/js/amazeui.min.js"></script>
	<link rel="stylesheet" href="__PUBLIC__/kindeditor/themes/default/default.css" />
	<script charset="utf-8" src="__PUBLIC__/kindeditor/kindeditor-min.js"></script>
	<script charset="utf-8" src="__PUBLIC__/kindeditor/lang/zh_CN.js"></script>
</head>
<script>
	var editor;
	KindEditor.ready(function(K) {
		editor = K.create('textarea[name="content"]', {
			resizeType : 1,
			allowPreviewEmoticons : false,
			allowImageUpload : true,
			uploadJson : "<?php echo U(GROUP_NAME.'/Deyu/upload');?>",
			allowImageRomote:false,
			formatUploadUrl:false,
			cssData : 'body {font-size:16px;} img{max-width:500px;width: expression(this.width>450?"500px":this.width+"px"); overflow: hidden;}',
			items : [
			'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
			'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
			'insertunorderedlist', '|', 'emoticons', 'image', 'link']
		});
	});
</script>
<body>
	<div class="am-g am-padding">
		<div class="am-panel am-panel-secondary">
			<div class="am-panel-hd">奖惩信息添加</div>
			<div class="am-panel-bd">
				<form class="am-form am-form-horizontal" method="POST" action="<?php echo U(GROUP_NAME.'/Deyu/addHandle');?>" enctype=”multipart/form-data”>
					<div class="am-form-group">
						<label for="doc-ipt-3" class="am-u-sm-2 am-form-label">学生信息</label>
						<div class="am-u-sm-2 am-u-end">
							<input type="text" name="xuehaoxingming" class="am-form-field"readonly value="<?php echo ($student['xuehao']); echo ($student['name']); ?>" />
							<input type="hidden" name="student" value="<?php echo ($student['id']); ?>">
							<input type="hidden" name="id" value="<?php echo ($id); ?>">
						</div>
					</div>
					<div class="am-form-group">
						<label for="doc-ipt-3" class="am-u-sm-2 am-form-label">选择日期</label>
						<div class="am-u-sm-2 am-u-end">
							<input type="text" name="shijian" class="am-form-field" placeholder="选择奖惩日期" data-am-datepicker readonly required value="<?php echo date('Y-m-d',$jiangcheng['riqi']);?>" />
						</div>
					</div>
					<div class="am-form-group">
						<label for="doc-ipt-3" class="am-u-sm-2 am-form-label">信息类型</label>
						<div class="am-u-sm-4 am-u-end">
							<div class="am-form-group">
								<label class="am-radio-inline">
									<input type="radio" <?php if($jiangcheng['leixing'] == 1): ?>checked="checked"<?php endif; ?> value="1" name="leixing"> 奖励信息
								</label>
								<label class="am-radio-inline">
									<input type="radio" <?php if($jiangcheng['leixing'] == 2): ?>checked="checked"<?php endif; ?>  value="2" name="leixing"> 惩罚信息
								</label>
								<label class="am-radio-inline">
									<input type="radio"  <?php if($jiangcheng['leixing'] == 3): ?>checked="checked"<?php endif; ?>  value="3" name="leixing"> 其他
								</label>
							</div>
						</div>
					</div>
					<div class="am-form-group">
						<label for="doc-ipt-3" class="am-u-sm-2 am-form-label">信息描述</label>
						<div class="am-u-sm-2 am-u-end">
							<textarea name="content" style="width:500px;height:200px;visibility:hidden;">
								<?php echo ($jiangcheng['miaoshu']); ?>
							</textarea>
						</div>
					</div>
					<div class="am-form-group">
						<div class="am-u-sm-6 am-u-end">
							<button class="am-btn am-btn-primary am-center">奖惩信息更新</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>