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
    <title><?php echo (C("webname")); ?>用户登录</title>
</head>

<body>
<div class="am-g am-g-fixed">
    <div class="am-u-sm-5 am-u-md-5 am-show-md-up">
       <img src="__ROOT__/Uploads/<?php echo (C("logo")); ?>" style="height: 150px;" alt="" class="am-img-responsive am-margin am-fr"> 
    </div>
    <div class="am-u-sm-5 am-u-md-5 am-show-sm-only">
       <img src="__ROOT__/Uploads/<?php echo (C("logo")); ?>" alt="" class="am-img-responsive am-margin am-fr"> 
    </div>
    <div class="am-u-sm-7 am-u-md-7" >
        <div class="am-g">
            <h1 class="am-text-primary am-padding-top-sm"><?php echo (C("webname")); ?></h1>
        </div>
        <div class="am-g">
            <h2 class="am-text-success am-padding-top-sm"><?php echo (C("sysname")); ?></h2>
        </div>
        <div class="am-g">
            <h2 class="am-text-warning am-padding-top-sm">用户登录</h2>
        </div>
    </div>
    
</div>
<hr />
<div class="am-g am-g-fixed">
    <div class="am-u-md-6 am-u-md-centered">
    <form action="<?php echo U(GROUP_NAME.'/Login/loginHandle');?>" method="POST">
        <div class="am-form">
            <div class="am-form-group">
                <label class="am-text-primary am-text-lg">
                    请输入用户名
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
                alert('用户名不能为空');
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