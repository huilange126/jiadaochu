<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="大眼仔~旭" />
<!--     <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/public.css" /> -->
    <script type="text/javascript" src="__PUBLIC__/Admin/Js/jquery-1.7.2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.1.0/css/amazeui.min.css" />
    <script type="text/javascript">
    $(function(){
        
        $('.del').click(function(){
            return confirm('确定要删除？');
        });
        
    });
    
    </script>
	<title>教师列表</title>
</head>

<body>
    <div class="am-g am-padding">

      <div class="am-panel am-panel-secondary">
          <div class="am-panel-hd">教师搜索</div>
          <div class="am-panel-bd">
            <form class="am-form am-form-horizontal" method="POST" action="<?php echo U(GROUP_NAME.'/Teacher/index');?>">
                <div class="am-form-group">
                <label for="doc-ipt-3" class="am-u-sm-1 am-form-label">姓名</label>
                <div class="am-u-sm-4 am-u-end">
                    <input type="text" class="" name="xingming" id="doc-ipt-email-1">
                </div>
              </div>
              <div class="am-form-group">
                  <div class="am-u-sm-5 am-u-end am-text-center">
                      <button type="submit" class="am-btn am-btn-primary">搜索</button>
                  </div>
              </div>
          </form>
      </div>
  </div>

</div>
<div class="am-g am-padding">
  <table class="am-table am-table-bordered am-table-striped am-table-hover">
    <thead>
      <tr class="am-primary">
        <th colspan="6">教师列表</th>
      </tr>
      <tr class="am-success">
        <th>ID</th>
        <th>姓名</th>
        <th>身份证</th>
        <td>学科</td>
        <th>任课班级</th>
        <th>操作</th>
      </tr>
    </thead>
    <tbody>
      <?php if(is_array($teacher)): foreach($teacher as $key=>$v): ?><tr>
          <td width="5%"><?php echo ($v['id']); ?></td>
          <td width="10%"><?php echo ($v['name']); ?></td>
          <td width="20%"><?php echo ($v['cid']); ?></td>
          <td width="10%"><?php echo ($v['xueke']); ?></td>
          <td></td>
          <td>
          <a href="<?php echo U(GROUP_NAME.'/Teacher/modify',array('tid'=>$v['id']));?>" class="am-btn am-btn-success am-btn-xs am-margin-right">修改</a>
          <a href="<?php echo U(GROUP_NAME.'/Teacher/del',array('id'=>$v['id']));?>" class="del am-btn am-btn-danger am-btn-xs">删除</a>
          
          </td>
        </tr><?php endforeach; endif; ?>
      <tr><td colspan="6">
        <ul class="am-pagination am-pagination-left">
          <?php echo ($show); ?>
        </ul>
      </td></tr>
    </tbody>
  </table>
</div>
</body>
</html>