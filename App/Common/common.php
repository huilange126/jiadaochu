<?php

    function p($arr){
        dump($arr,1,'<pre>',0);
    }
        // 让basename支持中文
    function get_basename($filename){  
       return preg_replace('/^.+[\\\\\\/]/', '', $filename);  
   } 
    // 根据班级ID获得班级名称
    function getBanji($id){
        $banji = M('banji')->find($id);
        return $banji['username'];
    }
    // 根据入学年获得年级名称
    function getNianjiMingcheng($year){
        $nianji = M('nianji')->where('ruxuenian='.$year)->find();
        if(empty($nianji)) return $year.'级';
        return $nianji['mingcheng'];
    }
    // 根据已有学年与当前年级学年进行比较，返回还没有添加的当前年
    function bijiaoYear($nianji,$yiyou){
        foreach($nianji as $key=>$value){
            if(!in_array($value['ruxuenian'],$yiyou)){
                $data = $value;
            }  

            return $data;
        }
    }
    //根据老师ID获得学科名称
    function getTeacherXueke($tid){
        
        $teacher = D('TeacherRelation')->relation(true)->where('id='.$tid)->find();
        
        return $teacher['xueke'];
    }
    // 根据性别特征返回性别
    function getSex($sex){
        if($sex==1){
            return '男';
        }
        if($sex==0){
            return '女';
        }
    }
    // 根据奖惩编码返回奖惩类型
    function getJiangChengLeixing($leixing){
        switch ($leixing) {
            case 1:
                $str = '奖励';
                break;
            case 2:
                $str = '惩罚';
                break;
            case 3:
                $str = '其他';
                break;
        }

        return $str;
    }
    //根据老师ID获得老师名称
    function getTeacherName($tid){
        
        $teacher = D('TeacherRelation')->relation(true)->where('id='.$tid)->find();
        
        return $teacher['name'];
    }
    //检查该学生有没有评过该老师 1表示评了 0表示未评
    function checkTeacherStatus($pid,$sid,$tid){
        
        $where = array(
            'tid'=>$tid,
            'pid'=>$pid,
            'sid'=>$sid,
        );
        
        if(M('student_project_option')->where($where)->find()){
            return 1;
        }else{
            return 0;
        }
    }
    //根据学生ID返回学生参加那些项目评选
    function getStudentProjectStatus($sid,$pid){
        
        $status = M('student_project')->where(array('sid'=>$sid,'pid'=>$pid))->find();
        
        if(!$status){
            
            return '<span style="color:red">还没进行</span>';
            
        }else if($status['status']==1){
            
            return '<span style="color:blue">正在进行中，未全部完成</span>';
        }else if($status['status']==2){
            return '<span style="color:green">评价完成</span>';
        }
        
    }
    //根据学科ID返回学科名称
    function getXuekeName($xid){
        $xueke = M('xueke')->find($xid);

        return $xueke['xueke'];
    }
    //根据评优项目ID返回评优项目名称
    function getXiangmuName($xid){
        $xiangmu = M('sanhaoguize')->find($xid);

        return $xiangmu['mingcheng'];
    }
    //判定一个学生是否已经参加了某个评优项目
    function getXueshengStatus($xueshengid,$termid,$sanhaoid){

        $condition = array(
            'xueshengid'=>$xueshengid,
            'termid'=>$termid,
            'sanhaoid'=>$sanhaoid,
            );
        // p($condition);
        //return M('sanhaojieguo')->find();
        if($jieguo=M('sanhaojieguo')->where($condition)->find()){
            $data = array(
                'status'=>1,
                'jieguo'=>$jieguo,
                );
        }else{
            $data = array(
                'status'=>0,
                );
        }

        return $data;
    }
    function getExcel($fileName,$headArr,$data){
        vendor("PHPExcel.PHPExcel");//如果这里提示类不存在，肯定是你文件夹名字不对。
        $objPHPExcel = new \PHPExcel();//这里要注意‘\’ 要有这个。因为版本是3.1.2了。
        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);//设置保存版本格式
        $date = date("Y_m_d",time());
        $fileName .= "_{$date}.xls";
        //接下来就是写数据到表格里面去
        //设置表头
        $key = ord("A");
        //print_r($headArr);exit;
        foreach($headArr as $v){
            $colum = chr($key);
            $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
            $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
            $key += 1;
        }
        $column = 2;
        $objActSheet = $objPHPExcel->getActiveSheet();

        //print_r($data);exit;
        foreach($data as $key => $rows){ //行写入
            $span = ord("A");
            foreach($rows as $keyName=>$value){// 列写入
                $j = chr($span);
                // 设置左右内容为文本格式数据
                $objActSheet->setCellValueExplicit($j.$column, $value,PHPExcel_Cell_DataType::TYPE_STRING);
                $span++;
            }
            $column++;
        }

        $fileName = iconv("utf-8", "gb2312", $fileName);

        //重命名表
        //$objPHPExcel->getActiveSheet()->setTitle('test');
        //设置活动单指数到第一个表,所以Excel打开这是第一个表
        $objPHPExcel->setActiveSheetIndex(0);
        ob_end_clean();//清除缓冲区,避免乱码
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output'); //文件通过浏览器下载
        exit;

    }
    // ziduan 2表示导入学生 3表示导入成绩
    function excel_to_mysql($file,$ziduan=2){
        //导入PHPExcel第三方类库
        vendor('PHPExcel.PHPExcel');
        //实例化PHPExcel类，用于接收Excel文件
        $PHPExcel = new PHPExcel();
        //读取Excel文件类实例化
        $PHPReader = new PHPExcel_Reader_Excel5();
        //检测Excel版本是否可读
        if(!$PHPReader->canRead($file)){
            
            $PHPReader = new PHPExcel_Reader_Excel2007();
            
            if(!$PHPReader->canRead($file)) return array('error'=>1);//未知版本的Excel
        }
        //读取Excel文件
        $PHPExcel = $PHPReader->load($file);
        //获得Excel中表的数量
        $sheetCount = $PHPExcel->getSheetCount();
        //获得第一张工作表
        $sheet=$PHPExcel->getSheet(0);
        //获得表中最大数据列名
        $column = $sheet->getHighestColumn();
        //获得表中最大数据行名
        $row = $sheet->getHighestRow();
        //循环获得表中数据
        for($i=1;$i<=$row;$i++){
            if($ziduan==2){
                $data[] = array(
                //通过工作表对象的getCell方法获得单元格 getValue方法获得该单元格数值
                    'xuehao'=>$sheet->getCell('A'.$i)->getValue(),
                    'name'=>$sheet->getCell('B'.$i)->getValue(),
                    'xingbie'=>$sheet->getCell('C'.$i)->getValue(),
                    );
            }elseif($ziduan==3){
                $data[] = array(
                //通过工作表对象的getCell方法获得单元格 getValue方法获得该单元格数值
                    'xuehao'=>$sheet->getCell('A'.$i)->getValue(),
                    'name'=>$sheet->getCell('B'.$i)->getValue(),
                    'fenshu'=>$sheet->getCell('C'.$i)->getValue(),
                    );
            }
            
        }
        //释放工作表对象
        unset($sheet);
        //释放读取Excel文件对象
        unset($PHPReader);
        //释放Excel文件对象
        unset($PHPExcel);
        //返回数据
        return array('error'=>0,'data'=>$data);
    }
    // 根据json格式的年级id，获取年级数组
    // 用于报名任务中项目适应年级
    function getNianji($str){
        $nianjiIdList = json_decode($str);

        $nianji = M('nianji')->where(array('id'=>array('IN',$nianjiIdList)))->getField('mingcheng',true);

        return implode('，',$nianji);
    }
    // 根据ID获取年级名称
    function getNianjiName($id){
        return M('nianji')->where(array('id'=>$id))->getField('mingcheng');
    }
    // 报名前端根据报名项目，返回文字提示要求
    function getContent($arr){
        // 报名项目名称
        $mingcheng = $arr['mingcheng'];
        // 检测性别要求0女1男2全部
        switch ($arr['nannv']) {
            case 2:
                $xingbie = '男女均可报';
                break;          
            case 1:
                $xingbie = '男生可报';
                break;
            case 0:
                $xingbie = '女生可报';
                break;
            case 3:
                $xingbie = '无';
                break;
        }

        $renshu = $arr['renshu'];
        $nansheng = $arr['nansheng'];
        $nvsheng = $arr['nvsheng'];
        // 项目类型 1田赛 2径赛 3一般性报名
        switch ($arr['leixing']) {
            case 1:
                $leixing = '田赛';
                break;
            case 2:
                $leixing = '竞赛';
                break;
            case 3:
                $leixing = '一般性报名';
                break;
        }
        // 区分集体项目还是个人项目
        switch ($arr['jiti']) {
            case 0:
                $jiti = '个人项目';
                break;
            
            default:
                $jiti = '集体项目';
                break;
        }
        $str = '项目名称：'.$mingcheng.'；';
        $str = $str.'性别要求：'.$xingbie.'；';
        $str = $str.'可报人数：'.$renshu.'，';
        if($arr['nannv']!=3){
            $str = $str.'男生'.$nansheng.'，女生'.$nvsheng.'；';
        }
        $str = $str.'项目类型：'.$leixing.'，';
        $str = $str.'集体：'.$jiti.'。';
        return $str;

    }

    // 返回格式化数据分页对象
    function getPageObject($count,$per){
        import('ORG.Util.Page');
        
        // $count = M('project')->count();
        
        $page = new Page($count,$per);
        $page->setConfig('theme',"%totalRow% %header% %nowPage%/%totalPage% 页 <li>%upPage%</li> <li>%downPage%</li> <li>%first%</li> <li>%prePage%</li> <li>%linkPage%</li> <li>%nextPage%</li> <li>%end%</li>");

        return $page;
    }

    // 生成ZIP打包文件
    // function toZip($file){
    //     $filename = iconv('utf-8', 'gb2312',__ROOT__.'/Uploads/'.$file);
    //     $zip = new ZipArchive;
    //     if ($zip->open($filename,ZipArchive::OVERWRITE) === TRUE) {
    //         foreach($zipURL as $key=>$value){
    //             $zip->addFile($value,basename($value));
    //         }
    //         $zip->close();
    //         $dabaoURL = __ROOT__.'/Uploads/'.$file;
    //         echo '打包下载报表 <a href='.$dabaoURL.'>点击下载</a>'.'<br>';
    //         ob_flush();
    //         flush();
    //     } else {
    //         echo 'failed';
    //     }
    // }

        /**
* 根据HTML代码获取word文档内容
* 创建一个本质为mht的文档，该函数会分析文件内容并从远程下载页面中的图片资源
* 该函数依赖于类WordMake
* 该函数会分析img标签，提取src的属性值。但是，src的属性值必须被引号包围，否则不能提取
*
* @param string $content HTML内容
* @param string $absolutePath 网页的绝对路径。如果HTML内容里的图片路径为相对路径，那么就需要填写这个参数，来让该函数自动填补成绝对路径。这个参数最后需要以/结束
* @param bool $isEraseLink 是否去掉HTML内容中的链接
*/
function WordMake( $content , $absolutePath = "" , $isEraseLink = true )
{
    import("Class.Wordmaker",APP_PATH);
    $mht = new Wordmaker();
    if ($isEraseLink){
        $content = preg_replace('/<a\s*.*?\s*>(\s*.*?\s*)<\/a>/i' , '$1' , $content);   //去掉链接
    }
    $images = array();
    $files = array();
    $matches = array();
    //这个算法要求src后的属性值必须使用引号括起来
    if ( preg_match_all('/<img[.\n]*?src\s*?=\s*?[\"\'](.*?)[\"\'](.*?)\/>/i',$content ,$matches ) ){
        $arrPath = $matches[1];
        for ( $i=0;$i<count($arrPath);$i++)
        {
            $path = $arrPath[$i];
            $imgPath = trim( $path );
            if ( $imgPath != "" )
            {
                $files[] = $imgPath;
                if( substr($imgPath,0,7) == 'http://')
                {
                    //绝对链接，不加前缀
                }
                else
                {
                    $imgPath = $absolutePath.$imgPath;
                }
                $images[] = $imgPath;
            }
        }
    }
    $mht->AddContents("tmp.html",$mht->GetMimeType("tmp.html"),$content);
    for ( $i=0;$i<count($images);$i++)
    {
        $image = $images[$i];
        if ( @fopen($image , 'r') )
        {
            $imgcontent = @file_get_contents( $image );
            if ( $content )
                $mht->AddContents($files[$i],$mht->GetMimeType($image),$imgcontent);
        }
        else
        {
            echo "file:".$image." not exist!<br />";
        }
    }
    return $mht->GetFile();
}
?>