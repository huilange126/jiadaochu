<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo (C("webname")); ?>教导处管理平台</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
	<link rel="stylesheet" type="text/css" href="__PUBLIC__/amazeui2.6/css/amazeui.min.css" />
	<link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/app.css" />

</head>
<style>
	.topheader{
		height:120px;
		background-color:#0e90d2;
		border:1px solid #efefef;
		},
	body{
			background-color: #efefef;
		}
	.banner{
		color: #ffffff;
	}
</style>
<body>
	<!--[if lt IE 9]>
	<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
	<script src="assets/js/amazeui.ie8polyfill.min.js"></script>
	<![endif]-->

	<!--[if (gte IE 9)|!(IE)]><!-->
	<script src="__PUBLIC__/amazeui2.6/js/jquery.min.js"></script>
	<!--<![endif]-->
	<script src="__PUBLIC__/amazeui2.6/js/amazeui.min.js"></script>
	<div class="am-g am-g-fixed topheader">
		<div class="am-u-sm-2">
			<img src="__ROOT__/Uploads/<?php echo (C("logo")); ?>" class="am-img-responsive am-fr am-padding-top-xs" style="height:110px;" alt="">
		</div>
		<div class="am-u-sm-10">
			<h1 class="am-padding-top-xl banner"><?php echo (C("webname")); ?>::<?php echo (C("sysname")); ?></h1>
		</div>
	</div>
<div class="am-g am-g-fixed am-margin-top">
	<div class="am-panel am-panel-secondary">
		<div class="am-panel-hd am-cf">基础信息<a href="<?php echo U(GROUP_NAME.'/Login/logout');?>" class="am-btn am-btn-primary am-btn-xs am-fr">退出评价</a></div>
		<div class="am-panel-bd am-cf">
			<div class="am-u-sm-2">
				<label for="">班级</label>
				<?php echo ($banji['ruxuenian']); ?>级<?php echo ($banji['banji']); ?>班
			</div>
			<div class="am-u-sm-4 am-u-end">
				<label for="">学期</label>
				<?php echo ($term['name']); ?>
			</div>
		</div>
		
	</div>

	<div class="am-panel am-panel-secondary">
		<div class="am-panel-hd am-cf">评优项目<a href="<?php echo U(GROUP_NAME.'/Jiaodaochu/index');?>" class="am-btn am-btn-warning am-margin-left am-btn-xs">返回班级首页</a></div>
		<div class="am-panel-bd am-cf">
			<ul class="vedio-category-list">
				<?php if(is_array($xiangmu)): foreach($xiangmu as $key=>$v): ?><li><a href="<?php echo U(GROUP_NAME.'/Pingyou/pingyou',array('gzid'=>$v['id']));?>"><?php echo ($v['mingcheng']); ?></a></li><?php endforeach; endif; ?>
			</ul>
		</div>
	</div>
	<?php if($isxuanding == 1): ?><div class="am-panel am-panel-warning">
		<div class="am-panel-hd">
		<h3 class="am-panel-title">正在进行[<span class="am-text-primary"><?php echo ($dangqianguize['mingcheng']); ?></span>]评选。已经评选了<span class="am-text-primary" id='yijingpingxuan'><?php echo ($yipingshuliang); ?></span>人</h3>
		</div>
		<div class="am-panel-bd">
			<span class="am-text-primary">评优限定条件</span>
		</div>
		<ul class="am-list am-list-static">
			<?php if($dangqianguize['xuekefenshu'] != '0'): ?><li class="am-cf">
				<div class="am-text-left">
				<span  class='am-badge am-badge-primary am-fl  am-radius am-text-sm am-margin-right'>成绩最低要求</span>
					<?php $fenshu = json_decode($dangqianguize['xuekefenshu']); foreach($fenshu as $value){ $xuekeName = getXuekeName($value->xuekeid); echo "<span class='am-badge am-badge-warning am-fl  am-radius am-text-sm am-margin-right'>".$xuekeName.$value->chengjiyaoqiu."分</span>"; } ?>
				</div>
				</li><?php endif; ?>
			<?php if($dangqianguize['renshu'] != '0'): ?><li class="am-cf">
					<div>
						<span  class='am-badge am-badge-primary am-fl  am-radius am-text-sm am-margin-right'>人数限制</span>
						<span  class='am-badge am-badge-warning am-fl  am-radius am-text-sm am-margin-right'><?php echo ($dangqianguize['renshu']); ?></span>
					</div>
				</li><?php endif; ?>
			<?php if($dangqianguize['bili'] != '0'): ?><li class="am-cf">
					<div>
						<span  class='am-badge am-badge-primary am-fl  am-radius am-text-sm am-margin-right'>人数限制</span>
						<span  class='am-badge am-badge-warning am-fl  am-radius am-text-sm am-margin-right'>
						评选比例为<?php echo ($dangqianguize['bili']); ?>%，本班有学生<?php echo ($xueshengshu); ?>名，可以评选共计
						<?php echo ceil(($dangqianguize[bili]*$xueshengshu)/100); ?>
						名
						</span>
					</div>
				</li><?php endif; ?>
			<?php if($dangqianguize['jicheng'] != '0'): ?><li class="am-cf">
				<div>
					<span  class='am-badge am-badge-primary am-fl  am-radius am-text-sm am-margin-right'>必须从</span>
					<span  class='am-badge am-badge-warning am-fl  am-radius am-text-sm am-margin-right'>【<?php echo (getxiangmuname($dangqianguize['jicheng'])); ?>】结果中评选</span>
				</div>
				</li><?php endif; ?>
			<?php if($dangqianguize['paichu'] != '0'): ?><li class="am-cf">
				<div>
					<span  class='am-badge am-badge-primary am-fl  am-radius am-text-sm am-margin-right'>排除已经评选</span>
					<span  class='am-badge am-badge-warning am-fl  am-radius am-text-sm am-margin-right'>
					<?php
 $paichuidlist = explode(',',$dangqianguize['paichu']); foreach($paichuidlist as $paichuidlistValue){ $paichuidlistMessage = "【".getXiangmuName($paichuidlistValue).'】'; echo $paichuidlistMessage; } ?>
					</span>
				</div>
				</li><?php endif; ?>
		</ul>
		<div class="am-panel-footer"><span class="am-text-xs am-text-danger">(请注意限定条件)</span></div>
	</div><?php endif; ?>
	<table class="am-table am-table-bordered am-table-striped am-table-hover">
		<thead>
		<tr>
			<th colspan="6">学生成绩</th>
		</tr>
			<tr>
				<th style="width:5%;" class="am-text-center">学号</th>
				<th style="width:8%;" class="am-text-center">姓名</th>
				<th>成绩(蓝色表示成绩合格要求，红色表明未达到要求,绿色表示无成绩)</th>
				<th style="width:20%;">条件状况</th>
				<th style="width:13%;">子分类</th>
				<th style="width:10%;" class="am-text-center">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if(is_array($student)): foreach($student as $key=>$v): $arrtiaojian=''; $chengjibugou = false; ?>
				<tr>
				<td class="am-text-center"><?php echo ($v['xuehao']); ?></td>
					<td class="am-text-center"><span id="<?php echo ($v['id']); ?>" onclick="pophistory(this);"><?php echo ($v['name']); ?></span></td>
					<td>
						<?php
 $xueshengid = $v['id']; $termid = $term['id']; if($dangqianguize['xuekefenshu']!='0'){ $fenshuyaoqiu = json_decode($dangqianguize['xuekefenshu']); foreach($fenshuyaoqiu as $key=>$yaoqiuvalue){ $xuekeid = (int)$yaoqiuvalue->xuekeid; $fenshuyaoqiu = (int)$yaoqiuvalue->chengjiyaoqiu; $str = ''; $xuekechengji = M('chengji')->where(array('xueshengid'=>$xueshengid,'termid'=>$termid,'xuekeid'=>$xuekeid))->find(); if(empty($xuekechengji)){ $str = "<span  class='am-margin-vertical-xs am-badge am-badge-success am-fl  am-radius am-text-sm am-margin-right'>"; $str = $str.getXuekeName($xuekeid).'(无)'; $str = $str."</span>"; $chengjibugou = true; }else{ if($xuekechengji['fenshu']<$fenshuyaoqiu){ $str = "<span  class='am-margin-vertical-xs am-badge am-badge-danger am-fl  am-radius am-text-sm am-margin-right'>"; $str = $str.getXuekeName($xuekeid).'('.$xuekechengji['fenshu'].')'; $str = $str."</span>"; $chengjibugou = true; }else{ $str = "<span  class='am-margin-vertical-xs am-badge am-badge-primary am-fl  am-radius am-text-sm am-margin-right'>"; $str = $str.getXuekeName($xuekeid).'('.$xuekechengji['fenshu'].')'; $str = $str."</span>"; } } echo $str; } }else{ if(empty($v['chengji'])){ $str = "<span  class='am-margin-vertical-xs am-badge am-badge-primary am-fl  am-radius am-text-sm am-margin-right'>"; $str = $str.'没有成绩'; $str = $str."</span>"; echo $str; }else{ foreach($v['chengji'] as $value){ $str = "<span  class='am-margin-vertical-xs am-badge am-badge-primary am-fl  am-radius am-text-sm am-margin-right'>"; $str = $str.getXuekeName($value['xuekeid']).'('.$value['fenshu'].')'; $str = $str."</span>"; echo $str; } } } if($isxuanding==0){ if(empty($v['chengji'])){ $str = "<span  class='am-margin-vertical-xs am-badge am-badge-primary am-fl  am-radius am-text-sm am-margin-right'>"; $str = $str.'没有成绩'; $str = $str."</span>"; echo $str; }else{ foreach($v['chengji'] as $value){ $str = "<span  class='am-margin-vertical-xs am-badge am-badge-primary am-fl  am-radius am-text-sm am-margin-right'>"; $str = $str.getXuekeName($value['xuekeid']).'('.$value['fenshu'].')'; $str = $str."</span>"; echo $str; } } } ?>
					</td>
					<td>
						<!-- 成绩要求在显示成绩的时候已经要求 -->
						<?php
 if($chengjibugou==true){ $arrtiaojian[] = array( 'message'=>'成绩条件不够', 'bumanzu'=>true, ); } ?>
						<!-- 还有继承要求 -->
						<!-- 还有排除要求 -->
						<?php
 if($dangqianguize['jicheng']!=0){ $condition = array( 'termid'=>$termid, 'xueshengid'=>$xueshengid, 'sanhaoid'=>$dangqianguize['jicheng'], ); $jichengXiangmuName = getXiangmuName($dangqianguize['jicheng']); if(M('sanhaojieguo')->where($condition)->find()){ }else{ $arrtiaojian[] = array( 'message'=>'未参评'.$jichengXiangmuName, 'bumanzu'=>true, ); } } if($dangqianguize['paichu']!='0'){ $paichu = explode(',',$dangqianguize['paichu']); foreach($paichu as $paichuValue){ $condition = array( 'termid'=>$termid, 'xueshengid'=>$xueshengid, 'sanhaoid'=>$paichuValue, ); $paichuXiangmuName = getXiangmuName($paichuValue); if(M('sanhaojieguo')->where($condition)->find()){ $arrtiaojian[] = array( 'message'=>'已参评'.$paichuXiangmuName, 'bumanzu'=>true, ); }else{ } } } $tiaojianMessage = ''; $manzutiaojian = false; foreach($arrtiaojian as $tiaojianValue){ $tiaojianMessage = "<span class='am-badge am-badge-warning am-text-sm'>".$tiaojianValue['message']."</span>"; $manzutiaojian = $manzutiaojian||$tiaojianValue['bumanzu']; echo $tiaojianMessage.'<br>'; } ?>
					</td>
					<td>
					<?php
 $pingyouqingkuang = getXueshengStatus($v["id"],$term["id"],$dangqianguize["id"]); ?>
						<form action="" class="am-form">
							<div class="am-form-group">
								<select id="doc-select-1" class="am-margin-top-sm">
									<?php
 if($dangqianguize['zifenlei']!='0'){ echo "<option value='0'>请选子分类</option>"; $zifenlei = json_decode($dangqianguize['zifenlei']); foreach($zifenlei as $zifenleiKey=>$zifenleiValue){ $selected = ''; if($pingyouqingkuang['status']==1){ if($pingyouqingkuang['jieguo']['zifenleiid']==($zifenleiKey+1)){ $selected = "selected='selected'"; } } $zifenleistr = "<option ".$selected." value='".($zifenleiKey+1)."'>"; $zifenleistr = $zifenleistr.$zifenleiValue; $zifenleistr = $zifenleistr."</option>"; echo $zifenleistr; } }else{ echo "<option value='0'>无子分类</option>"; } ?>
								</select>
								<span class="am-form-caret"></span>
							</div>
						</form>
					</td>
					<td>
					 	<?php if($manzutiaojian != true): if($pingyouqingkuang["status"] == 0): ?><span attr="<?php echo ($v['id']); ?>,<?php echo ($dangqianguize['id']); ?>,<?php echo ($term['id']); ?>" class="am-margin-top am-btn am-btn-success am-btn-xs am-btn-block" biaoshi='0' onclick="pingxuan(this);">加入评选</span>
					 		<?php else: ?>
					 			<span attr="<?php echo ($v['id']); ?>,<?php echo ($dangqianguize['id']); ?>,<?php echo ($term['id']); ?>" class="am-margin-top am-btn am-btn-danger am-btn-xs am-btn-block" biaoshi='1' onclick="pingxuan(this);">取消评选</span><?php endif; endif; ?>
					</td>
				</tr><?php endforeach; endif; ?>
		</tbody>
	</table>
</div>
<script>
	// POP弹出学生历史评优内容
	function pophistory(obj){
		var studentId = $(obj).attr('id');

		$.ajax({
			type: 'POST',
			url: "<?php echo U(GROUP_NAME.'/Pingyou/ajaxPastResult');?>",
			data: {studentid:studentId},
			success: function(data){
				var pastResult = '';
				if(data==null){
					pastResult = '无评选记录';
				}else{
					$.each(data,function(index,value){
						if(pastResult==''){
							pastResult = value.xueqi+'：：'+value.jiangxiang;
						}else{
							pastResult = pastResult+'<br>'+value.xueqi+'：：'+value.jiangxiang;
						}
					});
				}
				
				$(obj).popover({
					content: pastResult,
					theme:'secondary',
				})
			},
			dataType: 'json'
		});
		
	}
	// 评选函数
	function pingxuan(element){
		var url = "<?php echo U(GROUP_NAME.'/Pingyou/pingyouHandle');?>";
		var pingxuanshuju = $(element).attr('attr');
		var biaoshi = $(element).attr('biaoshi');
		var xueshengshu = "<?php echo ($xueshengshu); ?>";
		var banji = "<?php echo ($banji['id']); ?>";

		var hasZifenlei = <?php echo ($hasZifenlei); ?>;
		//判定是否选定了评价项目
		var isxuanding = <?php echo ($isxuanding); ?>;
		if(isxuanding==0){
			alert('请先选定评优项目');
			return false;
		}
		//判定如果有子分类，是否选择了子分类
		var zifenlei = 0;
		if(hasZifenlei==1){
			if($(element).parents("tr").find("select").val()=='0'){
				alert('请选择子分类');
				return false;
			}else{
				zifenlei = $(element).parents("tr").find("select").val();
			}
		}
		$.ajax({
			type:'POST',
			url:url,
			data: {shuju:pingxuanshuju,biaoshi:biaoshi,xueshengshu:xueshengshu,banji:banji,zifenlei:zifenlei},
			success:function(data){
				if(data==0){
					alert('插入数据出错');
				}
				if(data==1){
					var biaoshi = $(element).attr('biaoshi');
					//表示是添加成功，修改状态
					$(element).attr('biaoshi',1);
					$(element).html('取消评优');
					$(element).removeClass("am-btn-success");
					$(element).addClass("am-btn-danger");
					//更改已经评选人数
					$now = parseInt($('#yijingpingxuan').html());

					$('#yijingpingxuan').html($now+1);
				}
				if(data==2){
					alert('人数超出限制');
				}
				if(data==3){
					//表示是取消成功，修改状态
					$(element).attr('biaoshi',0);
					$(element).html('加入评优');
					$(element).removeClass("am-btn-danger");
					$(element).addClass("am-btn-success");
					//更改已经评选人数
					$now = parseInt($('#yijingpingxuan').html());

					$('#yijingpingxuan').html($now-1);
				}
				
			},
			dataType:'json',
		});
	}
</script>
<footer>
	<p class="am-text-center"><?php echo (C("copyright")); ?></p>
</footer>
</body>
</html>