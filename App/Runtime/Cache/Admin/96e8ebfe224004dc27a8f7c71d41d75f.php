<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>学生评优项目添加页面</title>
	<link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.5.0/css/amazeui.min.css" />
	<style>
	.myclass{
		margin-left:0px; 
	}
	</style>
</head>
<body>
	<div class="am-g am-padding">
		<div class="am-panel am-panel-secondary">
			<div class="am-panel-hd">添加评优项目</div>
			<div class="am-panel-bd">
				<form class="am-form am-form-horizontal" method="POST" action="<?php echo U(GROUP_NAME.'/Sanhao/addHandle');?>">
					<div class="am-form-group">
						<label for="doc-ipt-3" class="am-u-sm-1 am-form-label">评优名称</label>
						<div class="am-u-sm-6 am-u-end">
							<input type="text" id="doc-ipt-3" name="mingcheng" placeholder="评优名称">
						</div>
					</div>
					<div class="am-form-group">
						<label for="doc-ipt-3" class="am-u-sm-1 am-form-label">适应年级</label>
						<div class="am-u-sm-2 am-u-end">
						<select id="doc-select-1" name="nianji">
							<option value="0">请选择年级</option>
							<?php if(is_array($nianji)): foreach($nianji as $key=>$v): ?><option value="<?php echo ($v['id']); ?>"><?php echo ($v['mingcheng']); ?>(<?php echo ($v['ruxuenian']); ?>)</option><?php endforeach; endif; ?>
						</select>
						<span class="am-form-caret"></span>
						</div>
					</div>
					<div class="am-form-group">
						<label for="doc-ipt-3" class="am-u-sm-1 am-form-label">文化课要求</label>
						<div class="am-u-sm-6 am-u-end">
						<?php if(is_array($xueke)): foreach($xueke as $key=>$v): ?><div class="am-u-sm-3 am-u-end myclass">
							<input type="checkbox" value="<?php echo ($v['id']); ?>" name="xueke[]"> <?php echo ($v['xueke']); ?>
							<input type="text" name="fenshu<?php echo ($v['id']); ?>">
						</div><?php endforeach; endif; ?>
						</div>
					</div>
					<div class="am-form-group">
						<label for="doc-ipt-3" class="am-u-sm-1 am-form-label">人数限制</label>
						<div class="am-u-sm-2 am-u-end">
							<label class="am-radio-inline">
								<input type="checkbox"  value="1" name="checkpaichu"> 排除
							</label>
							<select id="doc-select-1" name="selectpaichu[]" multiple >
								<!-- <option value="0">请选择评优规则</option> -->
								<?php if(is_array($sanhaoguize)): foreach($sanhaoguize as $key=>$v): ?><option value="<?php echo ($v['id']); ?>"><?php echo ($v['mingcheng']); ?></option><?php endforeach; endif; ?>
							</select>
							<span class="am-form-caret"></span>
						</div>
						<div class="am-u-sm-2 am-u-end">
							<label class="am-radio-inline">
								<input type="checkbox"  value="1" name="checkjicheng"> 继承
							</label>
							<select id="doc-select-1" name="selectjicheng">
								<option value="0">请选择评优规则</option>
								<?php if(is_array($sanhaoguize)): foreach($sanhaoguize as $key=>$v): ?><option value="<?php echo ($v['id']); ?>"><?php echo ($v['mingcheng']); ?></option><?php endforeach; endif; ?>
							</select>
							<span class="am-form-caret"></span>
						</div>
						<div class="am-u-sm-2 am-u-end">
							<label class="am-radio-inline">
								<input type="checkbox"  value="1" name="checkrenshu"> 人数
							</label>
							<input type="text" id="doc-ipt-3" name="txtrenshu" placeholder="人数限制">
						</div>
						<div class="am-u-sm-2 am-u-end">
							<label class="am-radio-inline">
								<input type="checkbox"  value="1" name="checkbili"> 比例
							</label>
							<input type="text" id="doc-ipt-3" name="txtbili" placeholder="人数比例限制">
						</div>
					</div>
					<div class="am-form-group">
						<label for="doc-ipt-3" class="am-u-sm-1 am-form-label">子分类</label>
						<div class="am-u-sm-3 am-u-end">
							<label class="am-radio-inline">
								<input type="radio"  value="1" name="checkzifenlei"> 有子分类
							</label>
							<label class="am-radio-inline">
								<input type="radio" value="0" checked="checked" name="checkzifenlei"> 无子分类
							</label>
							<textarea class="" rows="5" id="doc-ta-1" name="fenfei">学科之星
开拓之星
文明之星
艺术之星
体育之星
爱心之星
飞跃之星
劳动之星
诚信之星
公益之星</textarea>
						</div>
					</div>
					<div class="am-form-group">
						<div class="am-u-sm-7 am-u-end am-text-center">
							<button class="am-btn am-btn-primary">添加评优项目</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>