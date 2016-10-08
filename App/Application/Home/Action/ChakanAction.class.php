<?php
Class ChakanAction extends Action{
    //检测登陆信息函数
    private function checkLogin($tid){
        
        if(empty($_SESSION['level'])) $this->error('请先登陆查看',U(GROUP_NAME.'/Chakan/index'));

        if($tid!=$_SESSION['tid']&&$_SESSION['level']!=1) $this->error('只能查看自己的信息');
        
    }
    //显示输入身份证页面
    function index(){
        $this->display();
    }
    function login(){
        
        $cid = $this->_param('shenfenzheng');
        //echo $cid;
        //echo C('SUPER_VIEW');die;
        if(empty($cid)) $this->error('身份证不能为空！');
        
        if($cid==C('SUPER_VIEW')){
            $_SESSION['level'] = 1;//表示超级管理员
            $this->success('欢迎查看评价信息',U(GROUP_NAME.'/Chakan/teacher'));
        }else{
            if($teacher=M('teacher')->where(array('cid'=>$cid))->find()){
                $_SESSION['level'] = 2;
                $_SESSION['tid'] = $teacher['id'];
                
                $this->success('欢迎'.$teacher['name'].'查看评价信息',U(GROUP_NAME.'/Chakan/xmList',array('tid'=>$teacher['id'])));
            }else{
                $this->error('身份证号码不存在！');
            }
        }
        
        
    }
    function xmList(){
        
        $tid = $this->_param('tid');
        //检测是否查看别人信息
        $this->checkLogin($tid);
        
        $teacherName = M('teacher')->where(array('id'=>$tid))->getField('name');
        
        //所有项目数量
        $count = M('project')->count();
        
        import('ORG.Util.Page');
        
        $page = new Page($count,10);
        $page->setConfig('theme',"%totalRow% %header% %nowPage%/%totalPage% 页 <li>%upPage%</li> <li>%downPage%</li> <li>%first%</li> <li>%prePage%</li> <li>%linkPage%</li> <li>%nextPage%</li> <li>%end%</li>");
        $xm = D('ProjectRelation')->relation('term')->order('id DESC')->limit($page->firstRow,$page->listRows)->select();
        
        $data = array(
            'xm'=>$xm,
            'show'=>$page->show(),
            'now'=>$page->firstRow+1,
            'tid'=>$tid,
            'teachername'=>$teacherName,
        );
        
        $this->assign($data);
        
        $this->display();
        
    }
    
    function teacher(){
        
        if($_SESSION['level']!=1) $this->error('权限不足');
        
        $count = M('teacher')->count();
        
        import('ORG.Util.Page');
        
        $page = new Page($count,10);
        
        $teacher = D('TeacherRelation')->relation(true)->order('xid ASC')->select();
        
        $data = array(
            
            'teacher'=>$teacher,
            'show'=>$page->show(),
            'now'=>$page->firstRow+1,
            
        );

        $this->assign($data);
        
        $this->display();
        
    }
    
    function result(){
        
        $pid = $_GET['xid'];
        
        $tid = $_GET['tid'];
        
        //检测是否查看别人信息
        $this->checkLogin($tid);
        
        $project = D('ProjectRelation')->relation('term')->where(array('id'=>$pid))->find();
        $data['project'] = $project;
        $teacher = M('teacher')->where(array('id'=>$tid))->find();
        $data['teacher'] = $teacher;
        
        $option = M('option')->where(array('pid'=>$pid))->order('sort')->select();
        //指定教师每个选项数量 及 选各个指标数量
        foreach($option as $row){
            $optionAllCount = M('student_project_option')->where(array('pid'=>$row['pid'],'tid'=>$tid,'oid'=>$row['id']))->count();
            $optionAll = M('student_project_option')->where(array('pid'=>$row['pid'],'tid'=>$tid,'oid'=>$row['id']))->select();
            $A = 0;
            $B = 0;
            $C = 0;
            $D = 0;
            foreach($optionAll as $Optionrow){
                switch($Optionrow['choose']){
                    case 1:
                    $A = $A+1;
                    break;
                    case 2:
                    $B = $B+1;
                    break;
                    case 3:
                    $C = $C+1;
                    break;
                    case 4:
                    $D = $D+1;
                    break;
                }
            }
            //得出每个选项全校平均值
            $optionAllCountSchool = M('student_project_option')->where(array('pid'=>$row['pid'],'oid'=>$row['id']))->count();
            $optionAllSchool = M('student_project_option')->where(array('pid'=>$row['pid'],'oid'=>$row['id']))->select();
            $AAll = 0;
            $BAll = 0;
            $CAll = 0;
            $DAll = 0;
            foreach($optionAllSchool as $itemAll){
                switch($itemAll['choose']){
                    case 1:
                    $AAll = $AAll+1;
                    break;
                    case 2:
                    $BAll = $BAll+1;
                    break;
                    case 3:
                    $CAll = $CAll+1;
                    break;
                    case 4:
                    $DAll = $DAll+1;
                    break;
                }
            }
            $sumResult[$row['id']][] = array(
                'ctitle'=>$row['c1'],
                'csum'=>$A,
                'call'=>$optionAllCount,
                'sumall'=>$AAll,
                'allSchool'=>$optionAllCountSchool,
                );
            $sumResult[$row['id']][] = array(
                'ctitle'=>$row['c2'],
                'csum'=>$B,
                'call'=>$optionAllCount,
                'sumall'=>$BAll,
                'allSchool'=>$optionAllCountSchool,
                );
            $sumResult[$row['id']][] = array(
                'ctitle'=>$row['c3'],
                'csum'=>$C,
                'call'=>$optionAllCount,
                'sumall'=>$CAll,
                'allSchool'=>$optionAllCountSchool,
                );
            $sumResult[$row['id']][] = array(
                'ctitle'=>$row['c4'],
                'csum'=>$D,
                'call'=>$optionAllCount,
                'sumall'=>$DAll,
                'allSchool'=>$optionAllCountSchool,
                );
            //p($sumResult);
            // for($i=1;$i<=4;$i++){
            //     $sumResult[$row['id']][] = array(
            //         'ctitle'=>$row['c'.$i],
            //         'csum'=>,
            //         'call'=>$optionAllCount,
                    
            //     );
            // }
            
            //计算改项调查共有多少学生参加
            //$sumResult[$row['id']]['call'] = M('student_project_option')->where(array('pid'=>$row['pid'],'tid'=>$tid,'oid'=>$row['id']))->count();
        }
        
        $data['result'] = $sumResult;
        
        $data['option'] = $option;
        
        $this->assign($data);
        
        $this->display();
    }
    
    function allList(){
        //所有项目数量
        $count = M('project')->count();
        
        import('ORG.Util.Page');
        
        $page = new Page($count,10);
        
        $page->setConfig('theme',"%totalRow% %header% %nowPage%/%totalPage% 页 <li>%upPage%</li> <li>%downPage%</li> <li>%first%</li> <li>%prePage%</li> <li>%linkPage%</li> <li>%nextPage%</li> <li>%end%</li>");
        
        $xm = D('ProjectRelation')->relation('term')->order('id DESC')->limit($page->firstRow,$page->listRows)->select();
        
        $data = array(
            'xm'=>$xm,
            'show'=>$page->show(),
            'now'=>$page->firstRow+1,
        );
        
        $this->assign($data);
        
        $this->display();
    }
    
    function fenshu(){
        
        //所有老师数组
        $allTeacher = M('teacher')->select();
        
        $pid = $this->_param('xid');
        
        $project = D('ProjectRelation')->relation('term')->where(array('id'=>$pid))->find();
        
        $data['project'] = $project;
        
        if(M('defen')->where(array('pid'=>$project['id']))->find()){
            
            $result = D('DefenRelation')->relation(true)->where(array('pid'=>$pid))->order('defen DESC')->select();
            
        }else{
            //当前项目的所有选项数组
            $option = M('option')->where(array('pid'=>$pid))->order('sort')->select();
            
            foreach($allTeacher as $key=>$value){
                
                //$result[$key]['teacher'] = $value; 
                $alldefen = 0;
                foreach($option as $row){
                    
                    $defen = 0;
                    
                    for($i=1;$i<=4;$i++){
                        //选项1-4各的多少
                        $cnum = M('student_project_option')->where(array('pid'=>$row['pid'],'tid'=>$value['id'],'choose ='.$i,'oid'=>$row['id']))->count();
                        //选项1为10分 选项2位8分 选项3位6分 选项4位4分
                        $defen = $defen+$cnum*(12-2*$i); 
                    }
                    $call = M('student_project_option')->where(array('pid'=>$row['pid'],'tid'=>$value['id'],'oid'=>$row['id']))->count();
                    //分项得分
                    //$defen = sprintf("%.2f",$defen/$call);
                    $defen = $defen/$call;
                    //总得分
                    $alldefen = $alldefen + $defen;
                }
                
                //$result[$key]['result'] = $alldefen;
                $result[] = array(
                    'tid'=>$value['id'],
                    'pid'=>$pid,
                    'defen'=>$alldefen,
                );
                
            }


            M('defen')->addAll($result);
            //$sumResult='';
        }
        
        
        $data['result'] = $result;
        
        $this->assign($data);
        
        $this->display('defen');
    }
}


?>