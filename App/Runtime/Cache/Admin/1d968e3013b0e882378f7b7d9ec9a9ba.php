<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="大眼仔~旭" />
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/public.css" />
	<title>教师添加页面</title>
</head>

<body>

<form action="<?php echo U(GROUP_NAME.'/Teacher/modifyHandle');?>" method="POST">
    <table class="table">
        <thead>
            <tr>
                <th colspan="2">教师添加</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td align="right">任教学科</td>
                <td>
                    <select class="seltab" name="xueke">
                        <option value="0">-----选择学科-----</option>
                        <?php if(is_array($xueke)): foreach($xueke as $key=>$v): ?><option <?php if($v['id'] == $teacher['xid']): ?>selected="select"<?php endif; ?> value="<?php echo ($v['id']); ?>"><?php echo ($v['xueke']); ?></option><?php endforeach; endif; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="right">姓名</td>
                <td><input type="text" name="name" value="<?php echo ($teacher['name']); ?>" /></td>
            </tr>
            <tr>
                <td align="right">身份证号</td>
                <td><input type="text" name="cid" class="len400" value="<?php echo ($teacher['cid']); ?>" /></td>
            </tr>
            <tr><input type="hidden" value="<?php echo ($teacher['id']); ?>" name="tid" />
                <td colspan="2" align="center"><input type="submit" value="修改" /></td>
            </tr>
        </tbody>
    </table>

</form>

</body>
</html>