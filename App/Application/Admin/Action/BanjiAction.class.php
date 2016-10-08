<?php
Class BanjiAction extends CommonAction{
    //班级列表页面
    Public function index(){
        
        import('ORG.Util.Page');
        
        $count = M('banji')->count();
        
        $page = new Page($count,12);
        $page->setConfig('theme',"%totalRow% %header% %nowPage%/%totalPage% 页 <li>%upPage%</li> <li>%downPage%</li> <li>%first%</li> <li>%prePage%</li> <li>%linkPage%</li> <li>%nextPage%</li> <li>%end%</li>");
        
        $banji = M('banji')->limit($page->firstRow,$page->listRows)->order('id DESC')->select();
        
        $teacher = D('TeacherRelation')->relation('xueke')->order('name ASC')->select();
        // p($teacher);die;
        $data = array(
            'banji'=>$banji,
            'teacher'=>$teacher,
            'show'=>$page->show(),
            'num'=>$page->firstRow,
            );
        $this->assign($data);
        $this->display();
        
    }
    //添加班级页面
    Public function banji(){
        
        $this->display();
        
    }
    
    //班级添加
    
    Public function addBanji(){
        
        if(!IS_POST) _404('页面不存在');
        
        if(empty($_POST['ruxuenian'])||empty($_POST['shuliang'])) $this->error('入学年和班级数量不能为空');
        
        for($i=0;$i<(int)$_POST['shuliang'];$i++){
            $data[] = array(
                'ruxuenian'=>(int)$_POST['ruxuenian'],
                'banji'=>$i+1,
                'username'=>($i+1)<10?(int)$_POST['ruxuenian'].'0'.($i+1):(int)$_POST['ruxuenian'].($i+1),
                'password'=>md5('123456'),
            );
        }
        //检查该年是否已经存在
        if(M('banji')->where(array('ruxuenian'=>$_POST['ruxuenian']))->find()){
            
            $this->error($_POST['ruxuenian'].'年已经存在');
            
        }else{
            //检查是否成功插入数据库
            if(M('banji')->addAll($data)){
                
                $this->success('添加成功');
                
            }else{
                
                $this->error(M('banji')->getDbError());
                
            }
        }
    }
    //显示年级列表
    Public function nianji(){
        
        $data['nianji'] = M('nianji')->select();
        
        $this->assign($data);
        
        $this->display();
    }
    
    //修改年级入学年
    Public function setNianji(){
        
       for($i=0;$i<=2;$i++){
            $data = array(
                'id'=>$_POST['id'][$i],
                'ruxuenian'=>$_POST['ruxuenian'][$i],
                'mingcheng'=>$_POST['mingcheng'][$i],
            );
            
            M('nianji')->data($data)->save();
        }
        
        $this->redirect(GROUP_NAME.'/Banji/nianji');
    }

    // 重置班级密码
    function reset(){
        $id = I('id',0,'intval');
        // echo $id;
        $password = md5(C('BANJI_PASSWORD'));
        // echo $password;
        if(M('banji')->where(array('id'=>$id))->setField('password',$password)){
            $this->success('重置密码成功',U(GROUP_NAME.'/Banji/index'));
        }else{
            $this->error(M('banji')->getDbError());
        }
    }

    // AJAX设置班主任
    function addBanzhuren(){
        $banji = I('banji');
        $banzhuren = I('banzhuren');

        if(M('banji')->where(array('id'=>$banji))->setField('banzhuren',$banzhuren)){
            echo 1;
        }else{
            echo 0;
        }
    }
    
}


?>