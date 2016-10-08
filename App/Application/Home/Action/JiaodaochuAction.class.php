<?php
// 教导处管理平台班级用户控制器
Class JiaodaochuAction extends NormalAction{
	//班级用户登录首页
	function index(){
		$banji = M('banji')->find($_SESSION['banjiuid']);
		$term = M('term')->where(array('status'=>1))->find();
		// 根据班级入学年份，获得年级
		$nianji = M('nianji')->where(array('ruxuenian'=>$banji['ruxuenian']))->find();

		//p($nianji);die;
		D('EnrollmentRelation')->_link['nianji']['condition'] = 'nianji_id='.$nianji['id'];
		$enrollment = D('EnrollmentRelation')->where(array('status'=>1))->relation('nianji')->select();
		//p(D('EnrollmentRelation')->getLastSql());
		// 排除不属于该年级报名任务
		foreach($enrollment as $key=>$value){
			if(!empty($value['nianji'])){
				$renwu[] = $value;
			}
		}

		$data = array(
			'banji'=>$banji,
			'term'=>$term,
			'renwu'=>$renwu
			);

		$this->assign($data);

		$this->display();
	}
	// 更新班级密码处理
	function password(){
		$password = I('password','','htmlspecialchars');
		$repassword = I('repassword','','htmlspecialchars');

		if(empty($password)||empty($repassword)) $this->error('请输入密码');

		$pattern = "/^[a-zA-Z0-9]{6,10}$/";

		if(!preg_match($pattern, $password)) $this->error('请输入6-10位数字或字母密码');

		$banjiId = $_SESSION['banjiuid'];
		// echo $banjiuid;
		if(M('banji')->where(array('id'=>$banjiId))->setField('password',md5($password))){
			$this->success('密码更新成功');
		}else{
			$this->error('密码更新失败请重试');
		}


	}
}