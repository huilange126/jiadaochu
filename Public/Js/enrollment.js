	$(function(){

		// 报名按钮点击时候操作
		$('#btnadd').click(function(){
			if(!ischoose(content)){
				return false;
			}
			var selStudent = bianli($('select[name=student]'));
			if(selStudent==''){
				showMessage('请选择学生');
			}
			var allMessage = '';
			var retMessage;
			// 循环遍历select中的option
			$.each(selStudent, function(index, val) {
				 retMessage = ajaxAdd(val,1);
				 if(retMessage!=''){
				 	if(allMessage==''){
				 		allMessage = retMessage;
				 	}else{
				 		allMessage = allMessage+'<br>'+retMessage;
				 	}
				 }
				 
			});
			if(allMessage!=''){
				showMessage(allMessage);
			}
			
		});
		$('#btnremove').click(function(){
			if(!ischoose(content)){
				return false;
			}
			var selStudent = bianli($('select[name=addlist]'));
			if(selStudent==''){
				showMessage('请选择学生');
			}
			var allMessage = '';
			var retMessage;
			// 循环遍历select中的option
			$.each(selStudent, function(index, val) {
				 retMessage = ajaxAdd(val,0);
				 if(retMessage!=''){
				 	if(allMessage==''){
				 		allMessage = retMessage;
				 	}else{
				 		allMessage = allMessage+'<br>'+retMessage;
				 	}
				 }
				 
			});
			if(allMessage!=''){
				showMessage(allMessage);
			}
			
		});
		//双击列表时候添加操作,只能对一个option进行操作
		$('select[name=student]').dblclick(function(event) {
			if(!ischoose(content)){
				return false;
			}
			var option = $(this).find('option:checked');
			var retMessage;
			retMessage = ajaxAdd(option,1);
			if(retMessage!=''){
				showMessage(retMessage);
			}
		});
		// 双击列表取消操作
		$('select[name=addlist]').dblclick(function(event) {
			if(!ischoose(content)){
				return false;
			}
			var option = $(this).find('option:checked');
			var retMessage;
			retMessage = ajaxAdd(option,0);
			if(retMessage!=''){
				showMessage(retMessage);
			}
		});
	});
	// 检测是否已经选择项目
	function ischoose(enrollment){

		if(enrollment==''){
			showMessage('请选择报名项目');
			return false;
		}
		return true;
	}
	// 提示框
	function showMessage(message){
		$('.am-modal-bd').html(message);
		$('#my-alert').modal();
	}
	// 遍历select对象中选中的option对象，返回option对象数组
	function bianli(selobj){
		var option = selobj.find('option');
		var selectStudent = new Array();
		$.each(option, function(index, val) {
			 if($(val).is(':checked')){
			 	selectStudent.push(val);
			 }
		});
		return selectStudent;
	}
	// AJAX添加学生至报名数据库
	// option为select的option对象
	// type为1表示添加，0表示移除
	function ajaxAdd(option,mtype){
		
		var sid = $(option).val();
		// var myoption = option;
		var message;
		$.ajax({
			type: 'POST',
			url: url,
			async:false,
			data: {eid:enrollment,cid:content,bid:banji,sid:sid,type:mtype},
			success: function(data){
				if(mtype==1){
					//如果成功添加，则将该option添加至右侧
					if(data.status==1){
						// 复制一个option至右侧，左侧保持不变
						$('select[name=addlist]').append($(option).clone());
						message='';
					}else{
						message = '['+$(option).html()+']报名不成功，原因：'+data.message;
					}
				}
				if(mtype==0){
					// 表示删除成功了，应该将该option添加至左侧
					if(data.status==1){
						// 从右侧删除当前option
						$(option).remove();
						message='';
					}else{
						message = data.message;
					}
				}
				
			},
			dataType: 'json',
		});
		return message;
	}