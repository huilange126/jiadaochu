<?php
Class TeacherAction extends CommonAction{
    //教师列表页
    Public function index(){

        //如果是POST提交表明是搜索教师
        if(IS_POST){
          $xingming = $this->_param('xingming');
          if($xingming=='') $this->error('姓名不能为空');
          $teacher = D('TeacherRelation')->relation(true)->where(array('name'=>array('LIKE','%'.$xingming.'%')))->select();
          $data = array(
            'teacher'=>$teacher,
            );
        }else{
          import('ORG.Util.Page');

          $count = M('teacher')->count();

          $page = new Page($count,10);

          $page->setConfig('theme',"%totalRow% %header% %nowPage%/%totalPage% 页 <li>%upPage%</li> <li>%downPage%</li> <li>%first%</li> <li>%prePage%</li> <li>%linkPage%</li> <li>%nextPage%</li> <li>%end%</li>");

          $teacher = D('TeacherRelation')->relation(true)->order('xid')->limit($page->firstRow,$page->listRows)->select();
          $data = array(
            'teacher'=>$teacher,
            'show'=>$page->show(),
            );
        }

/*        $this->teacher = $teacher;
        
        $this->show = $page->show();*/

        $this->assign($data);
        
        $this->display();
        
    }
    //添加教师页
    Public function teacher(){
        
        $data['xueke'] = M('xueke')->select();
        
        $this->assign($data);
        
        $this->display();
        
    }
    //修改教师
    function modify(){
        
        $tid = $this->_param('tid');
        
        $teacher = M('teacher')->find($tid);
        
        $data['xueke'] = M('xueke')->select();
        
        $data['teacher'] = $teacher;
        
        $this->assign($data);
        
        $this->display();
        
    }
    //修改教师处理
    function modifyHandle(){
        
        if(!IS_POST) _404('页面不存在');
       
       if(empty($_POST['name'])) $this->error('教师名称不能为空');
       
       if(empty($_POST['xueke'])) $this->error('请选择学科');
       
       $tid = $this->_param('tid');
       
       $data = array(
            
            'name'=>$_POST['name'],
            'xid'=>$_POST['xueke'],
            'cid'=>$_POST['cid'],
       );
       //p($data);die;
       if(M('teacher')->where(array('id'=>$tid))->save($data)){
        
            $this->success('修改成功',U(GROUP_NAME.'/Teacher/index'));
            
       }else{
        
            $this->error(M('teacher')->getDbError());
       }
    }
    //教师添加
    Public function addTeacher(){
        
       if(!IS_POST) _404('页面不存在');
       
       if(empty($_POST['name'])) $this->error('教师名称不能为空');
       
       if(empty($_POST['xueke'])) $this->error('请选择学科');
       
       $data = array(
            
            'name'=>$_POST['name'],
            'xid'=>$_POST['xueke'],
            'cid'=>$_POST['cid'],
       );
       
       if(M('teacher')->add($data)){
        
            $this->success('添加成功');
            
       }else{
        
            $this->error(M('teacher')->getDbError());
       }
  
    }
    
    //删除教师
    function del(){
        
        $id = $this->_param('id','intval');
        
        if(M('teacher')->where(array('id'=>$id))->delete()){
            $this->redirect(GROUP_NAME.'/Teacher/index');
        }
    }
}



?>