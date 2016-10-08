<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="大眼仔~旭" />
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/public.css" />
	<title>设定年级</title>
</head>

<body>
    <form action="<?php echo U(GROUP_NAME.'/Banji/setNianji');?>" method="POST">
        <table class="table">
            <thead>
                <tr>
                    <th colspan="2">年级列表</th>
                </tr>
                <tr>
                    <td>年级名称</th>
                    <td>入学年</th>
                </tr>
            </thead>
            <tbody>
            <?php if(is_array($nianji)): foreach($nianji as $key=>$v): ?><tr>
                    <input type="hidden" name="id[]" value="<?php echo ($v['id']); ?>" />
                    <td width="10%"><input type="text" value="<?php echo ($v['mingcheng']); ?>" name="mingcheng[]" /></td>
                    <td width="10%"><input type="text" value="<?php echo ($v['ruxuenian']); ?>" name="ruxuenian[]" /></td>
                </tr><?php endforeach; endif; ?>
            <tr>
                <td colspan="2" align="center"><input type="submit" value="设定" /></td>
            </tr>
            </tbody>
        </table>
    </form>
</body>
</html>