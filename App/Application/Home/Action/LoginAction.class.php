<?php
// 班级通用登录控制器
Class LoginAction extends Action{
	//登录界面
	function index(){
		$term = M('term')->where(array('status'=>1))->find();
		$data = array(
			// 'system'=>$system,
			'term'=>$term,
			);
		$this->assign($data);
		$this->display();
	}

	//登录处理
	function loginHandle(){
		if(!IS_POST) $this->error('页面不存在');

		$username = I('username');
		$password = I('password');

		if(empty($username)||empty($password)) $this->error('用户名和密码不能为空');

		$condition = array(
			'username'=>$username,
			'password'=>md5($password),
			);
		$banji=M('banji')->where($condition)->find();
		if($banji==''){
			$this->error('用户名或密码错误');
		}else{
			session('banjiuid',$banji['id']);
			// session('system','pingyou');
			$this->success('登陆成功',U(GROUP_NAME.'/Jiaodaochu/index'));
		}
	}

	//退出登录
	function logout(){
		unset($_SESSION['banjiuid']);
		// unset($_SESSION['system']);
		$this->success('退出系统成功',U(GROUP_NAME.'/Login/index'));
	}

}