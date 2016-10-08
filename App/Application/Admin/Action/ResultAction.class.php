<?php
Class ResultAction extends CommonAction{
    //显示各个评价列表
    Public function index(){
        
        import('ORG.Util.Page');
        
        $count = M('project')->count();
        
        $page = new Page($count,10);
        
        $data['show'] = $page->show();
        
        $data['project'] = D('ProjectRelation')->relation('term')->limit($page->firstRow,$page->listRows)->select();
        
        //p($data['project']);die;
        
        $this->assign($data);
        
        $this->display();
        
    }
    
    Public function teacherlist(){
        
        $pid = $_GET['pid'];
        
        $project = D('ProjectRelation')->relation('term')->where('id='.$pid)->find();
        
        $data['project'] = $project;
        
        $teacher = M('teacher')->order('name')->select();
        
        $data['teacher'] = $teacher;
        
        $this->assign($data);
        
        $this->display();
    }
    //显示某个老师某个项目的评价结果细节
    Public function detail(){
        
        $pid = $_GET['pid'];
        
        $tid = $_GET['tid'];
        
        $project = D('ProjectRelation')->relation('term')->where(array('id'=>$pid))->find();
        $data['project'] = $project;
        $teacher = M('teacher')->where(array('id'=>$tid))->find();
        $data['teacher'] = $teacher;
        
        $option = M('option')->where(array('pid'=>$pid))->order('sort')->select();
        
        foreach($option as $row){
            
            for($i=1;$i<=4;$i++){
                
                $sumResult[$row['id']][] = array(
                    
                    'ctitle'=>$row['c'.$i],
                    'csum'=>M('student_project_option')->where(array('pid'=>$row['pid'],'tid'=>$tid,'choose ='.$i,'oid'=>$row['id']))->count(),
                    
                );
            }
        }
        
        $data['result'] = $sumResult;
        
        $data['option'] = $option;
        
        $this->assign($data);
        
        $this->display();
    }
    
    function showAllDetail(){
        //所有老师数组
        $allTeacher = M('teacher')->select();
       //p($allTeacher);die;
        $pid = 4;//当前评价项目id
        $project = D('ProjectRelation')->relation('term')->where(array('id'=>$pid))->find();
        $data['project'] = $project;
        //当前项目的所有选项数组
        $option = M('option')->where(array('pid'=>$pid))->order('sort')->select();
        
        foreach($allTeacher as $key=>$value){
            $result[$key]['teacher'] = $value; 
            foreach($option as $row){
                for($i=1;$i<=4;$i++){
                    $call = M('student_project_option')->where(array('pid'=>$row['pid'],'tid'=>$value['id'],'oid'=>$row['id']))->count();
                    $cnum = M('student_project_option')->where(array('pid'=>$row['pid'],'tid'=>$value['id'],'choose ='.$i,'oid'=>$row['id']))->count();
                    $sumResult[$row['id']][] = array(
                        'option'=>$row['name'],
                        'ctitle'=>$row['c'.$i],
                        'call'=>sprintf("%.2f", 100*$cnum/$call),
                        'csum'=>$cnum,
                        
                    );
                    
                }
                
            }
            
            $result[$key]['result'] = $sumResult;
            $sumResult='';
        }

        $data['result'] = $result;
       // p($data);die;
        $this->assign($data);
        
        $this->display();
    }
}

?>