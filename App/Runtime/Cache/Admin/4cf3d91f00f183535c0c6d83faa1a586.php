<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="评价项目修改" />
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/amazeui2.6/css/amazeui.min.css" />
	<title>评价项目修改</title>
</head>
<body>
    <form action="<?php echo U(GROUP_NAME.'/Project/addProject');?>" method="POST" class="am-form am-form-horizontal">
        <div class="am-panel am-panel-secondary am-margin">
        <div class="am-panel-hd">评价任务修改</div>
            <div class="am-panel-bd">
                <div class="am-form-group">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">学期</label>
                    <div class="am-u-sm-4 am-u-end">
                        <input type="text" value="<?php echo ($project['term']); ?>" readonly="" />
                        <input type="hidden" name="term" value="<?php echo ($term['id']); ?>" />
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">评价项目名称</label>
                    <div class="am-u-sm-4 am-u-end">
                        <input type="text" name="name" value="<?php echo ($project['name']); ?>" />
                        <input type="hidden" name="id" value="<?php echo ($project['id']); ?>">
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">参加年级</label>
                    <div class="am-u-sm-4 am-u-end">
                       <?php if(is_array($project['ruxuenian'])): foreach($project['ruxuenian'] as $key=>$v): ?><label  class="am-checkbox-inline">
                            <input type="checkbox" name="nianji[]" value="<?php echo ($v['ruxuenian']); ?>" /><?php echo (getnianjimingcheng($v['ruxuenian'])); ?>(<?php echo ($v['ruxuenian']); ?>级)</label><?php endforeach; endif; ?>
                        
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">类型</label>
                    <div class="am-u-sm-4 am-u-end">
                        <label class="am-radio-inline">
                            <input type="radio" <?php if($project['leixing'] == 0): ?>checked="checked"<?php endif; ?>  value="0" name="leixing" checked="checked"> 评价任课老师
                        </label>
                        <label class="am-radio-inline">
                            <input type="radio"  <?php if($project['leixing'] == 1): ?>checked="checked"<?php endif; ?>  value="1" name="leixing"> 评价班主任
                        </label>
                    </div>
                </div>
                <div class="am-form-group">
                    <div class="am-u-sm-6 am-u-end">
                        <button class="am-btn am-btn-primary am-center">修改评价任务</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
<form action="<?php echo U(GROUP_NAME.'/Project/modifyHandle');?>" method="POST">
    <table class="table">
        <thead>
            <tr>
                <td colspan="2">评价项目添加</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td align="right">所属学期</td>
                <td>
                <?php echo ($project['term']); ?>
                </td>
            </tr>
            <tr>
                <td align="right">项目名称</td>
                <td>
                    <input type="text" name="name" value="<?php echo ($project['name']); ?>" />
                    <input type="hidden" name="id" value="<?php echo ($project['id']); ?>">
                </td>
            </tr>
            <tr>
                <td align="right">参加年级</td>
                <td>
                    <?php if(is_array($nianji)): foreach($nianji as $key=>$v): ?><label>
                        <input type="checkbox" name="nianji[]" <?php if(in_array($v['id'],$nianjiIdList) == true): ?>checked="checked"<?php endif; ?> value="<?php echo ($v['id']); ?>" />&nbsp;&nbsp;<?php echo ($v['mingcheng']); ?>&nbsp;&nbsp;
                    </label><?php endforeach; endif; ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" value="添加" /></td>
            </tr>
        </tbody>
    </table>
</form>

</body>
</html>