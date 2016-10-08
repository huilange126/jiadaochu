<?php
// 管理员控制器
Class AdminAction extends CommonAction{
	// 管理员列表
	function index(){
		$count = M('admin')->count();

		$page = getPageObject($count,10);

		$admin = M('admin')->limit($page->firstRow,$page->listRows)->select();

		$data = array(
			'pageName'=>'管理员列表',
			'admin'=>$admin,
			'show'=>$page->show(),
			'num'=>$page->firstRow,
			);

		$this->assign($data);

		$this->display();
	}
	// 添加管理员
	function add(){
		$data = array(
			'pageName'=>'管理员添加',
			);
		$this->display();
	}
	// 添加管理员处理
	function addHandle(){
		// p($_POST);
		$username = I('username','','htmlspecialchars');
		$password = I('password','','htmlspecialchars');
		$repassword = I('repassword','','htmlspecialchars');

		if($username==''||$password==''||$repassword=='') $this->error('信息不能为空');

		if(M('admin')->where(array('username'=>$username))->find()) $this->error('该管理员已经存在');

		if($password!=$repassword) $this->error('两次输入密码不一致');

		$data = array(
			'username'=>$username,
			'password'=>md5($password),
			);
		if(I('id',0,'intval')==0){
			// 表示添加操作
			if(M('admin')->add($data)){
				$this->success('添加管理员成功',U(GROUP_NAME.'/Admin/index'));
			}else{
				$this->error('管理员添加失败，请重试！');
			}
		}else{
			// 表示更新操作

			$data['id'] = I('id',0,'intval');

			if(M('admin')->save($data)){
				$this->success('管理员信息更新成功',U(GROUP_NAME.'/Admin/index'));
			}else{
				$this->error('管理员信息更新失败，请重试');
			}
		}
		
	}
	// 修改管理员
	function edit(){
		$id = I('id',0,'intval');

		if(!$admin=M('admin')->find($id)) $this->error('该管理员不存在');

		$data = array(
			'admin'=>$admin,
			'pageName'=>'管理员信息修改',
			);
		$this->assign($data);

		$this->display();
	}
	// 删除管理员
	function del(){
		$id = I('id',0,'intval');

		if($id==1) $this->error('原始管理员不能删除!');

		if(M('admin')->delete($id)){
			$this->success('管理员删除成功',U(GROUP_NAME.'/Admin/index'));
		}else{
			$this->error('管理员删除失败，请重试');
		}
	}

}



?>