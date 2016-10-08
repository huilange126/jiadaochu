<?php
//学生评优控制器
Class PingyouAction extends NormalAction{
	// 检测评优是否开启
	function _initialize(){
		if(C('PINGYOU')==0) $this->error('评优暂时未开启');
	}
	function pingyou(){
		// $this->islogin();
		// 这里是不是应该检测$_SESSION['banjiuid']是否失效？
		$banji = M('banji')->find($_SESSION['banjiuid']);

		$term = M('term')->where(array('status'=>1))->find();
		//设定读取当前学期学生成绩
		D('StudentRelation')->_link['chengji']['condition'] = 'termid='.$term['id'];
		$student = D('StudentRelation')->relation('chengji')->order('xuehao ASC')->where(array('bid'=>$banji['id']))->select();

		//根据班级入学年份，获得年级ID，如果为空，表明该入学年份已经失效
		$nianji = M('nianji')->where(array('ruxuenian'=>$banji['ruxuenian']))->find();
		if(empty($nianji)){
			_404('该班级学生已经毕业');
		}
		//读取评优项目
		$xiangmu = M('sanhaoguize')->where(array('nianji'=>$nianji['id']))->select();

		$gzid = I('gzid',0,'intval');
		//是否有子分类
		$hasZifenlei = 0;
		if($gzid!=0){
			$dangqianguize = M('sanhaoguize')->find($gzid);
			//如果选定项目，应该显示已经评选了多少人数
			$condition = array(
				'termid'=>$term['id'],
				'banjiid'=>$banji['id'],
				'sanhaoid'=>$gzid,
				);
			//已经评选的数量
			$yipingshuliang = D('Sanhaojieguo')->getCount($condition);
			//是否选定评优项目标识
			$isxuanding = 1;
			//判定是否有子分类
			if($dangqianguize['zifenlei']!='0'){
				$hasZifenlei = 1;
			}
		}else{
			$isxuanding = 0;
		}

		$data = array(
			'banji'=>$banji,
			'term'=>$term,
			'nianji'=>$nianji,
			'xiangmu'=>$xiangmu,
			'student'=>$student,
			'xueshengshu'=>count($student),
			// 'system'=>$system,
			'appname'=>'评优管理',
			'isxuanding'=>$isxuanding,//是否显示条件限制
			'yipingshuliang'=>$yipingshuliang,//已经评选的人数
			'dangqianguize'=>$dangqianguize,
			'hasZifenlei'=>$hasZifenlei,
			);

		$this->assign($data);

		$this->display();
	}

	//AJAX评优处理
	function pingyouHandle(){
		// $this->islogin();
		$biaoshi = I('biaoshi');

		$shuju = explode(',',I('shuju'));

		$xueshengid = $shuju[0];
		$sanhaoid = $shuju[1];
		$termid = $shuju[2];
		$xueshengshu = I('xueshengshu');
		$banjiid = I('banji');

		$zifenleiid = I('zifenlei');

		if($biaoshi==1){
			//表示要取消评选
			$condition = array(
				'termid'=>$termid,
				'banjiid'=>$banjiid,
				'xueshengid'=>$xueshengid,
				'sanhaoid'=>$sanhaoid,
				);
			M('sanhaojieguo')->where($condition)->delete();
			echo 3;
		}
		if($biaoshi==0){
		//后台需要判定人数是否超了

			$guize = M('sanhaoguize')->find($sanhaoid);
		//获得限定人数
			if($guize['renshu']==0){
				$xiandingrenshu = ceil(($guize[bili]*$xueshengshu)/100);
			}else{
				$xiandingrenshu = $guize['renshu'];
			}
		//获得已经上报人数
			$condition = array(
				'termid'=>$termid,
				'banjiid'=>$banjiid,
			//'xueshengid'=>$xueshengid,
				'sanhaoid'=>$sanhaoid,

				);
			$shangbaorenshu = M('sanhaojieguo')->where($condition)->count();

			if($shangbaorenshu<$xiandingrenshu){
				$data = array(
					'termid'=>$termid,
					'banjiid'=>$banjiid,
					'xueshengid'=>$xueshengid,
					'sanhaoid'=>$sanhaoid,
					'zifenleiid'=>$zifenleiid,
					);

				if(M('sanhaojieguo')->add($data)){
				//表示评优成功
					echo 1;
				}else{
				//表示出问题了
					echo 0;
				}
			}else{
			//表示人数超了
				echo 2;
			}
		}
	}


	//评优结果查看
	function result(){

		//$this->islogin();
		//获取当前年级
		$nianji = M('nianji')->select();

		$system = M('system')->find();

		$njid = I('njid',0,'intval');

		$thenianji = M('nianji')->find($njid);

		//$banji = D('BanjiRelation')->relation('student')->where(array('ruxuenian'=>$thenianji['ruxuenian']))->select();
		$banji = M('Banji')->where(array('ruxuenian'=>$thenianji['ruxuenian']))->select();

		foreach($banji as $key=>$value){
			$result = D('SanhaoRelation')->order('sanhaoid ASC,xueshengid ASC')->relation(true)->where(array('banjiid'=>$value['id']))->select();
			$banji[$key]['result'] = $result;
		}

		$sanhaoxiangmu = M('sanhaoguize')->where(array('nianji'=>$njid))->select();
		

		$data = array(
			'nianji'=>$nianji,
			'system'=>$system,
			'banji'=>$banji,
			'sanhaoxiangmu'=>$sanhaoxiangmu,
			);
		//p($data);die;
		$this->assign($data);

		$this->display();
	}

	// AJAX方式获得学生以往学期评优结果
	function ajaxPastResult(){
		$studentId = I('studentid',0,'intval');
		
		$result = M('sanhaojieguo')->where(array('xueshengid'=>$studentId))->select();

		foreach($result as $key=>$value){
			$data[] = array(
				'xueqi'=>M('term')->where(array('id'=>$value['termid']))->getField('name'),
				'jiangxiang'=>M('sanhaoguize')->where(array('id'=>$value['sanhaoid']))->getField('mingcheng'),
				);
		}
		echo json_encode($data);
	}
}