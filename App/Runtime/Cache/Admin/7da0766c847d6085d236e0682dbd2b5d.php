<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="autdor" content="大眼仔~旭" />
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/amazeui2.6/css/amazeui.min.css" />
    <title>班级列表</title>
</head>

<body>
<div class="am-g am-padding">
 <form class="am-form">
     <table  class="am-table am-table-bordered am-table-striped am-table-hover am-text-center">
        <tdead>
            <tr class="am-primary">
                <td colspan="5" class="am-text-left">班级列表</td>
            </tr>
            <tr class="am-active">
                <td style="width:5%">序号</td>
                <td style="width:10%">入学年份</td>
                <td style="width:5%">班级</td>
                <td style="width:10%">班级用户名</td>
                <td>操作</td>
            </tr>
        </tdead>
        <tbody>
            <?php if(is_array($banji)): foreach($banji as $key=>$v): ?><tr>
                    <td><?php echo ++$num;?></td>
                    <td><?php echo ($v['ruxuenian']); ?></td>
                    <td><?php echo ($v['banji']); ?></td>
                    <td><?php echo ($v['username']); ?></td>
                    <td>
                        
                        <div class="am-form-group am-fl am-margin-left am-margin-right">
                            <select id="doc-select-1" class="am-input-sm  am-form-select" name="banzhuren">
                                <option value="0" attr="<?php echo ($v['id']); ?>">请选择班主任</option>
                                <?php if(is_array($teacher)): foreach($teacher as $key=>$m): ?><option <?php if($v['banzhuren'] == $m['id']): ?>selected="selected"<?php endif; ?> value="<?php echo ($m['id']); ?>" attr="<?php echo ($v['id']); ?>"><?php echo ($m['name']); ?>&nbsp;&nbsp;(<?php echo ($m['xueke']); ?>)</option><?php endforeach; endif; ?>
                            </select>
                            <span class="am-form-caret"></span>
                        </div>
                        <a href="<?php echo U(GROUP_NAME.'/Banji/reset',array('id'=>$v['id']));?>" onclick="return confirm('确定要重置密码？');" class="am-btn am-btn-primary am-btn-md am-fl">重置密码</a>
                    </td>
                </tr><?php endforeach; endif; ?>
            <tr class="am-active">
                <td colspan="5">
                    <ul class="am-pagination am-pagination-left">
                        <?php echo ($show); ?>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table> 
</form>  
</div>
<script type="text/javascript" src="__PUBLIC__/amazeui2.6/js/jquery.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/amazeui2.6/js/amazeui.min.js"></script>
<script>
    $(function(){
        $('select[name=banzhuren]').change(function(event) {
            var banji = $(this).find('option:selected').attr('attr');
            var banzhuren = $(this).val();
            // alert(banzhuren);
            $.ajax({
              type: 'POST',
              url: "<?php echo U(GROUP_NAME.'/Banji/addBanzhuren');?>",
              data: {banji:banji,banzhuren:banzhuren},
              success: function(data){
                if(data==0){
                    alert('班主任设定出错，请重试！');
                }
              },
              dataType: 'json'
            });
        });
    });
</script>
</body>
</html>