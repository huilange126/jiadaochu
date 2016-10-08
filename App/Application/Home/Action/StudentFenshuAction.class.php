<?php
// 学生分数控制器
// 用于学生成绩显示，分析，修改，删除等操作
Class StudentFenshuAction extends NormalAction{
	// 检测是否本班级学生
	function myStudentCheck(){
		$studentId = I('student',0,'intval');

		$student = M('student')->find($studentId);

		if(empty($student)) $this->error('学生不存在');

		if($student['bid']!=session('banjiuid')) $this->error('只能操作本班学生');
	}
	// 查看学生所有成绩
	function chengji(){
		// 这个成绩应该包含两个部分
		// 一个是班级自己添加的
		// 一个是校级添加的期末考试
		echo 123;
	}
	// 学生某次考试的成绩信息
	// 只能修改班级添加成绩
	// 加检测 只能修改本班学生成绩~~~包括查看
	function modifyChengji(){
		// 检查是否本班级学生
		$this->myStudentCheck();
		// 读取参数
		$kaoshi = I('kaoshi',0,'intval');
		$student = I('student',0,'intval');
		// 条件
		$condition = array(
			'kaoshiid'=>$kaoshi,
			'xueshengid'=>$student,
			);
		// 读取学生考试成绩
		$chengji = M('kaoshichengji')->where($condition)->find();
		// 读取学生
		$student = M('student')->find($student);
		// 读取考试
		$kaoshi = D('KaoshiRelation')->relation(true)->find($kaoshi);
		// p($chengji);die;
		if(empty($chengji)) $this->error('该生本次考试成绩不存在');

		$data = array(
			'kaoshi'=>$kaoshi,
			'student'=>$student,
			'chengji'=>$chengji
			);
		$this->assign($data);
		$this->display();
	}
	// 修改处理
	function modifyHandle(){

		$chengjiId = I('chengji',0,'intval');

		$fenshu = I('fenshu',0,'floatval');

		$student = I('student',0,'intval');

		$kaoshi = I('kaoshi',0,'intval');

		if(M('kaoshichengji')->where(array('id'=>$chengjiId))->setField('fenshu',$fenshu)){
			$this->success('修改成功',U(GROUP_NAME.'/StudentFenshu/modifyChengji',array('student'=>$student,'kaoshi'=>$kaoshi)));
		}else{
			$this->error('修改失败，请重试！');
		}
	}

		// 删除单个成绩
	function delchengji(){
		// 检测是否本班级
		$this->myStudentCheck();

		// 读取参数
		$kaoshi = I('kaoshi',0,'intval');
		$student = I('student',0,'intval');

		$condition = array(
			'kaoshiid'=>$kaoshi,
			'xueshengid'=>$student,
			);

		if(M('kaoshichengji')->where($condition)->setField('status',0)){
			$this->success('成绩删除成功',U(GROUP_NAME.'/Chengji/detail',array('id'=>$kaoshi)));
		}else{
			$this->error('删除失败，请重试！');
		}
		
	}

	// 学生成绩列表
	function fenshuList(){
		$studentId = I('student',0,'intval');

		$student = M('student')->find($studentId);
		$condition = array(
			'xueshengid'=>$studentId,
			'status'=>1,
			);
		// 分页
		$count = M('kaoshichengji')->where($condition)->count();
		$page = getPageObject($count,10);

		$kaoshi = D('KaoshiChengjiRelation')->relation(true)->limit($page->firstRow,$page->listRows)->where($condition)->order('kaoshiid DESC')->select();

		$xueke = M('xueke')->select();
		// 组合学科
		foreach($xueke as $key=>$value){
			$xuekeTemp[$value['xueke']] = $value['id'];
		}

		foreach($kaoshi as $key=>$value){
			$xuekeName = array_search($value['kaoshi']['xueke'],$xuekeTemp);
			$kaoshiTemp[] = array(
				'xueke'=>$xuekeName,
				'kaoshi'=>$value['kaoshi']['id'],
				'mingcheng'=>$value['kaoshi']['mingcheng'],
				'shijian'=>$value['kaoshi']['shijian'],
				'fenshu'=>$value['fenshu'],
				'xueqi'=>$value['kaoshi']['xueqi'],
				'mingci'=>$this->paixu($value['fenshu'],$value['kaoshi']['id']),
				);
		}
		

		$data = array(
			'student'=>$student,
			'kaoshi'=>$kaoshiTemp,
			'num'=>$page->firstRow,
			'show'=>$page->show(),
			);
		// p($data);die;
		$this->assign($data);

		$this->display();
	}
	// 根据成绩获得在本次考试中的名次
	protected function paixu($fenshu,$kaoshi){
		$kaoshiFenshu = array();
		$kaoshiFenshu = M('kaoshichengji')->where(array('kaoshiid'=>$kaoshi))->getField('fenshu',true);

		rsort($kaoshiFenshu);
		// p($kaoshiFenshu);die;
		return array_search($fenshu, $kaoshiFenshu)+1;
	}
}

