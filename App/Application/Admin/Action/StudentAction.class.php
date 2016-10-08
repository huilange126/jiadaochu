<?php
//学生学籍信息控制器
Class StudentAction extends CommonAction{
    
    //学生列表
    Public function index(){

        if(IS_POST){

            $keywords = I('keywords','','htmlspecialchars');

            if($keywords=='') $this->error('请输入搜索关键字');

            $condition = array(
                'xuehao'=>array('like','%'.$keywords.'%'),
                'name'=>array('like','%'.$keywords.'%'),
                '_logic'=>'or',
                );

            $student = D('StudentRelation')->relation(true)->where($condition)->select();

            $data = array(
                'student'=>$student,
                'jishu'=>1,
                );

        }else{
            $count = M('student')->count();

            import('ORG.Util.Page');

            $page = new Page($count,10);
            $page->setConfig('theme',"%totalRow% %header% %nowPage%/%totalPage% 页 <li>%upPage%</li> <li>%downPage%</li> <li>%first%</li> <li>%prePage%</li> <li>%linkPage%</li> <li>%nextPage%</li> <li>%end%</li>");

            $data['student'] = D('StudentRelation')->relation(true)->limit($page->firstRow,$page->listRows)->order('xuehao DESC')->select();

            $data['jishu'] = $page->firstRow+1;

            $data['show'] = $page->show();
        }
        
        $nianji = M('nianji')->select();

        $data['nianji'] = $nianji;

        $this->assign($data);
        
        $this->display();
        
    }
    
    Public function export(){
        
       $this->nianji = M('nianji')->select();
        
        $this->display();
        
    }
    //修改学生信息
    function modify(){

         $id = I('id',0,'intval');

         $student = M('student')->find($id);

         $data = array(
            'student'=>$student,
            );

         $this->assign($data);

         $this->display();


    }
    //修改学生信息处理
    function modifyHandle(){
        $id = I('id',0,'intval');

        $xuehao = I('xuehao','','htmlspecialchars');

        $name = I('name','','htmlspecialchars');

        $xingbie = I('xingbie',0,'intval');

        if(!M('student')->find($id)) $this->error('该学生不存在');
        // 检测学号是否重复
        $student = M('student')->where(array('xuehao'=>$xuehao))->find();

        if($id!=$student['id']&&!empty($student)) $this->error('该学号已经存在');

        $data = array(
            'xuehao'=>$xuehao,
            'name'=>$name,
            'xingbie'=>$xingbie,
            );

        if(M('student')->where(array('id'=>$id))->save($data)){
            $this->success('信息修改成功',U(GROUP_NAME.'/Student/index'));
        }else{
            $this->error(M('student')->getDbError());
        }
    }
    //删除学生信息
    function del(){
        $id = I('id',0,'intval');

        if(M('student')->delete($id)){
            $this->success('删除成功',U(GROUP_NAME.'/Student/index'));
        }else{
            $this->error(M('student')->getDbError());
        }

    }
    Public function add(){
        // 获取启用年级的ID列表
        $nianji = M('nianji')->getField('ruxuenian',true);
        $condition = array(
            'ruxuenian'=>array('IN',$nianji),
            );
        $banji = M('banji')->order('id ASC')->where($condition)->select();

        $data = array(
            'banji'=>$banji,
            );

        $this->assign($data);
        $this->display();
    }

    function addHandle(){
        $banji = $this->_param('banji');
        $xingming = $this->_param('xingming');
        $xuehao = $this->_param('xuehao');
        $xingbie = I('xingbie',1,'intval');

        if($banji==0) $this->error('请选择班级');
        if($xuehao=='') $this->error('学号不能为空');
        if($xingming=='') $this->error('姓名不能为空');

        if(M('student')->where(array('xuehao'=>$xuehao))->find()){
            $this->error('学号已经存在');
        }
        load('extend');
        $data = array(
            'xuehao'=>$xuehao,
            'name'=>$xingming,
            'xingbie'=>$xingbie,
            'bid'=>$banji,
            'password'=>rand_string(6,1),
            );

        if(M('student')->add($data)){
            $this->success('学生添加成功');
        }else{
            $this->error(M('student')->getDbError());
        }
    }
    //设置学号信息显示页面
    function set(){
        $this->display();
    }
    //设置学号信息处理页面
    function setHandle(){
        //组合配置文件格式
        $str = "<?php\r\n return ".var_export(array_change_key_case($_POST,CASE_UPPER),true).";\r\n?>";
        //指定生成文件目录及名称
        file_put_contents(APP_PATH.'/Conf/xuehaoset.php',$str);
        $this->success('修改成功',U(GROUP_NAME.'/Student/set'));
    }
    Public function upload(){
        
        if($_POST['nianji']==0) $this->error('请选择年级');
        
        import('ORG.Net.UploadFile');
        
        $upload = new UploadFile();
        
        $upload->maxSize = 3145728;
        
        $upload->allowExts = array('xls','xlsx');
        
        $upload->savePath = './Uploads/';
        
        $upload->autoSub = true;
        
        $upload->subType = 'date';
        
        $upload->dateFormat = 'Ym';
        
        if(!$upload->upload()){
            
            $this->error($upload->getErrorMsg());
            
        }else{
            
            $info = $upload->getUploadFileInfo();
        }
        
        $file = $info[0]['savepath'].$info[0]['savename'];
        
        $nianji = $_POST['nianji'];
        
        $data = excel_to_mysql($file);
        
        $student = $data['data'];
        
        load('extend');
        $banjistart = C('BANJISTART')-1;
        $banjilength = C('BANJILENGTH');
        foreach($student as $row){
            //根据学号截取所在班级 学号的二三位必须为班级
            $banji = (int)substr($row['xuehao'],$banjistart,$banjilength);
            //根据年级获得入学年，并根据入学年加班级书 获得班级id
            $bid = M('banji')->where(array('ruxuenian'=>$nianji,'banji'=>$banji))->find();
            
            if(!$bid) $this->error('学生表中班级不存在');
            
            $studentlist[] = array(
                'xuehao'=>$row['xuehao'],
                'name'=>$row['name'],
                'xingbie'=>$row['xingbie']=='男'?1:0,
                'password'=>rand_string(6,1),
                'bid' =>$bid['id'],
            
            );
        }
        M('student')->addAll($studentlist);
        
        $this->success('导入成功',U(GROUP_NAME.'/Student/index'));
        
    }
    // 导出学生名单为EXCEL
    function daochu(){

        $ruxuenian = I('ruxuenian',0,'intval');

        $banji = M('banji')->where(array('ruxuenian'=>$ruxuenian))->getField('id',true);

        $condition = array(
            'bid'=>array('IN',$banji),
            );

        $student = M('student')->field('xuehao,name,xingbie,password')->where($condition)->select();
        foreach($student as $key=>$value){
            if($value['xingbie']==0){
                $student[$key]['xingbie'] = '女';
            }else{
                $student[$key]['xingbie'] = '男';
            }
        }
        $header = array(
            '学号','姓名','性别','密码',
            );
        $filename = $ruxuenian.'级学生名单';

        getExcel($filename,$header,$student);

    }
}


?>