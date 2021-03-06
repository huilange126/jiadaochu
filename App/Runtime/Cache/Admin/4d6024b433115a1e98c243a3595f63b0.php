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
        <div class="am-panel am-panel-secondary">
          <div class="am-panel-hd">
              学生查询
          </div>
          <div class="am-panel-bd">
                <form class="am-form am-form-horizontal" method="POST" action="<?php echo U(GROUP_NAME.'/Chengji/index');?>">
                    <div class="am-form-group">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">学号或姓名</label>
                    <div class="am-u-sm-4 am-u-end">
                      <input type="text" id="doc-ipt-3" name="keywords" placeholder="请输入关键字">
                    </div>
                    </div>
                    <div class="am-form-group">
                    <div class="am-u-sm-6 am-u-end">
                        <button class="am-btn am-btn-primary am-center">
                            搜索学生
                        </button>
                    </div>
                    </div>
                </form>
          </div>
        </div>
    </div>
    <div class="am-g am-padding">
        <table  class="am-table am-table-bordered am-table-striped am-table-hover">
            <thead>
                <tr>
                    <th colspan="5">学生列表</th>
                </tr>
                <tr>
                    <td width="5%">序号</td>
                    <td width="10%">学号</td>
                    <td width="10%">姓名</td>
                    <td width="10%">班级</td>
                    <td>操作</td>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($student)): foreach($student as $key=>$v): ?><tr>
                        <td><?php echo ++$key;?></td>
                        <td><?php echo ($v['xuehao']); ?></td>
                        <td><?php echo ($v['name']); ?></td>
                        <td><?php echo ($v['ruxuenian']); ?>级<?php echo ($v['banji']); ?>班</td>
                        <td>
                        <a href="<?php echo U(GROUP_NAME.'/Chengji/termlist',array('id'=>$v['id']));?>" class="am-btn am-btn-primary am-btn-xs">查看学生成绩</a>
                        </td>
                    </tr><?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>