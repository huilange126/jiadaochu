<?php
Class LoginAction extends Action{
    //登陆界面
    Public function index(){
        echo session('uid');
        $this->display();
        
    }
    //处理登陆
    Public function login(){
        
        if($_POST['code']!=$_SESSION['verify']) $this->error('验证码错误');
        
        $where['username'] = $_POST['username'];
        
        $admin = M('admin')->where($where)->find();
        
        if(!$admin||$admin['password']!=md5($_POST['password'])) $this->error('用户名或密码错误');
        
        session('uid',$admin['id']);
        
        session('username',$admin['username']);
        
        $this->redirect(GROUP_NAME.'/Index/index');
        
    }
    //验证码
    Public function verify(){
        
        import('Class.Image',APP_PATH);
        
        Image::verify();
        
    }
}




?>