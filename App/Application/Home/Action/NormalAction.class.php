<?php
// 班级界面统一控制器
Class NormalAction extends Action{

	function _initialize(){

		if(!isset($_SESSION['banjiuid'])) $this->error('请先登录后进行操作',U(GROUP_NAME.'/Login/index'));
	}
}