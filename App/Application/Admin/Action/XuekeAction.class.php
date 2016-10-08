<?php
Class XuekeAction extends CommonAction{
    //学科列表
    Public function index(){
        
        $data['xueke'] = M('xueke')->select();
        
        $this->assign($data);
        
        $this->display();
        
    }
    
    //添加学科页面
    Public function xueke(){
        
        $this->display();
        
    }
    //处理添加学科
    
    Public function addXueke(){
        
        if(!IS_POST) halt('页面不错在');
        
        if(empty($_POST['xueke'])) $this->error('学科名不能为空');
        
        $data['xueke'] = $_POST['xueke'];
        
        if(M('xueke')->add($data)){
            
            $this->success('添加成功');
            
        }else{
            
            $this->error(M('xueke')->getDbError());
        }    
    }
    
    //删除学科
    public function del($id){
        
        if(empty($id)) $this->error('必须指明ID');
        
        $xid = (int)$id;
        
        if(M('xueke')->where('id ='.$xid)->delete()){
            
            $this->redirect(GROUP_NAME.'/Xueke/index');
            
        }else{
            
            $this->error(M('xueke')->getDbError());
            
        }
    }
    //学科修改
    public function modify($id){
        
        if(empty($id)) $this->error('必须指明ID');
        
        $xid = (int)$id;
        
        $data['xueke'] = M('xueke')->where('id ='.$xid)->find();
        
        $this->assign($data);
        
        $this->display();
    }
    
    //修改学科
    
    public function updateXueke(){
        
        if(empty($_POST['xueke'])) $this->error('学科名不能为空');
        
        $data = array(     
            'id'=>$_POST['id'],
            'xueke'=>$_POST['xueke'],
        );
        
        if(M('xueke')->save($data)){
            
            $this->redirect(GROUP_NAME.'/Xueke/index');
            
        }else{
            
            $this->error(M('xueke')->getDbError());
            
        }
    }
}


?>