<?php
// 学生评教控制器
Class PingAction extends CommonAction{
    // 学生登录首页
    Public function index(){
        //根据session获取学生id 
        $sid = $_SESSION['uid'];
        // 读取学生信息
        // 通过cookie减少数据库读取
        $student = M('student')->where(array('id'=>$sid))->find();
        
        // 读取当前学期
        $term = M('term')->where(array('status=1'))->find();

        // 读取该班级任课老师列表
        $condition = array(
            'bid'=>$student['bid'],
            'termid'=>$term['id'],
            );
        // 获得学生所属班级 教师ID列表
        $teacherIdList = M('teacher_banji')->where($condition)->getField('tid',true);
        // 根据教师ID列表读取教师信息数组
        $teacher = D('TeacherRelation')->relation('xueke')->order('xid ASC')->where(array('id'=>array('IN',$teacherIdList)))->select();

        $project = D('ProjectRelation')->relation(true)->where(array('id'=>$_GET['pid']))->find();
        
        
        if(!empty($_GET['tid'])){
            $data['nowTeacher'] = M('teacher')->where('id='.$_GET['tid'])->find();
        }
        
        $data['project'] = $project;
        $data['student'] = $student;
        $data['teacher'] = $teacher;
        $data['count'] = count($teacher);
        $data['term'] = $term;
        
        $this->assign($data);
        // index为原版的学生评价老师界面
        // default 为amazeui版本的学生评价老师界面
        $this->display('default');
    }
    // 处理学生对一名老师的评价
    Public function addPing(){
        // 获取评价信息
        $ping = $_POST['ping'];
        //检测该老师是否已经评价过
        $shifou = array(
            'pid'=>$_POST['nowproject'],
            'tid'=>$_POST['nowteacher'],
            'sid'=>$_POST['nowstudent'],
            'term'=>$_POST['term'],
        );
        // 如果有条目表示已经评价过
        if(!M('student_project_option')->where(array($shifou))->find()){
            
            foreach($ping as $key=>$row){
            
                $data[] = array(
                    'pid'=>$_POST['nowproject'],
                    'tid'=>$_POST['nowteacher'],
                    'sid'=>$_POST['nowstudent'],
                    'term'=>$_POST['term'],
                    'oid'=>$key,
                    'choose'=>$row,
                );
            }
            // 批量插入数据
            M('student_project_option')->addAll($data);
        }

        $this->success('评价成功,继续评价',U(GROUP_NAME.'/Ping/index',array('pid'=>$_POST['nowproject'],'sid'=>$_POST['nowstudent'])));
        /*
        $where = array(
            'pid'=>$_POST['nowproject'],
            'sid'=>$_POST['nowstudent'],
        );
        
        $count = M('student_project_option')->where($where)->distinct(ture)->field('iod')->count();
        
        $optincount = M('option')->where('pid='.$_POST['nowproject'])->count();
        if($_POST['hidcount']==$count/$optincount){//如果全部都评价完 修改学生状态
            M('student_project')->where($where)->setField('status',2);
            $this->success('评价结束，可以退出系统');
        }else{
            $this->success('评价成功,继续评价',U(GROUP_NAME.'/Ping/index',array('pid'=>$_POST['nowproject'],'sid'=>$_POST['nowstudent'])));
        }*/
    }
    
    Public function logout(){
        
        unset($_SESSION['uid']);
        
        //session_destroy();
        
        $this->success('退出成功',U(GROUP_NAME.'/Index/index'));
    }
}


?>