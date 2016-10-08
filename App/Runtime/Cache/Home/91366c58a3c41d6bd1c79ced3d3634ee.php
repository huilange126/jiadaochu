<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="教导处管理平台" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/amazeui2.6/css/amazeui.min.css" />
    <title><?php echo (C("webname")); ?>评教登录</title>
</head>

<body>
<div class="am-g am-g-fixed">
    <div class="am-u-sm-5">
       <img src="__ROOT__/Uploads/<?php echo (C("logo")); ?>" style="width: 120px;" alt="" class="am-img-responsive am-margin am-fr"> 
    </div>
    <div class="am-u-sm-7">
        <h1 class="am-text-primary am-margin-top"><?php echo (C("webname")); ?></h1>
        <h2 class="am-text-success am-margin-top"><?php echo (C("sysname")); ?></h2>
        <h2 class="am-text-warning am-margin-top">学生登录</h2>
    </div>
    
</div>
<hr />
<div class="am-g am-g-fixed">
    <div class="am-u-md-6 am-u-md-centered">
    <form action="<?php echo U(GROUP_NAME.'/Index/login');?>" method="POST">
        <div class="am-form">
            <div class="am-form-group">
                <label  class="am-text-primary am-text-lg">请选择评价项目</label>
                <select id="doc-select-1" name="project">
                    <?php if(empty($project) == true): ?><option value="0">暂无评价项目</option>
                    <?php else: ?>
                    <?php if(is_array($project)): foreach($project as $key=>$v): ?><option value="<?php echo ($v['id']); ?>"><?php echo ($v['name']); ?></option><?php endforeach; endif; endif; ?>
                </select>
                <span class="am-form-caret"></span>
            </div>
            <div class="am-form-group">
                <label class="am-text-primary am-text-lg">
                    请输入学号
                </label>
                <input type="text" name="username" />
            </div>
            <div class="am-form-group">
                <label class="am-text-primary am-text-lg">
                    请输入密码
                </label>
                <input type="password" name="password" />
            </div>
            <button type="submit" id="btn" class="am-btn am-btn-primary am-btn-block">登陆系统</button>
        </div>
    </form>
    </div>
</div>
<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="__PUBLIC__/amazeui2.6/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="__PUBLIC__/amazeui2.6/js/amazeui.min.js"></script>
<script>
    $(function(){
        $("#btn").click(function(){
             if($('input[name=username]').val()==''){
                alert('学号不能为空');
                return false;
             }
             if($('input[name=password]').val()==''){
                alert('密码不能为空');
                return false;
             }
             
        });

    });
</script>
</body>
</html>