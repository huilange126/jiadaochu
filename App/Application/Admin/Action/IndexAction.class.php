<?php
Class IndexAction extends CommonAction{
    
    Public function index(){
        
        $this->display();
        
    }
    
    Public function logout(){
        
        
        session_unset();
        
        session_destroy();
        
        $this->success('退出',U(GROUP_NAME.'/Login/index'));
    }
    
}



?>