<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="大眼仔~旭" />
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/public.css" />
	<title>添加班级页面</title>
</head>

<body>
<form action="<?php echo U(GROUP_NAME.'/Banji/addBanji');?>" method="POST">
<table class="table">
    <thead>
        <tr>
            <th colspan="2">年级班级添加</th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td align="right">入学年</td>
            <td><input type="text" name="ruxuenian" />(如：2013)</td>
        </tr>
        <tr>
            <td align="right">班级数量</td>
            <td><input type="text" name="shuliang" /></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit" value="添加" /></td>
        </tr>
    </tbody>

</table>

</form>


</body>
</html>