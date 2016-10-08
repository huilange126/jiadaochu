<?php
// 班级消息控制器
// 用于班级发布消息
Class NoticeAction extends NormalAction{
	// 班级消息列表
	function index(){

		$this->display();
	}

	// 增加消息
	function add(){
		$banjiId = session('banjiuid');
		// 学科列表
		$xueke = M('xueke')->select();

		$data = array(
			'xueke'=>$xueke,
			);
		$this->assign($data);
		$this->display();
	}
	// 编辑消息
	function edit(){

	}
	// 处理消息
	function addHandle(){
		p($_POST);
	}

	// 删除消息
	function del(){

	}

}





?>