<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="大眼仔~旭" />
    <!-- <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/public.css" /> -->
    <link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.1.0/css/amazeui.min.css" />
    <title>学生列表页面</title>
</head>

<body>
    <div class="am-g am-padding">
        <div class="am-panel am-panel-secondary">
          <div class="am-panel-hd">
              学生查询
          </div>
          <div class="am-panel-bd">
                <form class="am-form am-form-horizontal" method="POST" action="<?php echo U(GROUP_NAME.'/Student/index');?>">
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
    <div class="am-g am-padding-left am-padding-right">
        <div class="am-panel am-panel-secondary">
            <div class="am-panel-bd">
                <?php if(is_array($nianji)): foreach($nianji as $key=>$v): ?><a href="<?php echo U(GROUP_NAME.'/Student/daochu',array('ruxuenian'=>$v['ruxuenian']));?>" class="am-btn am-btn-primary am-btn-xs am-margin-left">导出<?php echo ($v['mingcheng']); ?>学生名单</a><?php endforeach; endif; ?>
            </div>
        </div>  
    </div>
    <div class="am-g am-padding">
        <table  class="am-table am-table-bordered am-table-striped am-table-hover">
            <thead>
                <tr>
                    <th colspan="6">学生列表</th>
                </tr>
                <tr>
                    <td>ID</td>
                    <td>学号</td>
                    <td>姓名</td>
                    <td>性别</td>
                    <td>班级</td>
                    <td>操作</td>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($student)): foreach($student as $key=>$v): ?><tr>
                        <td width="5%"><?php echo ($jishu++); ?></td>
                        <td width="10%"><?php echo ($v['xuehao']); ?></td>
                        <td width="10%"><?php echo ($v['name']); ?></td>
                        <td width="5%"><?php if($v['xingbie'] == 1): ?>男<?php else: ?>女<?php endif; ?></td>
                        <td width="10%"><?php echo ($v['ruxuenian']); ?>级<?php echo ($v['banji']); ?>班</td>
                        <td>
                        <a href="<?php echo U(GROUP_NAME.'/Student/modify',array('id'=>$v['id']));?>" class="am-btn am-btn-primary am-btn-xs">修改</a>
                        <a href="<?php echo U(GROUP_NAME.'/Student/del',array('id'=>$v['id']));?>" class="am-btn am-btn-danger am-btn-xs" onclick="return del();">删除</a>

                        </td>
                    </tr><?php endforeach; endif; ?>
                <tr>
                    <td colspan="6">
                        <ul class="am-pagination am-pagination-left">
                            <?php echo ($show); ?>
                        </ul>
                    </td>
                </tr>
            </tbody>

        </table>
    </div>
<script>
    function del(){

        if(confirm('确定要删除该学生么？')){
            return true;
        }else{
            return false;
        }
    }
</script>
</body>
</html>