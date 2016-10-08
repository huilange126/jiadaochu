<?php if (!defined('THINK_PATH')) exit();?>    <!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo (C("webname")); ?>教导处管理平台</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
	<link rel="stylesheet" type="text/css" href="__PUBLIC__/amazeui2.6/css/amazeui.min.css" />
	<link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/app.css" />

</head>
<style>
	.topheader{
		height:120px;
		background-color:#0e90d2;
		border:1px solid #efefef;
		},
	body{
			background-color: #efefef;
		}
	.banner{
		color: #ffffff;
	}
</style>
<body>
	<!--[if lt IE 9]>
	<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
	<script src="assets/js/amazeui.ie8polyfill.min.js"></script>
	<![endif]-->

	<!--[if (gte IE 9)|!(IE)]><!-->
	<script src="__PUBLIC__/amazeui2.6/js/jquery.min.js"></script>
	<!--<![endif]-->
	<script src="__PUBLIC__/amazeui2.6/js/amazeui.min.js"></script>
	<div class="am-g am-g-fixed topheader">
		<div class="am-u-sm-2">
			<img src="__ROOT__/Uploads/<?php echo (C("logo")); ?>" class="am-img-responsive am-fr am-padding-top-xs" style="height:110px;" alt="">
		</div>
		<div class="am-u-sm-10">
			<h1 class="am-padding-top-xl banner"><?php echo (C("webname")); ?>::<?php echo (C("sysname")); ?></h1>
		</div>
	</div>
    <style>
    .radio-choose label{
        font-weight: normal;
        font-size:16px;
    }
    </style>
    <script type="text/javascript">
        // var count = <?php echo count($project['choose']) ?>;
        var count = <?php echo (count($project['choose'])); ?>;
        var checklist = new Array(count);//用于检测那个题目被选过了
        $(document).ready(function(){
            
        });
        
        function mycheck(span,shunxu){
            checklist[shunxu-1] = $('#'+span).html();
        }
        
        function btnclick(){
            if($('#nowteacher').val()==''){
                alert('请先选择教师');
                return false;
            }
            var nochecklist = '还有';
            var nochecknums = 0;
            for(i=0;i<count;i++){
                if(checklist[i]==null){
                    nochecklist=nochecklist+'第'+String(i+1)+'个评价、';
                    nochecknums++;
                }
            }
            nochecklist=nochecklist+'没有选';
            if(nochecknums==0){
                
            }else{
                alert(nochecklist);
                return false;
            }
            
        }
    </script>
    <!--基础信息-->
    <div class="am-g am-g-fixed am-margin-top">
        <div class="am-panel am-panel-secondary">
            <div class="am-panel-hd">
                基本信息
                <a href="<?php echo U(GROUP_NAME.'/Ping/logout');?>" class="am-btn am-btn-warning am-btn-xs am-fr">退出评价系统</a>
            </div>
            <div class="am-panel-bd">
                学期：<?php echo ($project['term']); ?>，进行中项目：<?php echo ($project['name']); ?>，姓名：<?php echo ($student['name']); ?>
            </div>
        </div>
    </div>
    <!-- 基础信息结束 -->
    <!-- 主体信息开始 -->
    <div class="am-g am-g-fixed am-margin-top">
        <!-- 评价项目列表开始 -->
        <div class="am-u-sm-8" style="padding:0px;">
            <div class="am-panel am-panel-secondary" style="margin: 0px;">
                <div class="am-panel-hd">
                评价内容
                <span class="am-fr">正在评价老师：
                <span id="teacher" style="color: red;"><?php echo ($nowTeacher['name']); ?></span>
                </span>
                </div>
                <div class="am-panel-bd">
                <form method="POST" action="<?php echo U(GROUP_NAME.'/Ping/addPing');?>" class="am-form">
                <?php $i=1;?>
                <?php if(is_array($project['choose'])): foreach($project['choose'] as $key=>$v): ?><input type="hidden" name="nowteacher" id="nowteacher" value="<?php echo ($nowTeacher['id']); ?>" />
                <input type="hidden" name="term" value="<?php echo ($term['id']); ?>" />
                <input type="hidden" name="nowproject" value="<?php echo ($project['id']); ?>" />
                <input type="hidden" name="nowstudent" value="<?php echo ($student['id']); ?>" />
                    <div class="am-form-group">
                        <label for="doc-ipt-email-1"><span id="choose<?php echo ($i); ?>"><?php echo ($i); ?>：</span><?php echo ($v['name']); ?></label>
                        <div class="radio-choose">
                        <label class="am-margin-left"><input type="radio" onclick="mycheck('choose<?php echo ($i); ?>',<?php echo ($key+1); ?>)" name="ping[<?php echo ($v['id']); ?>]" value="1" />&nbsp;&nbsp;<?php echo ($v['c1']); ?></label>
                            <label class="am-margin-left"><input type="radio" onclick="mycheck('choose<?php echo ($i); ?>',<?php echo ($key+1); ?>)" name="ping[<?php echo ($v['id']); ?>]" value="2" />&nbsp;&nbsp;<?php echo ($v['c2']); ?></label>
                            <label class="am-margin-left"><input type="radio" onclick="mycheck('choose<?php echo ($i); ?>',<?php echo ($key+1); ?>)" name="ping[<?php echo ($v['id']); ?>]" value="3" />&nbsp;&nbsp;<?php echo ($v['c3']); ?></label>
                            <label class="am-margin-left"><input type="radio" onclick="mycheck('choose<?php echo ($i); ?>',<?php echo ($key+1); ?>)" name="ping[<?php echo ($v['id']); ?>]" value="4" />&nbsp;&nbsp;<?php echo ($v['c4']); ?></label>
                        </div>
                    </div>
                    <?php $i++; endforeach; endif; ?>
                <button class="am-btn am-btn-primary am-btn-block"  onclick="javascript:return btnclick();">提交评价</button>
                </form>
                </div>
            </div>
        </div>
        <!-- 评价项目列表结束 -->
        <!-- 左侧教师列表开始 -->
        <div class="am-u-sm-4" style="padding-right:0px;">
            <div class="am-panel am-panel-secondary">
                <div class="am-panel-hd">教师列表</div>
                <ul class="am-list">
                <?php if(is_array($teacher)): foreach($teacher as $key=>$v): ?><li>
                        <?php if(checkTeacherStatus($project['id'],$student['id'],$v['id']) == 1): ?><a href="#" class="am-btn am-btn-warning am-disabled am-text-left"><?php echo ($v['xueke']); ?>&nbsp;&nbsp;<?php echo ($v['name']); ?>&nbsp;&nbsp;已经评价</a>
                            <?php else: ?>
                            <a href="<?php echo U(GROUP_NAME.'/Ping/index',array('pid'=>$project['id'],'sid'=>$student['id'],'tid'=>$v['id']));?>"  class="am-btn am-btn-primary am-text-left"><?php echo ($v['xueke']); ?>&nbsp;&nbsp;<?php echo ($v['name']); ?></a><?php endif; ?>
                    </li><?php endforeach; endif; ?>
                </ul>
            </div>
        </div>
        <!-- 左侧教师列表结束 -->
    </div>
    <!-- 主体信息结束 -->
<!--底部-->
<footer>
	<p class="am-text-center"><?php echo (C("copyright")); ?></p>
</footer>
</body>
</html>