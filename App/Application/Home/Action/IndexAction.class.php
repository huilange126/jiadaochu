<?php
// 学生评教登录控制器
Class IndexAction extends Action{
    public function index(){
        
        $term = M('term')->where('status = 1')->find();
        
        $data['project'] = M('project')->where(array('term'=>$term['id']))->select();
        
        if(empty($data['project'])) $data['message'] = '本学期还没有添加评价项目';
        
        $this->assign($data);
        
        $this->display('default');
    
    }
    public function verify(){
        
        import('ORG.Util.Image');
        
        Image::buildImageVerify();
        
    }
    //学生登陆界面
    public function login(){
        
        if(!IS_POST) halt('页面不存在');
        
        if($_POST['project']==0) $this->error('请选择评价项目');
        
        $student = M('student')->where(array('xuehao'=>$_POST['username']))->find();
        
        if(!$student||$student['password']!=$_POST['password']) $this->error('用户或密码错误');
        
        $banji = M('banji')->where(array('id'=>$student['bid']))->find();
        
        $nianji = M('nianji')->where(array('ruxuenian'=>$banji['ruxuenian']))->find();
        
        $project = M('project_nianji')->where(array('pid'=>$_POST['project'],'nid'=>$nianji['id']))->find();
        
        if(!$project) $this->error('你所在年级不参加该项评价');
        
        if($status = M('student_project')->where(array('sid'=>$student['id'],'pid'=>$_POST['project']))->find()){
            
            if($status['status']==2){
                
                $this->error('你已经评价结束该项目');
            }else{
                $this->success('继续上次评价继续评价',U(GROUP_NAME.'/Ping/index',array('pid'=>$_POST['project'])));
                Session('uid',$student['id']);
            }
            
        }else{
            
            $data = array(
                'sid'=>$student['id'],
                'pid'=>$_POST['project'],
                'status'=>'1',//1表示正在进行中 2表示评价结束
            );
            
            M('student_project')->add($data);
            
            $this->success('开始评价',U(GROUP_NAME.'/Ping/index',array('pid'=>$_POST['project'])));
            
            session('uid',$student['id']);
        }
    }
    
}

?>