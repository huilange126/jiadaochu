<?php
// 德育管理控制器
// 奖惩管理
Class DeyuAction extends CommonAction{
	// 奖惩列表
	function index(){
		if(I('keywords')==''&&I('miaoshu')==''&&I('shijianStart')==''&&I('shijianEnd')==''&&I('leixing')==0){
			// 非搜索状态
			$count = M('jiangcheng')->where(array('status'=>0))->count();
			$page = getPageObject($count,10);
			$jiangcheng = D('JiangChengRelation')->where(array('status'=>0))->order('id DESC')->relation(true)->limit($page->firstRow,$page->listRows)->select();
			$data = array(
				'jiangcheng'=>$jiangcheng,
				'num'=>$page->firstRow,
				'show'=>$page->show(),
				);
		}else{
			// 搜索状态
			// p($_POST);die;

			$keywords = trim(I('keywords'));
			// 根据学生学号或姓名进行搜索的关键字
			if($keywords!=''){
				// 如果不为空，应先从student表中搜索出相应的学生id列表
				$condition = array(
					'xuehao'=>array('LIKE','%'.$keywords.'%'),
					'name'=>array('LIKE','%'.$keywords.'%'),
					'_logic'=>'OR',
					);

				$studentIdList = M('student')->where($condition)->getField('id',true);
				// 如有学生学号或姓名搜索
				$searchCondition['xuesheng_id'] = array('IN',$studentIdList);
			}
			// 根据描述进行搜索
			$miaoshu = trim(I('miaoshu'));
			if($miaoshu!=''){
				$searchCondition['miaoshu'] = array('LIKE','%'.$miaoshu.'%');
			}
			// 根据日期进行搜索
			// 开始日期
			$shijianStart = I('shijianStart');
			if($shijianStart!=''){
				$searchCondition['riqi'] = array('GT',strtotime($shijianStart));
			}
			// 截止日期
			$shijianEnd = I('shijianEnd');
			if($shijianEnd!=''){
				$searchCondition['riqi'] = array('LT',strtotime($shijianEnd));
			}
			// 奖惩信息类型搜索
			$leixing = I('leixing',0,'intval');
			// echo $leixing;die;
			if($leixing!=0){
				$searchCondition['leixing'] = $leixing;
			}
			// 条件关系为AND
			$searchCondition['_logic'] = 'AND';
			$searchCondition['status'] = 0;
			$jiangcheng = D('JiangChengRelation')->order('id DESC')->relation(true)->where($searchCondition)->select();
			// 遍历获取奖惩ID列表
			foreach($jiangcheng as $key=>$value){
				$jiangchengIdList[] = $value['id']; 
			}
			// 搜索结束id列表
			$sousuo = implode(',',$jiangchengIdList);


			$data = array(
				'jiangcheng'=>$jiangcheng,
				'jiangchengIdList'=>$sousuo,
				'num'=>0,
				);
		}
		
		$this->assign($data);
		$this->display();
	}
	// 奖惩添加学生搜索
	function searchStudent(){
		if(IS_POST&&I('keywords')!=''){
			// 搜索界面
			$keywords = I('keywords');

			$condition = array(
				'name'=>array('LIKE','%'.$keywords.'%'),
				'xuehao'=>array('LIKE','%'.$keywords.'%'),
				'_logic'=>'OR',
				);

			$student = M('student')->where($condition)->order('xuehao ASC')->select();

			$data = array(
				'student'=>$student,
				);
			$this->assign($data);
		}
		$this->display();
	}
	// 奖惩添加
	function add(){
		$studentId = I('student',0,'intval');

		$student = M('student')->find($studentId);

		$data = array(
			'student'=>$student,
			);
		$this->assign($data);
		$this->display();
	}
	// 奖惩编辑
	function edit(){
		$id =  I('id',0,'intval');

		$jiangcheng = D('JiangChengRelation')->relation(true)->find($id);

		if($jiangcheng=='') $this->error('奖惩信息不存在');
		// 替换图片信息
		$jiangcheng['miaoshu'] = str_replace('/Uploads',__ROOT__.'/Uploads',$jiangcheng['miaoshu']);
		$data = array(
			'id'=>$id,
			'jiangcheng'=>$jiangcheng,
			'student'=>$jiangcheng['student'],
			);
		$this->assign($data);
		$this->display();
	}
	function addHandle(){
		$studentId = I('student',0,'intval');
		$riqi = strtotime(I('shijian'));
		$leixing = I('leixing',0,'intval');
		// 替换图片信息地址
		$content = str_replace(__ROOT__,'',$_POST['content']);
		// 描述信息非空检测
		if($content=='') $this->error('请添加描述信息');
		$data = array(
			'xuesheng_id'=>$studentId,
			'riqi'=>$riqi,
			'leixing'=>$leixing,
			'miaoshu'=>$content,
			'status'=>0,//表示正常状态为0 删除状态为1
			);
		$id = I('id',0,'intval');
		if($id==0){
			// 表示新增操作
			if(M('jiangcheng')->add($data)){
				$this->success('奖惩信息添加成功',U(GROUP_NAME.'/Deyu/index'));
			}else{
				$this->error('奖惩信息添加失败，请重试！');
			}
		}else{
			// 表示更新操作
			$data['id'] = $id;
			if(M('jiangcheng')->save($data)){
				$this->success('奖惩信息更新成功',U(GROUP_NAME.'/Deyu/edit',array('id'=>$id)));
			}else{
				$this->error('奖惩信息更新失败，请重试！');
			}
		}
		
		
	}
	// 奖惩删除
	function del(){
		$id = I('id',0,'intval');

		if(!M('jiangcheng')->find($id)) $this->error('奖惩信息不存在');

		if(M('jiangcheng')->where(array('id'=>$id))->setField('status',1)){
			$this->success('删除成功',U(GROUP_NAME.'/Deyu/index'));
		}else{
			$this->error('删除失败，请重试！');
		}
	}
	// 单个学生奖惩信息汇总表格
	function detail(){
		$xuesheng_id = I('id',0,'intval');

		$student = D('StudentRelation')->relation('jiangcheng')->find($xuesheng_id);

		$data = array(
			'student'=>$student,
			);
		// p($data);die;
		$this->assign($data);
		$this->display();
	}
	// 上传图片
	function upload(){

		import('ORG.Net.UploadFile');
		$upload = new UploadFile();// 实例化上传类
		$upload->maxSize  = 3145728 ;// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->savePath =  './Uploads/';// 设置附件上传目录
		$upload->autoSub = true;
		$upload->subType = 'date';
		$upload->dateFormat = 'Ym';
		if($upload->upload()) {// 上传错误提示错误信息
			$info = $upload->getUploadFileInfo();
			// p($info);
			$data = array(
				'error'=>0,
				'url'=>__ROOT__.'/Uploads/'.$info[0]['savename'],
				);
		}else{// 上传成功 获取上传文件信息
			$data = array(
				'error'=>1,
				'message'=>$upload->getErrorMsg(),
				);
		}

		echo json_encode($data);
	}

	function daochuExcel(){
		$idlist = I('search');

		$search = explode(',',$idlist);

		$jiangcheng = D('JiangChengRelation')->relation(true)->where(array('id'=>array('IN',$search)))->select();

		foreach($jiangcheng as $key=>$value){
			$student[] = array(
				'xuehao'=>$value['student']['xuehao'],
				'name'=>$value['student']['name'],
				'riqi'=>date('Y-m-d',$value['riqi']),
				'leixing'=>$this->getLeixing($value['leixing']),
				'miaoshu'=>$value['miaoshu'],
				);
		}
		$headArr = array('学号','姓名','日期','类型','描述');
		$fileName = '搜索结束';
		getExcel($fileName,$headArr,$student);
	}

	protected function getLeixing($leixing){
		switch ($leixing) {
			case 1:
				$str = '奖励';
				break;
			case 2:
				$str = '惩罚';
				break;
			case 3:
				$str = '其他';
				break;
		}

		return $str;
	}
}
?>