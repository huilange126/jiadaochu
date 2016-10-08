<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author"/>
    <!-- <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/public.css" /> -->
    <link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.1.0/css/amazeui.min.css" />
    <title>修改学生成绩页面</title>
</head>

<body>
    <div class="am-g am-padding">
        <table  class="am-table am-table-bordered am-table-striped am-table-hover">
            <thead>
                <tr class="am-primary">
                    <th colspan="4"><?php echo ($student['xuehao']); echo ($student['name']); ?>成绩列表</th>
                </tr>
                <tr>
                    <td>序号</td>
                    <td>学期</td>
                    <td>成绩</td>
                    <td>操作</td>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($termlist)): foreach($termlist as $key=>$v): ?><tr>
                        <td width="5%"><?php echo ++$key;?></td>
                        <td width="20%"><?php echo ($v['name']); ?></td>
                        <td>
                            <?php if(is_array($v['chengji'])): foreach($v['chengji'] as $key=>$m): ?><span class="am-margin-right-xs"><?php echo ($m['xueke']); echo ($m['fenshu']); ?></span><?php endforeach; endif; ?>
                        </td>
                        <td width="20%">
                        <a href="<?php echo U(GROUP_NAME.'/Chengji/edit',array('termid'=>$v['id'],'studentid'=>$student['id']));?>" class="am-btn am-btn-primary am-btn-xs">修改学生成绩</a>
                        </td>
                    </tr><?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>