<?php
// 前台学生控制器
Class StudentAction extends NormalAction{
	// 本班学生列表
	function index(){

		$banjiId = $_SESSION['banjiuid'];
		$banji = M('banji')->find($banjiId);
		$condition = array(
			'bid'=>$banji['id'],
			);
		$count = M('student')->where($condition)->count();
		$page = getPageObject($count,10);
		$student = M('student')->where($condition)->limit($page->firstRow,$page->listRows)->select();

		$data = array(
			'banji'=>$banji,
			'student'=>$student,
			'num'=>$page->firstRow,
			'show'=>$page->show(),
			);

		$this->assign($data);

		$this->display();
	}


}