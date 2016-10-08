<?php
Class RenkeAction extends CommonAction{
    //任课列表页面
    Public function index(){
        
        echo 111111;
        
    }
    
    
    Public function renke(){
        
        $nianji = M('nianji')->order('ruxuenian desc')->select();
        
        foreach($nianji as $row){
            
            $banji[] = M('banji')->where(array('ruxuenian'=>$row['ruxuenian']))->order('banji asc')->select();
            
        }
        
        $data['teacher'] = D('TeacherRelation')->relation(true)->order('xid ASC')->select();
        
        $data['term'] = M('term')->where('status = 1')->find();
        
        $data['banji'] = $banji;
        
        if(!empty($_GET['bid'])){
            
            $bid = $_GET['bid'];

            D('BanjiRelation')->_link['teacher']['condition']='termid='.$data['term']['id'];
            
            $renke = D('BanjiRelation')->relation(true)->where(array('id'=>$bid))->find();

            $data['renke'] = $renke['teacher'];
            $data['bname'] = $renke['ruxuenian'].'级'.$renke['banji'].'班';
            $data['bid'] = $bid;
        }
        //p($data);die;
        $this->assign($data);
        
        $this->display();
        
    }
    
    public function addRenke(){
        
        $banji = $_POST['banji'];
        
        $term = $_POST['term'];
        
        $teacher = explode(',',$_POST['myselect']);
        
        array_shift($teacher);
        
        foreach($teacher as $row){
            
            $data[] = array(
                'bid'=>$banji,
                'tid'=>$row,
                'termid'=>$term,
            );
        }
        //先全部删除该班该学期数据 全部重新插入
        
        M('teacher_banji')->where(array('bid'=>$banji,'termid'=>$term))->delete();
        
        M('teacher_banji')->addAll($data);
        
        $success['status'] = 1;
        
        $this->ajaxReturn($success,'JSON');
        
        /*foreach($data as $row){
            if(!M('teacher_banji')->where($row)->find()){
                
                M('teacher_banji')->add($row);
            }
        }*/
        
    }
}



?>