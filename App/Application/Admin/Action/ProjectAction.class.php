<?php
Class ProjectAction extends CommonAction{
    //项目列表
    public function index(){
        
        $count = M('project')->count();

        $page = getPageObject($count,1);
        
        $project = D('ProjectRelation')->relation(true)->limit($page->firstRow,$page->listRows)->order('id DESC')->select();
        
        $show = $page->show();
        
        $data = array(
            'project'=>$project,
            'show'=>$show,
            );
        // p($data);die;
        $this->assign($data);
        $this->display();
    }
    //添加项目页面
    public function project(){
        
        $nianji = M('nianji')->order('ruxuenian desc')->select();
        
        $term = M('term')->where('status = 1')->find();

        $data = array(
            'nianji'=>$nianji,
            'term'=>$term,
            );

        $this->assign($data);
        
        $this->display();
    }
    
    //添加项目
    public function addProject(){
       
        if(!IS_POST) halt('页面不存在');

        if(empty($_POST['name'])) $this->error('请添加项目名称');
        
        if(empty($_POST['nianji'])) $this->error('请选择参加年级');
              
        
        $data['name'] = I('name');//$_POST['name'];        
        $data['term'] = I('term');//$_POST['term'];
        $data['leixing'] = I('leixing');
        
        $pid = M('project')->add($data);
        
        $nianji = $_POST['nianji'];
        
        foreach($nianji as $row){
            $year = M('nianji')->where(array('id'=>$row))->getField('ruxuenian');
            $datarelation[] = array(
                'pid'=>$pid,
                'nid'=>$row,
                'ruxuenian'=>$year,
            ); 
        }
        
        M('project_nianji')->addAll($datarelation);
        
        $this->success('添加成功',U(GROUP_NAME.'/Project/index'));
    }
    //修改项目页面
    function modify(){
        
        $id = $this->_param('id','intval');
        
        $project = D('ProjectRelation')->relation(array('nianji','term','ruxuenian'))->where(array('id'=>$id))->find();
        // p($project);die;
        // 循环遍历所属年级id
        foreach($project['nianji'] as $key=>$value){
            $nianjiIdList[] = $value['id'];
        }
        $nianji = M('nianji')->select();
        // 已经添加年度数组
        $hasTianjia = $project['ruxuenian'];
        // 重新组合已有年份
        foreach($hasTianjia as $key=>$value){
            $year[] = $value['ruxuenian'];
        }
        // 已有年份与当前年级比较，返回没有参加的当前年级
        $meiyouNianji = bijiaoYear($nianji,$year);
        // 与年级数组比较那些是当前年级的入学年
        
        $data = array(
            'nianji'=>$nianji,
            'project'=>$project,
            'nianjiIdList'=>$nianjiIdList,
            );
        // p($data);die;
        $this->assign($data);
        $this->display();
    }
    // 修改处理
    function modifyHandle(){
        $id = I('id');
        $name = I('name');
        if($name=='') $this->error('请输入项目名称');
        $nianji = I('nianji');
        if($nianji=='') $this->error('请选择年级');
        // p($_POST);die;
        $data = array(
            'id'=>$id,
            'name'=>$name,
            );
        // 更新项目名称
        M('project')->save($data);
        // 删除原来项目年级对应关系
        M('project_nianji')->where(array('pid'=>$id))->delete();
        $data = array();
        foreach($nianji as $key=>$value){
            $data[] = array(
                'pid'=>$id,
                'nid'=>$value,
                );
        }

        // 重新插入年级项目关系
        M('project_nianji')->addAll($data);

        $this->success('更新成功',U(GROUP_NAME.'/Project/modify',array('id'=>$id)));
    }
    public function option($pid){
        
        if(empty($pid)) $this->error('请指定评价项目');
        
        $data['option'] = M('option')->order('sort')->where('pid = '.$pid)->select();
        
        $data['pid'] = $pid;
        
        $this->assign($data);
        
        $this->display();
    }
    // 增加选项处理
    public function addOption(){
        
        //非空没有验证 字段较多可以采用自动验证 create
        
        $data = array(
            'pid'=>$_POST['pid'],
            'name'=>$_POST['optionname'],
            'sort'=>$_POST['optionsort'],
            'c1'=>$_POST['c1'],
            'c2'=>$_POST['c2'],
            'c3'=>$_POST['c3'],
            'c4'=>$_POST['c4'],
        );
        
        if(M('option')->add($data)){
            $this->success('添加成功',U(GROUP_NAME.'/Project/option',array('pid'=>$_POST['pid'])));
        }else{
            $this->error(M('option')->getDbError());
        }
    }
    
    //修改排序
    public function sort(){
        foreach($_POST as $id=>$sort){
            M('option')->where('id='.$id)->setField('sort',$sort);
        }  
        $this->redirect(GROUP_NAME.'/Project/option',array('pid'=>$_POST['pid']));
    }
    // 选项列表
    function optionList(){
        $count = M('option')->count();

        $page = getPageObject($count,10);

        $option = M('option')->limit($page->firstRow,$page->listRows)->order('id DESC')->select();

        $data = array(
            'option'=>$option,
            'show'=>$page->show(),
            );

        $this->assign($data);

        $this->display();
    }

    // 生成评价结果
    function ajaxResult(){

        // 定义选项分值
        $Apoint = 10;
        $Bpoint = 8;
        $Cpoint = 6;
        $Dpoint = 4;

        // 评价项目id
        $project_id = I('id',0,'intval');
        // 获取该项目的评价项
        $project = D('ProjectRelation')->relation(true)->where(array('id'=>$project_id))->find();
        // p($project);die;
        // 获得学期id
        $term_id = $project['termid'];
        // 根据学期id获得 该学期的认可教师ID数组
        $teacherIdList = M('teacher_banji')->order('tid ASC')->where(array('termid'=>$term_id))->distinct('tid')->getField('tid',true);
        // 获取教师信息数组
        $teacher = M('teacher')->where(array('id'=>array('IN',$teacherIdList)))->select();
        // 获取全校评价结果
        $condition = array(
            'pid'=>$project_id,
            'term'=>$term_id,
            );
        // 循环项目中的评价项，获得全校数据
        $quanxiaoChoose = M('student_project_option')->where($condition)->field(array('oid','choose'))->select();
        
        foreach($project['choose'] as $key=>$value){
            $allData[$value['id']] = array(
                'c1'=>0,
                'c2'=>0,
                'c3'=>0,
                'c4'=>0,
                );
        }
        // 循环统计全校数据
        foreach($quanxiaoChoose as $key=>$value){
            
            switch ($value['choose']) {
                case 1:
                    $allData[$value['oid']]['c1'] = $allData[$value['oid']]['c1']+1;
                    break;
                case 2:
                    $allData[$value['oid']]['c2'] = $allData[$value['oid']]['c2']+1;
                    break;
                case 3:
                    $allData[$value['oid']]['c3'] = $allData[$value['oid']]['c3']+1;
                    break;
                case 4:
                    $allData[$value['oid']]['c4'] = $allData[$value['oid']]['c4']+1;
                    break;
            }

        }
        // 格式化全校统计数据
        foreach($allData as $key=>$value){
            $qxAll = $value['c1']+$value['c2']+$value['c3']+$value['c4'];
            $allDataPrint[$key] = array(
                'c1'=>$this->baifenbi($value['c1'],$qxAll),
                'c2'=>$this->baifenbi($value['c2'],$qxAll),
                'c3'=>$this->baifenbi($value['c3'],$qxAll),
                'c4'=>$this->baifenbi($value['c4'],$qxAll),
                );

            $allDataPrint[$key]['defen'] = round(($allDataPrint[$key]['c1']*$Apoint+$allDataPrint[$key]['c2']*$Bpoint+$allDataPrint[$key]['c3']*$Cpoint+$allDataPrint[$key]['c4']*$Dpoint)*0.01,2);
        }
        
        // 循环遍历教师
        // echo date('Y-m-d H:i:s',time());
        // 存储教师评教结果数组
        $fileURL = array();
        foreach($teacher as $key=>$value){

            $data = array();
            $teacher_id = $value['id'];
            
            $condition = array(
                'tid'=>$teacher_id,
                'term'=>$term_id,
                'pid'=>$project_id,
                );
            $data['teacher'] = $value['name'];
            $data['project'] = $project['name'];
            // 一次读取该老师所有评选结果
            $optionChoose = M('student_project_option')->field(array('oid','choose'))->where($condition)->select();
            // 初始化数组
            foreach($project['choose'] as $optionKey=>$optionValue){
                $data['result'][$optionValue['id']] = array(
                    'option'=>$optionValue,
                    'c1'=>0,
                    'c2'=>0,
                    'c3'=>0,
                    'c4'=>0,
                    );
            }
            // 循环学生对该老师的评价结果
            foreach($optionChoose as $chooseKey=>$chooseValue){
                switch ($chooseValue['choose']) {
                    case 1:
                        $data['result'][$chooseValue['oid']]['c1'] = $data['result'][$chooseValue['oid']]['c1']+1;
                        break;
                    case 2:
                        $data['result'][$chooseValue['oid']]['c2'] = $data['result'][$chooseValue['oid']]['c2']+1;
                        break;
                    case 3:
                        $data['result'][$chooseValue['oid']]['c3'] = $data['result'][$chooseValue['oid']]['c3']+1;
                        break;
                    case 4:
                        $data['result'][$chooseValue['oid']]['c4'] = $data['result'][$chooseValue['oid']]['c4']+1;
                        break;
                }
            }
            // 该老师评价结果放置于data中
            // p($data);
            
            $fileURL[] = './Uploads/'.$this->toWord($allDataPrint,$data);
            echo '生成'.++$key.$data['teacher'].'结果'.'<br>';
            ob_flush();
            flush();
        }
        

        // 生成打包文件
        $filename = iconv('utf-8', 'gb2312','./Uploads/评教结果.zip');
        $zip = new ZipArchive;
        if ($zip->open($filename,ZipArchive::OVERWRITE) === TRUE) {
            foreach($fileURL as $key=>$value){
                $zip->addFile($value,get_basename($value));
            }
            $zip->close();
            $dabaoURL = __ROOT__.'/Uploads/评教结果.zip';
            echo '打包下载报表 <a href='.$dabaoURL.'>点击下载</a>'.'<br>';
            ob_flush();
            flush();
        } else {
            echo '生成失败，请重新尝试';
        }
    }

    // 根据数据生成word文件
    // $dataAll表示全校评选数据
    // $dataOne表示该老师评选数据
    function toWord($dataAll,$dataOne){
        // 定义选项分值
        $Apoint = 10;
        $Bpoint = 8;
        $Cpoint = 6;
        $Dpoint = 4;
        // 导入PHPword类
        vendor('PHPWord.PHPWord');

        $PHPWord = new PHPWord();

        $section = $PHPWord->createSection();

        // 定义标题文字样式
        $titleFontStyle = array('bold'=>true,'name'=>'宋体','size'=>14, 'color'=>'006699');
        $titleParagraphStyle = array('align'=>'center', 'spaceAfter'=>100);

        // 定义表格样式
        $styleTable = array('borderSize'=>6, 'borderColor'=>'006699', 'cellMargin'=>80);
        $styleFirstRow = array('borderBottomSize'=>18, 'borderBottomColor'=>'0000FF', 'bgColor'=>'66BBFF');

        // 定义单元格样式
        $styleCell = array('valign'=>'center');
        $styleCellBTLR = array('valign'=>'center', 'textDirection'=>PHPWord_Style_Cell::TEXT_DIR_BTLR);

        // 定义第一行样式
        $fontStyle = array('bold'=>true);
        $paragraphStyle = array('align'=>'center');

        // 添加表格样式
        $PHPWord->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);

        $section->addText($dataOne['project'],$titleFontStyle,$titleParagraphStyle);
        $section->addText($dataOne['teacher']."评教结果",$titleFontStyle,$titleParagraphStyle);
        // 添加表格
        $table = $section->addTable('myOwnTableStyle');
        
        // 添加第一行
        $table->addRow(500);
        // 添加单元格
        $table->addCell(500, $styleCell)->addText('序号', $fontStyle,$paragraphStyle);
        $table->addCell(4000, $styleCell)->addText('评价项', $fontStyle,$paragraphStyle);
        $table->addCell(3200, $styleCell)->addText('评价结果', $fontStyle,$paragraphStyle);
        $table->addCell(1300, $styleCell)->addText('得分', $fontStyle,$paragraphStyle);
        // 循环教师评教结果数据
        $i = 1;
        // 初始化总得分
        $zongfen = 0;
        // 初始化全校平均分
        $pingjun = 0;
        foreach($dataOne['result'] as $key=>$value){
            $table->addRow(500);
            $table->addCell(500, $styleCell)->addText($i++, $fontStyle,$paragraphStyle);
            $table->addCell(4000, $styleCell)->addText($value['option']['name'], $fontStyle);
            // 所有评价之和
            $all = $value['c1']+$value['c2']+$value['c3']+$value['c4'];
            $cell = $table->addCell(3200, $styleCell);
            // 计算选项1百分比
            $Apert = $this->baifenbi($value['c1'],$all);
            $str = $value['option']['c1'].":".$Apert.'   均值：'.$dataAll[$key]['c1'];
            $cell->addText($str,$fontStyle);
            // 计算选项2百分比
            $Bpert = $this->baifenbi($value['c2'],$all);
            $str = $value['option']['c2'].":".$Bpert.'   均值：'.$dataAll[$key]['c2'];
            $cell->addText($str,$fontStyle);
            // 计算选项3百分比
            $Cpert = $this->baifenbi($value['c3'],$all);
            $str = $value['option']['c3'].":".$Cpert.'   均值：'.$dataAll[$key]['c3'];;
            $cell->addText($str,$fontStyle);
            // 计算选项4百分比
            $Dpert = $this->baifenbi($value['c4'],$all);
            $str = $value['option']['c4'].":".$Dpert.'   均值：'.$dataAll[$key]['c4'];;
            $cell->addText($str,$fontStyle);
            // 得分单元格
            $defenCell = $table->addCell(1300, $styleCell);
            // 计算该项平均得分
            $defen = round(($Apert*$Apoint+$Bpert*$Bpoint+$Cpert*$Cpoint+$Dpert*$Dpoint)*0.01,2);
            $defenCell->addText('得分：'.$defen,$fontStyle);
            $defenCell->addText('均值：'.$dataAll[$key]['defen'],$fontStyle);
            // 累计得分
            $zongfen = $zongfen+$defen;
            $pingjun = $pingjun+$dataAll[$key]['defen'];

        }
        // 页尾显示总分和生成时间

        $strSum = '总分：'.$zongfen.'  全校平均得分：'.$pingjun;
        $strTime = "报告生成时间".date('Y-m-d H:i:s',time());
        $section->addText($strSum.$strTime,$fontStyle,$paragraphStyle);
        // $table->addRow(300);
        // $table->addCell(9000, $styleCell)->addText($strSum.$strTime, $fontStyle,$paragraphStyle);
        // $section->addText($strSum.$strTime,$fontStyle,array('align'=>right));

        $savePath = date('Ym',time());
        // 检查上传目录
        $this->checkSavePath('./Uploads/'.$savePath);
        $objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
        $fileName = $dataOne['teacher'].$this->wenjianming().'.docx';
        $fileName  = iconv("utf-8","gb2312",$fileName );
        $objWriter->save('./Uploads/'.$savePath.'/'.$fileName);
        return $savePath.'/'.$fileName;
    }
    private function baifenbi($one,$all){

        $per = round(($one/$all),4)*100;

        return $per.'%';
    }
    protected function checkSavePath($savePath){
        if(!is_dir($savePath)) {
            // 检查目录是否编码后的
            if(is_dir(base64_decode($savePath))) {
                $savePath=base64_decode($savePath);
            }else{
                // 尝试创建目录
                if(!mkdir($savePath)){
                    $this->error = '上传目录'.$savePath.'不存在';
                    // return false;
                }
            }
        }else {
            if(!is_writeable($savePath)) {
                $this->error  =  '上传目录'.$savePath.'不可写';
                // return false;
            }
        }
    }
    // 生成文件名
    protected function wenjianming(){
        load('extend');

        // return time().rand_string($len=6,1);
        return '('.date('Ymd',time()).')';
    }
}



?>