<?php
Class CommonAction extends Action{
    
    Public function _initialize(){
        
        if(!isset($_SESSION['uid'])||!isset($_SESSION['username'])) $this->error('请先登录',U(GROUP_NAME.'/Login/index'));
        
    }
    
}



?>