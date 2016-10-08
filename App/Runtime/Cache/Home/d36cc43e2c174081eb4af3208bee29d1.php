<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="优秀班集体评价" />
    <link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.1.0/css/amazeui.min.css" />
    <script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
	<title><?php echo (C("webname")); ?>优秀班集体评价</title>
</head>

<body>
<div class="am-g am-g-fixed">
    <div class="am-u-sm-5">
       <img src="__ROOT__/Uploads/<?php echo (C("logo")); ?>" style="width: 120px;" alt="" class="am-img-responsive am-margin am-fr"> 
    </div>
    <div class="am-u-sm-7">
        <h1 class="am-text-primary am-margin-top"><?php echo (C("webname")); ?></h1>
        <h2 class="am-text-success am-margin-top"><?php echo (C("sysname")); ?></h2>
        <h2 class="am-text-warning am-margin-top">教师评价班级登录</h2>
    </div>
    
</div>
<hr />
<div class="am-g am-g-fixed">
    <div class="am-u-md-6 am-u-md-centered">
    <form action="<?php echo U(GROUP_NAME.'/Banji/loginHandle');?>" method="POST">
        <div class="am-form">
            <div class="am-form-group">
                <label class="am-text-primary am-text-lg">
                    请输入身份证号码
                </label>
                <input type="text" name="shenfenzheng" />
            </div>
            <div class="am-form-group">
                <label class="am-text-primary am-text-lg">
                    请输入姓名
                </label>
                <input type="text" name="xingming" />
            </div>
            <button type="submit" id="btn" class="am-btn am-btn-primary am-btn-block">登陆系统</button>
        </div>
    </form>
    </div>
</div>
<script>
    $(function(){
        $("#btn").click(function(){
             if($('input[name=shenfenzheng]').val()==''){
                alert('身份证号不能为空');
                return false;
             }
             if($('input[name=xingming]').val()==''){
                alert('姓名不能为空');
                return false;
             }
             
        });

    });
</script>
</body>
</html>