<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author"/>
    <!-- <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/public.css" /> -->
    <link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.1.0/css/amazeui.min.css" />
    <script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <title>修改学生成绩页面</title>
</head>

<body>
    <div class="am-g am-padding">
        <div class="am-panel am-panel-secondary">
          <div class="am-panel-hd">
              学生成绩修改
          </div>
          <div class="am-panel-bd">
                <form class="am-form am-form-horizontal" method="POST" action="<?php echo U(GROUP_NAME.'/Chengji/editHandle');?>">
                    <div class="am-form-group">
                        <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">学期</label>
                        <div class="am-u-sm-4 am-u-end">
                            <input type="text" readonly="" value="<?php echo ($term['name']); ?>">
                            <input type="hidden" id="doc-ipt-3" name="term" value="<?php echo ($term['id']); ?>">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">学号</label>
                        <div class="am-u-sm-4 am-u-end">
                            <input type="text" readonly="" value="<?php echo ($student['xuehao']); ?>">
                            <input type="hidden" id="doc-ipt-3" name="xuehao" value="<?php echo ($student['id']); ?>">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">姓名</label>
                        <div class="am-u-sm-4 am-u-end">
                            <input type="text" readonly="" value="<?php echo ($student['name']); ?>">
                        </div>
                    </div>
                    <?php if(is_array($chengji)): foreach($chengji as $key=>$v): ?><div class="am-form-group">
                        <label for="doc-ipt-3" class="am-u-sm-2 am-form-label"><?php echo ($v['xueke']); ?></label>
                        <div class="am-u-sm-4 am-u-end">
                            <input type="text" attr="xueke" name="xueke[<?php echo ($v['xuekeid']); ?>]" value="<?php echo ($v['fenshu']); ?>">
                            <input type="hidden" id="doc-ipt-3" name="xuehao" value="<?php echo ($student['id']); ?>">
                        </div>
                    </div><?php endforeach; endif; ?>
                    <div class="am-form-group">
                    <div class="am-u-sm-6 am-u-end">
                        <button id="btn" class="am-btn am-btn-primary am-center">
                            修改学生成绩
                        </button>
                    </div>
                    </div>
                </form>
          </div>
        </div>
    </div>
    <script>
        $(function(){
            
            $('#btn').click(function(event) {
                var isnull = false;

                $.each($('input[attr=xueke]'), function(index, val) {
                     if($(val).val()==''){
                        isnull = true;
                        return;
                     }
                });
                if(isnull){
                    alert('成绩不能为空');
                    return false;
                }
            });
        });
    </script>
</body>
</html>