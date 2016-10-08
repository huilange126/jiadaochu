<?php
Class ShowclassAction extends Action{
    
    function index(){
        
        $nianji = M('nianji')->order('ruxuenian desc')->select();
        
        foreach($nianji as $row){
            $banji[$row['mingcheng']] = M('banji')->where('ruxuenian='.$row['ruxuenian'])->select();
        }
        
        $data['banji'] = $banji;
        
        if(!empty($_GET['bid'])){
            
            $theBanji = M('banji')->where(array('id'=>$_GET['bid']))->find();
            
            $theNianji = M('nianji')->where(array('ruxuenian'=>$theBanji['ruxuenian']))->find();
            
            $project = D('NianjiRelation')->where('id='.$theNianji['id'])->relation(true)->find();
            
            $allProject = $project['project'];
            
            $term = M('term')->where(array('status = 1'))->find();//取得当前学期ID
            //剔除非本学期的评价项目
            foreach($allProject as $row){
                if($row['term']==$term['id']) $data['project'][] = $row;
            }
            
            //p($project);die;
            
            $count = M('student')->where(array('bid'=>$_GET['bid']))->count();
            
            import('ORG.Util.Page');
            
            $page = new Page($count,20);
            
            $classStudent = M('student')->where(array('bid'=>$_GET['bid']))->limit($page->firstRow,$page->listRows)->select();
            
            $data['show'] = $page->show();
            
            $data['jishu'] = $page->firstRow;
            
        }
        
        $data['student'] = $classStudent;
        
        $this->assign($data);
        
        $this->display();
    }
    
}



?>