<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="大眼仔~旭" />
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/public.css" />
    <script type="text/javascript" src="__PUBLIC__/Js/jquery-1.10.2.min.js"></script>
	<title>任课管理</title>
    <script type="text/javascript">
        $(document).ready(function(){
            var postURL = "<?php echo U(GROUP_NAME.'/Renke/addRenke');?>";
            var reloadURL = "<?php echo U(GROUP_NAME.'/Renke/renke');?>";
            //$('#my-select').click();
            $('#my-select').dblclick(function(){
                var isHave = false;
                $('#your-select option').each(function(){       
                    if($('#my-select').val()==$(this).val()) isHave =true;
                    
                });
                if(!isHave){
                    $('#your-select').append("<option value='"+$('#my-select').val()+"'>"+$('#my-select').find('option:selected').text()+"</option>")
                    //$('#my-select option:selected').remove();
                }
                
            });
            
            $('#your-select').dblclick(function(){
                //$('#my-select').append("<option value='"+$('#your-select').val()+"'>"+$('#your-select').find('option:selected').text()+"</option>")
                $('#your-select option:selected').remove();
            });
            
            $('#btn-tijiao').click(function(){
                
                if($('#banji').html()==""){
                    alert('请先选择班级');
                    return false;
                }else{
                    var banji = $('#hidbanji').val();
                }
                
                var myselect='start';
                $('#your-select option').each(function(){
                    
                    myselect = myselect +','+ $(this).val();
                    
                });
                if(myselect=='start'){
                    alert('请添加老师');
                    return false;
                }
                
                var term = $('#hidterm').val();
                
                $.post(postURL,{banji:banji,myselect:myselect,term:term},function(data){
                    
                    if(data.status==1){
                        
                        alert('添加成功');
                        
                        //location.reload(reloadURL);
                        
                        location.href = reloadURL;
                    }
                    
                });
                
            });
        });
        
        function aclick(obj){
            
            $('#banji').html(obj.id);
            $('#hidbanji').val(obj.title);

        }
    </script>
</head>

<body>
<form action="" method="POST">
    <table class="table">
        <thead>
            <td colspan="5">教师任课管理</td>
        </thead>
        <tr>
            <td colspan="5">
                <table class="table">
                    <thead>
                        <td colspan="18">班级列表</td>
                    </thead>
                    <tbody>
                    <?php if(is_array($banji)): foreach($banji as $key=>$v): ?><tr>
                        <?php if(is_array($v)): foreach($v as $key=>$m): ?><td><a href="<?php echo U(GROUP_NAME.'/Renke/renke',array('term'=>$term['id'],'bid'=>$m['id']));?>"><?php echo ($m['ruxuenian']); ?>级<?php echo ($m['banji']); ?>班</a></td><?php endforeach; endif; ?>
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                    <thead>
                        <tr>
                            <td colspan="6">当前学期：<?php echo ($term['name']); ?><input type="hidden" value="<?php echo ($term['id']); ?>" id="hidterm" /></td>
                            <td colspan="12">当前选定班级：<label id="banji"><?php echo ($bname); ?></label><input type="hidden" id="hidbanji" value="<?php echo ($bid); ?>" /></td>
                        </tr>
                    </thead>
                </table>
            </td>
        </tr>
        <tr>
            <td width="25%"></td>
            <td width="20%">
                <select multiple="true" size="20" id="my-select" style="width: 200px; height: 300px;"  >
                    <?php if(is_array($teacher)): foreach($teacher as $key=>$t): ?><option value="<?php echo ($t['id']); ?>">&nbsp;&nbsp;<?php echo ($t['xueke']); ?>&nbsp;&nbsp;<?php echo ($t['name']); ?></option><?php endforeach; endif; ?>
                </select>
            </td>
            <td  width="10%"></td>
            <td  width="20%">
                <select multiple="true" size="20" style="width: 200px; height: 300px;" id="your-select" >
                    <?php if(is_array($renke)): foreach($renke as $key=>$n): ?><option value="<?php echo ($n['id']); ?>">&nbsp;&nbsp;<?php echo (getteacherxueke($n['id'])); ?>&nbsp;&nbsp;<?php echo ($n['name']); ?></option><?php endforeach; endif; ?>
                </select>
            </td>
            <td width="25%"></td>
        </tr>
        <tr><td colspan="5" align="center"><input type="button" value="提交" id="btn-tijiao" /></td></tr>
    </table>
</form>


</body>
</html