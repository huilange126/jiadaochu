<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="大眼仔~旭" />
    <!-- <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/public.css" /> -->
    <link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.5.2/css/amazeui.min.css" />
	<title>学期列表</title>
</head>

<body>
    <div class="am-g am-padding">
        <div class="am-panel am-panel-secondary">
          <div class="am-panel-hd">
            学期添加
          </div>
          <div class="am-panel-bd">
            <form  action="<?php echo U(GROUP_NAME.'/Term/addTerm');?>" method="POST" class="am-form am-form-horizontal">
                <div class="am-form-group">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">学期名称</label>
                    <div class="am-u-sm-4 am-u-end">
                      <input type="text" name="name" />
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">学期状态</label>
                    <div class="am-u-sm-4 am-u-end">
                      <label class="am-radio-inline">
                        <input type="radio" name="status" value="0" />禁用
                      </label>
                      <label class="am-radio-inline">
                        <input type="radio" checked="checked" name="status" value="1" />启用
                      </label>
                    </div>
                </div>
                <div class="am-form-group">
                    <div class="am-u-sm-6 am-u-end">
                        <button class="am-btn am-btn-primary am-center">添加新学期</button>
                    </div>
                </div>
            </form>
          </div>
        </div>
    </div>
    <div class="am-g am-padding">
        <table class="am-table am-table-bordered am-table-striped am-table-hover">
            <thead>
                <tr  class="am-primary">
                    <td colspan="4">学期列表</td>
                </tr>
                <tr  class="am-success">
                    <td  class="am-text-center" style="width: 5%">ID</td>
                    <td  class="am-text-center" style="width: 30%">名称</td>
                    <td  class="am-text-center" style="width: 5%">状态</td>
                    <td  class="am-text-center">操作</td>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($term)): foreach($term as $key=>$v): ?><tr>
                        <td class="am-text-center"><?php echo ($v['id']); ?></td>
                        <td><?php echo ($v['name']); ?></td>
                        <td  class="am-text-center">
                            <?php if($v['status'] == 1): ?><span class="am-btn am-btn-success am-btn-xs">启用</span>
                            <?php else: ?>
                                <span class="am-btn am-btn-danger am-btn-xs">禁用</span><?php endif; ?>
                        </td>
                        <td>
                            <a class="am-btn am-btn-success am-btn-xs" href="<?php echo U(GROUP_NAME.'/Term/modify',array('id'=>$v['id']));?>">修改</a>
                             <a href="#" class="am-btn am-btn-danger am-btn-xs">删除</a>

                        </td>
                    </tr><?php endforeach; endif; ?>
                <tr>
                    <td colspan="4">
                        <ul class="am-pagination">
                        <?php echo ($show); ?>
                      </ul>
                  </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>