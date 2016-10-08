<?php
//学生成绩管理控制器
Class ChengjiAction extends CommonAction{
	//搜索学生页面
	function index(){

        if(IS_POST){
          $keywords = I('keywords');
          
          $student = D('Student')->getStudent($keywords); 

          $data = array(
            'student'=>$student,
            );

          $this->assign($data);
        }
        $this->display();
		
	}
    //学生成绩列表页面
    function termlist(){

        $id = I('id');
        //返回有学生成绩学期
        $termIdList = D('Chengji')->getStudentCjTermList($id);
        //根据学期id获取学期
        $termList = M('term')->where(array('id'=>array('IN',$termIdList)))->select();
        //根据学生id及学期id获取该学生各个学期成绩
        foreach($termList as $key=>$value){
            // $condition = array(
            //     'termid'=>$value['id'],
            //     'xueshengid'=>$id,
            //     );
            // $termList[$key]['chengji'] = D('ChengjiRelation')->relation(true)->where($condition)->select();
            
            $termList[$key]['chengji'] = D('Chengji')->getChengji($value['id'],$id);

        }
        //学生信息
        $student = M('student')->find($id);
        $data = array(
            'termlist'=>$termList,
            'student'=>$student,
            );
        //p($data);die;
        $this->assign($data);

        $this->display();
    }
    //编辑成绩页面
    function edit(){
        //获取学生ID
        $studentid = I('studentid',0,'intval');
        //获取学生信息
        $student = M('student')->find($studentid);
        //获得学期ID
        $termid = I('termid',0,'intval');
        //获得学期信息
        $term = M('term')->find($termid);

        $chengji = D('Chengji')->getChengji($term['id'],$student['id']);

        $data = array(
            'student'=>$student,
            'term'=>$term,
            'chengji'=>$chengji,
            );
        //p($data);die;
        $this->assign($data);
        $this->display();

    }
    //修改成绩处理页面
    function editHandle(){

        $term = I('term');

        $student = I('xuehao');

        $chengji = $_POST['xueke'];
        
        //成绩有效性验证
        $isChengjiOk = true;
        foreach($chengji as $key=>$value){
            if(!is_numeric($value)){
                $isChengjiOk = false;
                break;
            }
            if($value<0||$value>999){//此处学科分值极限，应考虑放到配置文件中，进行动态配置
                $isChengjiOk = false;
                break;
            }
        }

        if(!$isChengjiOk){
            $this->error('成绩应该为数字,或者成绩范围有误，请检查一下');
        }

        //数据无误之后进行更新操作
        //先删除该xueshengid的该termid的所有成绩，然后重新插入
        if(M('chengji')->where(array('termid'=>$term,'xueshengid'=>$student))->delete()){
            foreach($chengji as $key=>$value){
                $data[] = array(
                    'termid'=>$term,
                    'xueshengid'=>$student,
                    'xuekeid'=>$key,
                    'fenshu'=>$value,
                    );
            }
            M('chengji')->addAll($data);
            $this->success('成绩修改成功',U(GROUP_NAME.'/Chengji/edit',array('termid'=>$term,'studentid'=>$student)));
        }else{
            $this->error(M('chengji')->getDbError());
        }



    }

	//成绩导入页面
	function daoru(){

		$xueke = M('xueke')->select();

		$term = M('term')->where(array('status=1'))->find();

		$data = array(
			'xueke'=>$xueke,
			'term'=>$term,
			);

		$this->assign($data);

		$this->display();
	}
	//导入成绩处理
	function daoruHandle(){

		if(!IS_POST) $this->error('页面不存在');

		if($this->_param('xueke')==0){
			$this->error('请选择学科');
		}
		$xuekeid = $this->_param('xueke');
		//Excel文件上传及输入读取导入开始
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
        
        $data = excel_to_mysql($file,3);
        //Excel文件上传及输入读取导入结束
        $student = $data['data'];

        $term = M('term')->where(array('status=1'))->find();
        //是否可以导入数据库标识
        $isok = true;
        foreach($student as $key=>$value){
        	//要求学号必须是唯一的
        	$theone = M('student')->where(array('xuehao'=>$value['xuehao']))->find();
        	//统计没有学籍的学生
        	if(empty($theone)){
        		$isok = false;
        		$wuxuehao[] = array(
        			'xuehao'=>$value['xuehao'],
        			'xingming'=>$value['name']
        			);
        	}
        	$chengji[] = array(
        			'xueshengid'=>$theone['id'],
        			'xuehao'=>$value['xuehao'],
        			'termid'=>$term['id'],
        			'xuekeid'=>$xuekeid,
        			'fenshu'=>$value['fenshu'],
        		);
        }
        //判断是否可以导入数据库
        if($isok==true){
        	if(M('chengji')->addAll($chengji)){
        		$this->success('成绩导入成功');
        	}else{
        		$this->error(M('chengji')->getDbError());
        	}
        }else{//如果不能导入则显示错误学生信息
        	$this->assign('wuxuehao',$wuxuehao);
        	$this->display('wuxuehao');
        }
	}
}