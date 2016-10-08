<?php
// 前台报名控制器
Class EnrollmentAction extends NormalAction{
	// 函数检测是否已经开启该任务 或者是否时间到了
	function _before_index(){
		$id = I('id',0,'intval');

		$enrollment = M('enrollment')->find($id);
		if(empty($enrollment)) $this->error('无相关报名任务');

		$now = time();
		if($now>$enrollment['end']||$now<$enrollment['start']){
			$this->error('报名时间未到或已经截止');
		}
	}
	// 根据报名任务ID，显示相应报名任务信息
	function index(){
		$id = I('id',0,'intval');
		$enrollment = D('EnrollmentRelation')->relation(true)->find($id);
		if(empty($enrollment)) $this->error('无相关报名任务');

		$banjiuid = $_SESSION['banjiuid'];
		$banji = D('BanjiRelation')->relation('student')->find($banjiuid);

		$nianji = M('nianji')->where(array('ruxuenian'=>$banji['ruxuenian']))->find();
		//根据年级筛选当前年级的报名项目
		foreach($enrollment['content'] as $key => $value){
			if(in_array($nianji['id'],json_decode($value['nianji']))){
				$content[] = $value;
			}
		}
		// 获取当前学期
		$termId = M('term')->where(array('status'=>1))->getField('id');
		// 获取本班学生
		$student = $banji['student'];
		$data = array(
			'enrollment'=>$enrollment,
			'content'=>$content,
			'student'=>$student,
			'banji'=>$banji,
			);
		// 是否已经选择报名项目
		$nowContentId = I('nid',0,'intval');
		if($nowContentId!=0){
			$nowContent = M('enrollment_content')->where(array('id'=>$nowContentId))->find();
			if(!$nowContent) $this->error('报名项目不存在');

			$data['nowContent'] = $nowContent;
			// 获取该班级已经报了当前项目的学生列表
			$enrollStudentIdList = M('enrollment_list')->where(array('bid'=>$banji['id'],'cid'=>$nowContent['id'],'tid'=>$termId))->getField('sid',true);
			//p($enrollStudentIdList);die;
			$enrollStudent = M('student')->where(array('id'=>array('IN',$enrollStudentIdList)))->select();

			$data['enrollStudent'] = $enrollStudent;
		}
		$this->assign($data);
		$this->display();
	}

	// AJAX处理报名添加信息
	function ajaxAdd(){

		$eid = I('eid',0,'intval');
		$cid = I('cid',0,'intval');
		$bid = I('bid',0,'intval');
		$sid = I('sid',0,'intval');
		/******** 此处是否应该检测获得数据的有效性？********/
		// 获得当前学期
		$term = M('term')->where(array('status'=>1))->find();
		// 学期ID
		$tid = $term['id'];

		$type = I('type',2,'intval');
		// 1表示添加 0表示删除
		if($type==1){
			// 先检测是否已经报名过该项目了
			$condition = array(
				'eid'=>$eid,
				'cid'=>$cid,
				'sid'=>$sid,
				'tid'=>$tid,
				);
			if(M('enrollment_list')->where($condition)->find()){
				$this->retJson(0,'已经报名该项目');
				return;
			}
			$enrollment = M('enrollment')->find($eid);
			if($enrollment==''){
				$this->retJson(0,'该报名任务不存在');
				return;
			}
			// 判定该学生是否超出了当前报名任务的兼报数
			$condition = array(
				'eid'=>$eid,
				'sid'=>$sid,
				'tid'=>$tid,
				);
			// 集体项目不限制人数
			$theXiangmu = M('enrollment_content')->find($cid);
			// p($theXiangmu);
			$count = M('enrollment_list')->where($condition)->count();
			if($count>=$enrollment['renshu']&&$theXiangmu['jiti']==0){
				$this->retJson(0,'该学生已经报了'.$enrollment['renshu'].'个项目');
				return;
			}
			
			// 检测当前报名项目是否存在
			$content = M('enrollment_content')->find($cid);
			if($content==''){
				$this->retJson(0,'该报名项目不存在');
				return;
			}
			// 判定该班级是否超出了当前项目的限报人数
			$condition = array(
				'cid'=>$cid,
				'bid'=>$bid,
				'tid'=>$tid,
				);
			$banjiCount = M('enrollment_list')->where($condition)->count();
			if($banjiCount>=$content['renshu']){
				$this->retJson(0,'超出项目人数限制');
				return;
			}
			/*******************/
			// 先根据学生性别与性别要求进行判定 是否符合报名要求
			$student = M('student')->where(array('id'=>$sid))->find();
			if($content['nannv']==1&&$student['xingbie']==0){
				$this->retJson(0,'女生不允许报名');
				return;
			}
			if($content['nannv']==0&&$student['xingbie']==1){
				$this->retJson(0,'男生不允许报名');
				return;
			}
			// 还要根据性别判定男生人数是否超出要求
			$condition = array(
				'cid'=>$cid,
				'bid'=>$bid,
				'tid'=>$tid,
				);
			// 选出该班级所有报名学生ID列表
			$studentIdList = M('enrollment_list')->where($condition)->getField('sid',true);
			// p($studentIdList);
			// 根据ID列表统计出男生数量
			$condition = array(
				'id'=>array('IN',$studentIdList),
				'xingbie'=>1,
				);
			$nanCount = M('student')->where($condition)->count();
			// 如果有性别要求 并且 该学生为男生 则检测男生已报数量是否超了
			if($nanCount>=$content['nansheng']&&$student['xingbie']==1&&$content['nannv']!=3)
			{
				$this->retJson(0,'男生超出人数限制');
				return;
			}
			// 女生人数是否超出要求
			$condition = array(
				'id'=>array('IN',$studentIdList),
				'xingbie'=>0,
				);
			$nanCount = M('student')->where($condition)->count();
			// 如果有性别要求 并且 该学生为女生 则检测女生已报数量是否超了
			if($nanCount>=$content['nvsheng']&&$student['xingbie']==0&&$content['nannv']!=3)
			{
				$this->retJson(0,'女生超出人数限制');
				return;
			}
			/*******************/
			// 插入数据
			$data = array(
				'eid'=>$eid,
				'cid'=>$cid,
				'bid'=>$bid,
				'sid'=>$sid,
				'tid'=>$tid,
				);
			if(M('enrollment_list')->add($data)){
				$this->retJson(1,'');
			}else{
				$this->retJson(0,'添加失败请重试');
			}
		}//插入if结束
		// 表示要删除报名
		if($type==0){
			$condition = array(
				'eid'=>$eid,
				'cid'=>$cid,
				'sid'=>$sid,
				'tid'=>$tid,
				);

			if(M('enrollment_list')->where($condition)->delete()){
				$this->retJson(1,'');
			}else{
				$this->retJson(0,'删除失败请重新尝试');
			}
		}

	}
	// 显示学生报名情况
	function bmlist(){
		$banjiuid = $_SESSION['banjiuid'];
		// 根据班级ID获取入学年，并获得当前年级ID
		$banji = M('banji')->find($banjiuid);
		$nianji = M('nianji')->where(array('ruxuenian'=>$banji['ruxuenian']))->find();
		// p($banjiuid);die;
		$eid = I('eid',0,'intval');

		$enrollment = D('EnrollmentRelation')->relation('content')->where(array('id'=>$eid))->find();
		// 获得当前学期ID
		$termId = M('term')->where(array('status'=>1))->getField('id');
		if($enrollment=='') $this->error('报名任务不存在');

		// 查看类型1表示按照项目进行排列 0表示按照学生进行排列
		$type = I('type',1,'intval');
		// 按照项目进行排列
		if($type==1){
			foreach($enrollment['content'] as $key => $value){
				// 判定当前年级是否有此报名项目
				if(in_array($nianji['id'],json_decode($value['nianji']))){
					$condition = array(
						'bid'=>$banjiuid,
						'cid'=>$value['id'],
						'tid'=>$termId,
						);
					$studentIdList = M('enrollment_list')->where($condition)->getField('sid',true);
					$enrollment['content'][$key]['student'] = M('student')->where(array('id'=>array('IN',$studentIdList)))->select();
				}else{
					// 如果年级ID不在此项目年级ID列表中 则移除
					unset($enrollment['content'][$key]);
				}
				
			}
			$data =  array(
					'type'=>1,
					'enrollment'=>$enrollment,
					);
		}
		// 按照学生进行排列
		if($type==0||$type==2){
			D('StudentRelation')->_link['enrollment']['condition'] ='tid='.$termId.' AND a.eid='.$eid;
			$student = D('StudentRelation')->where(array('bid'=>$banjiuid))->order('xuehao ASC')->relation('enrollment')->select();
			$data = array(
				'type'=>0,
				'student'=>$student,
				'enrollment'=>$enrollment,
				);

			if($type==2){
				$this->daochu($student);
			}
		}
		// p($data);die;
		$this->assign($data);

		$this->display();

	}
	    // 导出学生名单为EXCEL
    protected function daochu($student){

    	foreach($student as $key=>$value){

    		$temp = array(
    			'xuehao'=>$value['xuehao'],
    			'xingming'=>$value['name'],
    			'xingbie'=>($value['xingbie']==1)?'男':'女',
    			);
    		$xiangmu = array();
    		foreach($value['enrollment'] as $akey=>$avalue){
    			$xiangmu[] = $avalue['mingcheng'];
    		}
    		$temp['xiangmu'] = implode(',', $xiangmu);

    		$studetData[] = $temp;
    	}

        
        $header = array(
            '学号','姓名','性别','项目',
            );
        $filename = '学生运动会报名名单';

        getExcel($filename,$header,$studetData);

    }
	protected function retJson($status,$message){
		$data = array(
			'status'=>$status,
			'message'=>'<span class="am-text-danger">'.$message.'</span>',
			);
		echo json_encode($data);
	}
}