<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<title>报名表测试</title>
	<style>
		@font-face {
			font-family:"Times New Roman";
		}
		@font-face {
			font-family:"&#23435;&#20307;";
		}
		@font-face {
			font-family:"Arial";
		}
		table{border-collapse:collapse;border-color:#000;}
		td{ border-color:#000; padding:10px 5px; vertical-align:middle;}
		h1{ text-align:center}
		h3{ text-align:right;}
	</style>

</head>
<body>
	<table border="1" cellpadding="3" cellspacing="0" >
		<tr >
			<td width="900" valign="center" align="center" colspan="9" ><?php echo ($nianji); echo ($xingbie); echo ($xiangmu); ?></td>
		</tr>
		<tr >
			<td width="100" valign="center" colspan="1" >组\道</td>
			<td width="100" valign="center" colspan="1" >一</td>
			<td width="100" valign="center" colspan="1" >二</td>
			<td width="100" valign="center" colspan="1" >三</td>
			<td width="100" valign="center" colspan="1" >四</td>
			<td width="100" valign="center" colspan="1" >五</td>
			<td width="100" valign="center" colspan="1" >六</td>
			<td width="100" valign="center" colspan="1" >七</td>
			<td width="100" valign="center" colspan="1" >八</td>
		</tr>
		<?php if(is_array($student)): foreach($student as $key=>$v): ?><tr >
			<td width="100" valign="center" colspan="1" ><?php echo ++$key;?></td>
			<?php if(is_array($v)): foreach($v as $key=>$m): ?><td width="100" valign="center" colspan="1" ><?php echo ($m['xuehao']); ?><br><?php echo ($m['name']); ?></td><?php endforeach; endif; ?>
		</tr><?php endforeach; endif; ?>
	</table>
</body>
</html>