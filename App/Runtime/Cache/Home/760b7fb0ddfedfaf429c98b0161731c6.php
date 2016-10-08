<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<link rel="stylesheet" href="__PUBLIC__/Admin/Css/login.css" />
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
        <script type="text/javascript">
            var verifyURL = "<?php echo U(GROUP_NAME.'/Index/verify','','');?>";
        </script>
	<script type="text/javascript" src="__PUBLIC__/Admin/Js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="__PUBLIC__/Admin/Js/login.js"></script>
    <title>用户登陆界面</title>
	</head>
	<body>

		<div class="login">	
		<div id="top">
			<img src="./Uploads/<?php echo (C("logo")); ?>" style="float: left;" alt="" />
			<span><?php echo (C("webname")); ?>评价登录</span>
		</div>
			<form action="<?php echo U(GROUP_NAME.'/Index/login');?>" method="post" id="login">
<!-- 			<div class="title">
				登陆评价
			</div> -->
			<table border="1" width="100%">
                <tr>
                    <th>评价类型：</th>
                    <td>
                        <select name="project" style="width:120px; height:28px; padding-top:3px;">
                            <option value="0">选择评价类型</option>
                            <?php if(is_array($project)): foreach($project as $key=>$v): ?><option value="<?php echo ($v['id']); ?>"><?php echo ($v['name']); ?></option><?php endforeach; endif; ?>
                        </select>
                        <?php echo ($message); ?>
                    </td>
                </tr>
				<tr>
					<th>帐号:</th>
					<td>
						<input type="username" name="username" class="len250"/>
					</td>
				</tr>
				<tr>
					<th>密码:</th>
					<td>
						<input type="password" class="len250" name="password"/>
					</td>
				</tr>
				<tr>
					<th>验证码:</th>
					<td>
						<input type="code" class="len250" name="code"/> <img src="<?php echo U(GROUP_NAME.'/Index/verify');?>" id="code"/> <a href="javascript:void(change_code(this));">看不清</a>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="padding-left:160px;"> <input type="submit" class="submit" value="登录"/></td>
				</tr>
			</table>
		</form>
	</div>

	</body>
</html>