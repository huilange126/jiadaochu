<?php
// 以班级为单位成绩发布控制器
Class ChengjiAction extends NormalAction{
	// 检测是否操作本班级考试
	protected function myclass(){
		$id = I('id',0,'intval');
		$kaoshi = M('kaoshi')->where(array('status'=>1))->find($id);
		if(empty($kaoshi)) $this->error('考试不存在');

		if(session('banjiuid')!=$kaoshi['banji']) $this->error('不能操作别的班级');
	}
	// 考试列表
	function index(){

		// 获得当前班级id
		$banjiId = $_SESSION['banjiuid'];

		$condition = array(
			'status'=>1,
			'banji'=>$banjiId,
			);
		// 分页
		$count = M('kaoshi')->where($condition)->count();
		$page = getPageObject($count,10);

		$kaoshi = D('KaoshiRelation')->relation(true)->order('id DESC')->where($condition)->limit($page->firstRow,$page->listRows)->select();
		
		$data = array(
			'kaoshi'=>$kaoshi,
			'show'=>$page->show(),
			'num'=>$page->firstRow,
			);
		$this->assign($data);
		$this->display();
	}

	// 添加考试
	function addKaoshi(){
		// 取得学科
		$xueke = M('xueke')->select();

		$data = array(
			'xueke'=>$xueke,
			);

		$this->assign($data);
		$this->display();
	}
	// 修改考试
	function modifyKaoshi(){
		// 检测是否本班级
		$this->myclass();

		$kaoshiId = I('id',0,'intval');

		$kaoshi = M('kaoshi')->find($kaoshiId);

		if(empty($kaoshi)) $this->error('考试不存在');

		// 学科
		$xueke = M('xueke')->select();

		$data = array(
			'kaoshi'=>$kaoshi,
			'xueke'=>$xueke,
			);

		$this->assign($data);

		$this->display();
	}
	// 处理添加修改考试
	function addHandle(){
		$xueke = I('xueke');
		if($xueke==0) $this->error('请选择学科');
		// 检测考试名称是否设置
		$mingcheng = I('mingcheng');
		if($mingcheng=='') $this->error('请添加考试名称');
		// 检测考试时间是否设置
		$shijian = I('shijian');
		if($shijian=='') $this->error('请选择考试时间');
		// 检测考试满分是否设置
		$manfen = I('manfen',0,'intval');
		if($manfen==0) $this->error('请设置满分值');
		// 班级
		$banjiuid = $_SESSION['banjiuid'];
		// 学期
		$term = M('term')->where(array('status'=>1))->find();

		

		$kaoshiId = I('kaoshiId',0,'intval');
		if($kaoshiId==0){
			// 表示新增
			$data = array(
			'xueke'=>$xueke,
			'mingcheng'=>$mingcheng,
			'shijian'=>strtotime($shijian),
			'status'=>1,
			'banji'=>$banjiuid,
			'xueqi'=>$term['id'],
			'manfen'=>$manfen,
			);
			if(M('kaoshi')->add($data)){
				$this->success('添加考试成功',U(GROUP_NAME.'/Chengji/index'));
			}else{
				$this->error(M('kaoshi')->getDbError());
			}
		}else{
			// 表示修改
			$data = array(
			'id'=>$kaoshiId,
			'xueke'=>$xueke,
			'mingcheng'=>$mingcheng,
			'shijian'=>strtotime($shijian),
			'manfen'=>$manfen,
			);

			if(M('kaoshi')->save($data)){
				$this->success('考试修改成功',U(GROUP_NAME.'/Chengji/modifyKaoshi',array('id'=>$kaoshiId)));
			}else{
				$this->error('考试修改失败，请重试！');
			}
		}
		
	}
	// 删除考试
	function del(){
		// 检测是否本班级
		$this->myclass();
		$id = I('id',0,'intval');

		if(M('kaoshi')->where('id='.$id)->setField('status',0)){
			$this->success('考试删除成功',U(GROUP_NAME.'/Chengji/index'));
		}else{
			$this->error('删除失败，请重试！');
		}
	}
	// 带入成绩页面
	function daoru(){
		// 检测是否本班级
		$this->myclass();

		$kaoshiId = I('id',0,'intval');

		$kaoshi = D('KaoshiRelation')->relation(true)->find($kaoshiId);
		if(empty($kaoshi)) $this->error('考试不存在');
		$data = array(
			'kaoshi'=>$kaoshi
			); 

		$this->assign($data);
		$this->display();
	}
	// 成绩导入处理
	function daoruHandle(){

		$file = $this->uploads();

		$data = excel_to_mysql($file,3);

		if($data['error']==1){
			$this->error('未知版本的EXCEL文件');
		}
		$chengji = $data['data'];
		// 检测是否是该班级的成绩
		foreach($chengji as $key=>$value){
			$banji[] = substr($value['xuehao'], C('BANJISTART')-1,C('BANJILENGTH'));

		}
		// p($banji);die;
		if(count(array_unique($banji))!=1){
			$this->error('存在不同一个班级的学生！请检查学生！');
		}
		// 取得考试
		$kaoshiId = I('kaoshiId');
		$kaoshi = M('kaoshi')->find($kaoshiId);
		if(empty($kaoshi)) $this->error('考试不存在');	
		// 取一个学生，获得班级id
		$student = M('student')->where(array('xuehao'=>$chengji[0]['xuehao']))->find();
		// 检测是否是该班级成绩
		if($student['bid']!=$kaoshi['banji']) $this->error('该成绩不是这个班级的，请检查!');
		// 检测成绩是否超出满分值
		foreach($chengji as $key=>$value){
			if($value['fenshu']>$kaoshi['manfen']||$value['fenshu']<0) $this->error('有分数大于满分值或小于0，请检查');
		}
		// 检测成绩列表中是否存在 学生表中没有的学号
		// 取得该班级所有学生
		$allStudent = M('student')->where(array('bid'=>$kaoshi['banji']))->select();
		foreach($allStudent as $key=>$value){
			$allXuehao[] = $value['xuehao']; 
			// 学号和ID对应数组，用于更新成绩
			$studentIdList[$value['id']] = $value['xuehao'];
		}
		$wuXuehao = array();
		foreach($chengji as $key=>$value){
			if(!in_array($value['xuehao'], $allXuehao)){
				$wuXuehao[] = $value; 
			}
		}
		// 如果有不存在学号，则提示
		if(!empty($wuXuehao)){
			$data = array(
				'student'=>$wuXuehao,
				'id'=>$kaoshi['id'],
				);
			$this->assign($data);
			$this->display('wuxuehao');
		}else{
			// 更新数据
			
			foreach($chengji as $key=>$value){

				$studentChengji[] = array(
					'kaoshiid'=>$kaoshi['id'],
					'xueshengid'=>array_search($value['xuehao'],$studentIdList),
					'fenshu'=>$value['fenshu'],
					'status'=>1,
					);
			}
			$kaoshichengji = M('kaoshichengji');
			// 开启事务
			$kaoshichengji->startTrans();

			if($kaoshichengji->addAll($studentChengji)){
				$kaoshichengji->commit();
				$this->success('成绩添加成功',U(GROUP_NAME.'/Chengji/detail',array('id'=>$kaoshi['id'])));
			}else{
				$kaoshichengji->rollback();
				$this->error('成绩添加失败，请重试！');
			}

		}
	}
	// 添加单个学生成绩
	function dangechengji(){
		// 检测是否操作本班级
		$this->myclass();

		$banjiUid = session('banjiuid');
		$kaoshiId = I('id',0,'intval');

		$condition = array(
			'kaoshiid'=>$kaoshiId,
			'status'=>1,
			);
		// 排除已有成绩学生
		$hasStudentIdList = M('kaoshichengji')->where($condition)->getField('xueshengid',true);
		if(empty($hasStudentIdList)){
			$condition = array(
			'bid'=>$banjiUid,
			);
		}else{
			$condition = array(
			'bid'=>$banjiUid,
			'id'=>array('NOT IN',$hasStudentIdList),
			);
		}
		
		$student = M('student')->where($condition)->select();

		$kaoshi = D('KaoshiRelation')->relation(true)->find($kaoshiId);

		$data = array(
			'student'=>$student,
			'kaoshi'=>$kaoshi,
			);

		$this->assign($data);

		$this->display();
	}
	// 添加单个成绩处理
	function dangechengjiHandle(){
		// p($_POST);die;
		$kaoshi = I('kaoshi',0,'intval');

		$student = I('student',0,'intval');
		if($student==0) $this->error('请选择学生');

		if(!is_numeric(I('fenshu'))) $this->error('请填入数字');
		$fenshu = I('fenshu',0,'floatval');

		$data = array(
			'kaoshiid'=>$kaoshi,
			'xueshengid'=>$student,
			'fenshu'=>$fenshu,
			'status'=>1,
			);
		// p($data);die;
		if(M('kaoshichengji')->add($data)){
			$this->success('成绩添加成功',U(GROUP_NAME.'/Chengji/detail',array('id'=>$kaoshi)));
		}else{
			$this->error('成绩添加失败，请重试！');
		}
		// echo $fenshu;
	}

	// 成绩显示列表
	function detail(){
		// 检测是否本班级
		$this->myclass();
		$id = I('id',0,'intval');
		// 考试信息
		$kaoshi = M('kaoshi')->find($id);
		if(empty($kaoshi)) $this->error('考试项目不存在');

		$condition = array(
			'kaoshiid'=>$id,
			'status'=>1,
			);
		// 获取该考试成绩信息
		$kaoshichengji = D('KaoshiChengjiRelation')->relation(true)->order('xueshengid ASC')->where($condition)->select();
		$data = array(
			'kaoshi'=>$kaoshi,
			'kaoshichengji'=>$kaoshichengji,
			);

		$this->assign($data);

		$this->display();
	}
	// 上传文件
	function uploads(){
		import('ORG.Net.UploadFile');
        
        $upload = new UploadFile();
        $upload->maxSize = 3145728;
        $upload->allowExts = array('xls','xlsx');
        $upload->savePath = './Uploads/';
        $upload->autoSub = true;
        $upload->subType = 'date';
        $upload->dateFormat = 'Ym';
        
        if(!$upload->upload()){
            $this->error($upload->getErrorMsg());
            
        }else{
            $info = $upload->getUploadFileInfo();
        }
        
        return $file = $info[0]['savepath'].$info[0]['savename'];

	}
}
	
?>