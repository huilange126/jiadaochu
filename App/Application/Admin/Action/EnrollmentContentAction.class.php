<?php
//报名任务具体内容控制器
Class EnrollMentContentAction extends CommonAction{
	//为报名任务添加子项
	//此处应该限制男女、班级人数、男女比例
	//报名任务也应该区分年级
	function add(){
		$id = I('id',0,'intval');
		if(!$enrollment=D('EnrollmentRelation')->relation(true)->find($id)) $this->error('报名任务不存在');
		$data = array(
			'enrollment'=>$enrollment,
			);
		$this->assign($data);

		$this->display();


	}
	//添加子项处理
	function addHandle(){
		//项目名称为空检测
		$mingcheng = I('mingcheng','','htmlspecialchars');
		if($mingcheng=='') $this->error('名称不能为空');
		//任务ID
		$eid = I('eid');
		//适应年级检测
		$nianji = I('chkNianji');
		if($nianji=='') $this->error('年级不能为空');
		// 0表示女生项目 1表示男生项目 2表示男女均报（有各自人数限制） 3表示无性别要求 
		$nannv = I('nannv');
		//检测人数是否为空
		$renshu = I('renshu',0,'intval');
		if($renshu<=0) $this->error('人数不能为0');
		//检测男生数是否为空
		$nansheng = I('nansheng',0,'intval');
		if($nansheng<0) $this->error('男生数不能小于0');
		// 检测女生数是否为空
		$nvsheng = I('nvsheng',0,'intval');
		if($nvsheng<0) $this->error('女生数不能小于0');
		// 检测男生和女生和与总数是否正确

		if(($nansheng+$nvsheng)!=$renshu&&$nannv!=3) $this->error('人数设定不正确，请检查');
		// 状态信息
		$status = I('status',0,'intval');
		//项目类型
		$leixing = I('leixing',0,'intval');
		// 集体项目 0表示个人 1表示集体
		$jiti = I('jiti',0,'intval');
		$data = array(
			'mingcheng'=>$mingcheng,
			'eid'=>$eid,
			'nianji'=>json_encode($nianji),
			'renshu'=>$renshu,
			'nannv'=>$nannv,
			'nansheng'=>$nansheng,
			'nvsheng'=>$nvsheng,
			'status'=>$status,
			'leixing'=>$leixing,
			'jiti'=>$jiti,
			);
		$id=I('id',0,'intval');
		if($id!=0){
			$data['id'] = $id;

			if(M('enrollment_content')->save($data)){
				$this->success('更新成功',U(GROUP_NAME.'/Enrollment/detail',array('id'=>$eid)));
				// 返回具体项目更新页面
				// $this->success('更新成功',U(GROUP_NAME.'/EnrollmentContent/edit',array('id'=>$id)));
			}else{
				$this->error('更新失败，请重新尝试');
			}
		}else{
			if(M('enrollment_content')->add($data)){
				$this->success('添加成功',U(GROUP_NAME.'/EnrollmentContent/add',array('id'=>$eid)));
			}else{
				$this->error('添加失败');
			}
		}
	}
	//编辑子项
	function edit(){

		$id = I('id',0,'intval');
		if($id<=0) $this->error('ID不存在');

		$content = M('enrollment_content')->find($id);
		if(!$content) $this->error('项目不存在');

		$content['nianji'] = json_decode($content['nianji']);

		//p($content);die;

		$enrollment = D('EnrollmentRelation')->relation('nianji')->find($content['eid']);
		//p($enrollment);die;
		$data = array(
			'content'=>$content,
			'enrollment'=>$enrollment,
			);

		$this->assign($data);

		$this->display();
	}
	//删除报名子项
	function del(){
		echo 'del ';
	}
	// 新建合并项目分组
	function addHebing(){
		$id = I('id',0,'intval');
		$enrollment = M('enrollment')->find($id);

		$data = array(
			'enrollment'=>$enrollment,
			);

		$this->assign($data);
		$this->display();
	}
	// 编辑合并项目分组
	function editHebing(){
		$id = I('id',0,'intval');
		$hebing = D('EnrollmentHebing')->relation('enrollment')->find($id);

		$data = array(
			'hebing'=>$hebing,
			);

		$this->assign($data);
		$this->display();
	}
	// 处理合并项目分组
	function hebingHandle(){
		$eid = I('eid',0,'intval');
		$mingcheng = I('mingcheng','','htmlspecialchars');

		$data = array(
			'eid'=>$eid,
			'mingcheng'=>$mingcheng,
			);
		// 读取合并分组ID
		$id = I('id',0,'intval');
		if($id==0){
			// 表示新增处理
			if(M('enrollment_hebing')->add($data)){
				$this->success('添加合并分组成功',U(GROUP_NAME.'/EnrollmentContent/addHebing',array('id'=>$eid)));
			}else{
				$this->error('添加合并分组失败，请重新尝试');
			}
		}else{
			// 表示更新处理
			$data['id'] = $id;
			if(M('enrollment_hebing')->save($data)){
				$this->success('合并分组更新成功',U(GROUP_NAME.'/Enrollment/detail',array('id'=>$eid)));
			}else{
				$this->error('更新失败，请重新尝试');
			}
		}
		
	}
	// 删除合并项目分组
	function delHebing(){
		$id = I('id',0,'intval');

		$hebing = D('EnrollmentHebing')->relation(true)->find($id);

		$status = true;

		$model = M();

		$model->startTrans();

		if(!M('enrollment_hebing')->delete($id)){
			$status = false;
		}
		// 清空所属项目的fenzu字段
		if($hebing['content']!=''){
			foreach($hebing['content'] as $key=>$value){
				$contentIdList[] = $value['id']; 
			}

			if(!M('enrollment_content')->where(array('id'=>array('IN',$contentIdList)))->setField('fenzu',0)){
				$status = false;
			}
		}

		if($status){
			$model->commit();
			$this->success('合并分组删除成功',U(GROUP_NAME.'/Enrollment/detail',array('id'=>$hebing['enrollment']['id'])));
		}else{
			$model->rollback();
			$this->error('删除失败，请重新尝试！');
		}
	}

	function ajaxAdd(){
		$contentId = I('contentid',0,'intval');
		$fenzuId = I('fenzuid',0,'intval');

		$data = array(
			'id'=>$contentId,
			'fenzu'=>$fenzuId,
			);
		// p($data);

		if(M('enrollment_content')->save($data)){
			$data = array(
				'status'=>1,
				'message'=>'设定成功',
				);
		}else{
			$data = array(
				'status'=>0,
				'message'=>'设定失败',
				);
		}
		echo json_encode($data);
	}
}
