<?php
// 学生评价老师统一控制器
Class CommonAction extends Action{
    
    Public function _initialize(){
        
       if(!isset($_SESSION['uid'])) $this->error('先登录再评价',U(GROUP_NAME.'/Index/index'));
    }
    
}


?>