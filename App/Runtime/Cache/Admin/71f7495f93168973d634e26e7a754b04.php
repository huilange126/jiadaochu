<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author"/>
    <!-- <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/public.css" /> -->
    <link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.1.0/css/amazeui.min.css" />
    <title>评优规则列表页面</title>
</head>

<body>
    <div class="am-g am-padding">
        <div class="am-panel am-panel-secondary">
          <div class="am-panel-hd">
              规则查询
          </div>
          <div class="am-panel-bd">
                <form class="am-form am-form-horizontal" method="POST" action="<?php echo U(GROUP_NAME.'/Chengji/index');?>">
                    <div class="am-form-group">
                    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">规则关键字</label>
                    <div class="am-u-sm-4 am-u-end">
                      <input type="text" id="doc-ipt-3" name="keywords" placeholder="请输入关键字">
                    </div>
                    </div>
                    <div class="am-form-group">
                    <div class="am-u-sm-6 am-u-end">
                        <button class="am-btn am-btn-primary am-center">
                            搜索评优规则
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
                    <th colspan="6">评优规则列表</th>
                </tr>
                <tr>
                    <td width="5%">序号</td>
                    <td width="8%">适应年级</td>
                    <td width="8%">入学年</td>
                    <td width="15%">评优名称</td>
                    <td>具体要求</td>
                    <td width="15%">操作</td>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($guize)): foreach($guize as $key=>$v): ?><tr>
                        <td><?php echo ++$key;?></td>
                        <td><?php echo ($v['nianji']); ?></td>
                        <td><?php echo ($v['ruxuenian']); ?></td>
                        <td><?php echo ($v['mingcheng']); ?></td>
                        <td>
                            <?php if(is_array($v['yaoqiu'])): foreach($v['yaoqiu'] as $key=>$m): ?><p class="am-margin-xs">
                                <span class="am-text-danger"><?php echo ($m['title']); ?></span>
                                <span class="am-text-primary"><?php echo ($m['message']); ?></span>
                                </p><?php endforeach; endif; ?>
                        </td>
                        <td>
                        <a href="<?php echo U(GROUP_NAME.'/Sanhao/edit',array('id'=>$v['id']));?>" class="am-btn am-btn-primary am-btn-xs">编辑</a>
                        <a href="<?php echo U(GROUP_NAME.'/Sanhao/del',array('id'=>$v['id']));?>" class="am-btn am-btn-danger am-btn-xs">删除</a>
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
</body>
</html>