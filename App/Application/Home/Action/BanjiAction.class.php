<?php
Class BanjiAction extends Action{
	//登陆界面
	function index(){
		// $system = M('system')->find();
		$term = M('term')->where(array('status'=>1))->find();
		$data = array(
			// 'system'=>$system,
			'term'=>$term,
			);
		$this->assign($data);
		$this->display();
	}
	//登陆处理
	function loginHandle(){
		if(!IS_POST) $this->error('页面不存在');
		$shenfenzheng = I('shenfenzheng');
		$xingming = I('xingming');

		if(empty($shenfenzheng)||empty($xingming)) $this->error('身份证和姓名不能为空');

		$condition = array(
			'cid'=>$shenfenzheng,
			'name'=>$xingming,
			);
		$teacher=M('teacher')->where($condition)->find();
		if($teacher==''){
			$this->error('身份证或姓名错误');
		}else{
			session('uid',$teacher['id']);
			$this->success('登陆成功',U(GROUP_NAME.'/Banji/pingjia'));
		}
	}
	//老师评价班级界面
	function pingjia(){
		$this->islogin();
		$tid = session('uid');
		$term = M('term')->where(array('status'=>1))->find();
		$status = false;
		D('TeacherRelation')->_link['banji']['condition'] = 'termid='.$term['id'];

		$teacher = D('TeacherRelation')->relation(true)->find($tid);

		$pingjia = M('youxiubanji')->where(array('tid'=>$tid,'termid'=>$term['id']))->count();
		//表示已经评价过了
		if($pingjia!=0){
			foreach($teacher['banji'] as $key=>$value){
				$jieguo = M('youxiubanji')->where(array('tid'=>$tid,'termid'=>$term['id'],'bid'=>$value['id']))->getField('defen');
				$teacher['banji'][$key]['defen']=$jieguo;
			}
			$status = true;
		}
		//p($teacher);die;
		// $system = M('system')->find();
		$data = array(
			'term'=>$term,
			'teacher'=>$teacher,
			// 'system'=>$system,
			'banjicount'=>count($teacher['banji']),
			'status'=>$status,
			'mingcheng'=>C('MINGCHENG'),
			'fenzhi'=>C('FENZHI'),
			'appname'=>'优秀班集体评价',
			//'pingjia'=>$pingjia,
			);

		$this->assign($data);

		$this->display();
		
	}
	//评价处理
	function pingjiaHandle(){
		$this->islogin();
		if(!IS_POST) $this->error('页面不存在');
		$banjicount = $_POST['banjicount'];
		$pingjia = $_POST['pingjia'];
		$term = $_POST['term'];
		$teacher = $_POST['teacher'];

		if($banjicount!=count($pingjia)){
			$this->error('还有班级没有评价');
		}
		//更新之前先删除所有数据
		$condition = array(
			'tid'=>$teacher,
			'termid'=>$term,
			);
		M('youxiubanji')->where($condition)->delete();
		foreach($pingjia as $key=>$value){
			$data[] = array(
				'tid'=>$teacher,
				'bid'=>$key,
				'termid'=>$term,
				'defen'=>$value,
				);
		}
		if(M('youxiubanji')->addAll($data)){
			$this->success('评价成功');
		}else{
			echo M('youxiubanji')->getDbError();
		}
	}
	//检测是否登录
	function islogin(){
		if(session('uid')==null){
			$this->error('请先登录',U(GROUP_NAME.'/Banji/index'));
		}
	}
	//退出登录
	function logout(){
		session('uid',null);

		$this->success('退出成功',U(GROUP_NAME.'/Banji/index'));
	}

}