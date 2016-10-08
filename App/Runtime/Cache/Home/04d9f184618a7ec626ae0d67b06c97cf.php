<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>评价页面</title>
	<link rel="stylesheet" href="__PUBLIC__/Blog/Css/common.css" />
	<link rel="stylesheet" href="__PUBLIC__/Blog/Css/show.css" />
	<script type="text/JavaScript" src='__PUBLIC__/Blog/Js/jquery-1.7.2.min.js'></script>
	<script type="text/JavaScript" src='__PUBLIC__/Blog/Js/common.js'></script>
    <script type="text/javascript">
        // var count = <?php echo count($project['choose']) ?>;
        var count = <?php echo (count($project['choose'])); ?>;
        var checklist = new Array(count);//用于检测那个题目被选过了
        $(document).ready(function(){
            
        });
        
        function mycheck(span,shunxu){
                
                checklist[shunxu-1] = $('#'+span).html();
                
                //alert(checklist.toString());
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
</head>
<body>
<!--头部-->
	<div class='top-list-wrap'>
		<div class='top-list'>
			<ul class='l-list'>
				<li><a href="http://www.qdyc.qdedu.net" target='_blank'>青岛实验初级中学</a></li>
			</ul>
            <ul class="r-list">
                <li><a href="<?php echo U(GROUP_NAME.'/Ping/logout');?>">退出评价</a></li>
            </ul>
		</div>
	</div>


	<div class='top-search-wrap'>
		<div class='top-search'>
			<a href="http://bbs.houdunwang.com" target='_blank' class='logo'>
				<img src="__PUBLIC__/Blog/Images/logo.png"/>
			</a>
		</div>
	</div>
<!--主体-->
    <form method="POST" action="<?php echo U(GROUP_NAME.'/Ping/addPing');?>">
	<div class='main'>
		<div class='main-left'>
			<div class='location'>
				<?php echo ($project['term']); ?>::<?php echo ($project['name']); ?><input type="hidden" name="term" value="<?php echo ($term['id']); ?>" />::参评人：<?php echo ($student['name']); ?><input type="hidden" name="nowproject" value="<?php echo ($project['id']); ?>" /><input type="hidden" name="nowstudent" value="<?php echo ($student['id']); ?>" />&nbsp;&nbsp;正在评价老师：<span id="teacher" style="color: red;"><?php echo ($nowTeacher['name']); ?><input type="hidden" name="nowteacher" id="nowteacher" value="<?php echo ($nowTeacher['id']); ?>" /></span>
			</div>
            <?php $i=1;?>
            <?php if(is_array($project['choose'])): foreach($project['choose'] as $key=>$v): ?><div class="title">
    				<p>评价<span id="choose<?php echo ($i); ?>"><?php echo ($i); ?></span>：<?php echo ($v['name']); ?></p>
    				<div>
    					<span class='fl'>
                            <label style="margin-left: 5px;"><input type="radio" onclick="mycheck('choose<?php echo ($i); ?>',<?php echo ($i); ?>)" name="ping[<?php echo ($v['id']); ?>]" value="1" />&nbsp;&nbsp;<?php echo ($v['c1']); ?></label>
                            <label><input type="radio" onclick="mycheck('choose<?php echo ($i); ?>',<?php echo ($i); ?>)" name="ping[<?php echo ($v['id']); ?>]" value="2" />&nbsp;&nbsp;<?php echo ($v['c2']); ?></label>
                            <label><input type="radio" onclick="mycheck('choose<?php echo ($i); ?>',<?php echo ($i); ?>)" name="ping[<?php echo ($v['id']); ?>]" value="3" />&nbsp;&nbsp;<?php echo ($v['c3']); ?></label>
                            <label><input type="radio" onclick="mycheck('choose<?php echo ($i); ?>',<?php echo ($i); ?>)" name="ping[<?php echo ($v['id']); ?>]" value="4" />&nbsp;&nbsp;<?php echo ($v['c4']); ?></label>
                            <?php $i++;?>
                        </span>
    				</div>
    			</div><?php endforeach; endif; ?>
            <div class='location'>
				<input type="submit" class="submit" value="评价" id="btn-tijiao" onclick="javascript:return btnclick();" />
			</div>
		</div>
          </form>
	<!--主体右侧-->

		<div class='main-right'>
			<dl>
				<dt>教师列表<input type="hidden" name="hidcount" value="<?php echo ($count); ?>" /></dt>
                <?php if(is_array($teacher)): foreach($teacher as $key=>$v): ?><dd>
                    <?php if(checkTeacherStatus($project['id'],$student['id'],$v['id']) == 1): echo ($v['xueke']); ?>&nbsp;&nbsp;<?php echo ($v['name']); ?>&nbsp;&nbsp;已经评价
					<?php else: ?>
                    <a href="<?php echo U(GROUP_NAME.'/Ping/index',array('pid'=>$project['id'],'sid'=>$student['id'],'tid'=>$v['id']));?>"><?php echo ($v['xueke']); ?>&nbsp;&nbsp;<?php echo ($v['name']); ?></a><?php endif; ?>
				</dd><?php endforeach; endif; ?>
			</dl>
		</div>
	</div>
<!--底部-->
	<div class='bottom'>
		<div></div>
	</div>
</body>
</html>