<?php
// 学生登录检测控制器
Class CommonAction extends Action{
	// 定义共有学生
	protected $student = array();
    
    Public function _initialize(){
        
       if(!isset($_SESSION['studentid'])) $this->error('先登录',U(GROUP_NAME.'/Login/index'));

       $this->student = D('StudentRelation')->relation('banji')->find($_SESSION['studentid']);
      
    }

    
}


?>