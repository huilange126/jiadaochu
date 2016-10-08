<?php if (!defined('THINK_PATH')) exit();?><div class="am-panel am-panel-secondary">
	<div class="am-panel-hd am-cf">基础信息<a href="<?php echo U(GROUP_NAME.'/Login/logout');?>" class="am-btn am-btn-primary am-btn-xs am-fr">退出系统</a></div>
	<div class="am-panel-bd am-cf">
		<div class="am-u-sm-2">
			<label for="">班级</label>
			<?php echo ($banji['ruxuenian']); ?>级<?php echo ($banji['banji']); ?>班
		</div>
		<div class="am-u-sm-4 am-u-end">
			<label for="">学期</label>
			<?php echo ($term['name']); ?>
		</div>
	</div>	
</div>