<?php
// 学生端登录控制器
Class LoginAction extends Action{

	// 显示登录界面
	function index(){

		$this->display();
	}
	// 登录处理
	function loginHandle(){
		$username = I('username','','htmlspecialchars');
		$password = I('password','','htmlspecialchars');
		// 检测用户名和密码非空
		if($username==''||$password=='') $this->error('用户名或密码不能为空');

		$condition = array(
			'xuehao'=>$username,
			'password'=>$password,
			);

		$student = M('student')->where($condition)->find();

		if(empty($student)){
			$this->error('用户名或密码错误');
		}else{
			// 设置session
			session('studentid',$student['id']);

			$this->success('登录成功，正在跳转……',U(GROUP_NAME.'/Index/index'));
		}
	}
	// 退出登录
	function logout(){

		session('studentid','');

		$this->success('退出成功！',U(GROUP_NAME.'/Login/index'));
	}

}