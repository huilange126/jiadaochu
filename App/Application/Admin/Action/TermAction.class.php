<?php
Class TermAction extends CommonAction{
    //学期列表
    Public function index(){
        
        $count  = M('term')->count();
        $page = getPageObject($count,10);

        $term = M('term')->order('id DESC')->limit($page->firstRow,$page->listRows)->select();

        $data = array(
            'term'=>$term,
            'show'=>$page->show(),
            );

        $this->assign($data);
        $this->display();
    }
    
    //添加学期列表
    
    Public function term(){
        $this->display();
    }
    
    //添加学期
    
    Public function addTerm(){
        
        if(!IS_POST) halt('页面不存在');
        $termName = I('name','','htmlspecialchars');
        if($termName=='') $this->error('请输入学期名称');
        
        $data = array(
            'name'=>$termName,
            'status'=>(int)$_POST['status'],
        );
        //如果添加的新学期状态为1 
        //则将数据库中的其他状态为1的学期都修改为0
        if($data['status']==1){
            M('term')->where(array('status'=>1))->setField('status',0);
        }
        if(M('term')->add($data)){
            $this->success('学期添加成功',U(GROUP_NAME.'/Term/index'));
        }else{
            $this->error(M('term')->getDbError());
        }
    }
    
    Public function modify($id){
        
        if(empty($id)) $this->error('必须指定ID');
        
        $this->term = M('term')->where('id = '.$id)->find();
        
        $this->display();
    }
    
    Public function update(){
        
        if(!IP_POST) halt('页面不存在');
        
        $data = array(
            'id'=>$_POST['id'],
            'name'=>$_POST['name'],
            'status'=>$_POST['status'],
        );
        
        if($_POST['status']==1){
            // 将其他学期的状态status修改为0
            M('term')->where(array('status'=>1))->setField('status',0);
        }

        if(M('term')->save($data)){
            $this->success('修改成功',U(GROUP_NAME.'/Term/index'));
        }else{
            
            $this->error(M('term')->getDbError());
        }
    }
}

?>