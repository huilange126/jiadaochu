<?php
//学生评优控制器
Class SanhaoAction extends CommonAction{
	//评优项目列表
	function index(){
		 import('ORG.Util.Page');
		 //取得所有规则数量
		 $count = M('sanhaoguize')->count();
		 //实例化分页类
		 $page = new Page($count,3);
		 $page->setConfig('theme',"%totalRow% %header% %nowPage%/%totalPage% 页 <li>%upPage%</li> <li>%downPage%</li> <li>%first%</li> <li>%prePage%</li> <li>%linkPage%</li> <li>%nextPage%</li> <li>%end%</li>");
		 
		 $guize = D('Sanhaoguize')->getPageData($page->firstRow,$page->listRows);
		 //分析评优规则
		 foreach ($guize as $key => $value) {
		 	$guize[$key] = $this->fenxi($value);
		 }
		 //由于前台要一行显示，组合一下规则
		 foreach($guize as $key => $value){
		 	$yaoqiu = array();
		 	//组合成绩要求
		 	if($value['xuekefenshu']!='0'){
		 		foreach($value['xuekefenshu'] as $subkey => $subvalue){
		 			$value['xuekefenshu'][$subkey] = $subvalue['xueke'].':'.$subvalue['fenshu'];
		 		}
		 		$yaoqiu[] = array(
		 			'title'=>'成绩要求',
		 			'message'=>implode(',',$value['xuekefenshu']),
		 			);
		 	}
		 	//组合人数
		 	if($value['renshu']!=0){
		 		$yaoqiu[] = array(
		 			'title'=>'人数',
		 			'message'=>$value['renshu'],
		 			);
		 	}
		 	//组合比例
		 	if($value['bili']!=0){
		 		$yaoqiu[] = array(
		 			'title'=>'比例',
		 			'message'=>$value['bili'].'%',
		 			);
		 	}
		 	//组合继承
		 	if($value['jicheng']!='0'){
		 		$yaoqiu[] = array(
		 			'title'=>'从该项目中选取',
		 			'message'=>$value['jicheng']['mingcheng'],
		 			);
		 	}
		 	//组合排除
		 	if($value['paichu']!='0'){
		 		$message = '';
		 		foreach($value['paichu'] as $paichuValue){
		 			$message = $message==''?$paichuValue['mingcheng']:$message.'，'.$paichuValue['mingcheng'];
		 		}
		 		$yaoqiu[] = array(
		 			'title'=>'不能兼报',
		 			'message'=>$message,
		 			);
		 	}
		 	$guize[$key]['yaoqiu'] = $yaoqiu;
		 }
		 $data = array(
		 	'guize'=>$guize,
		 	'show'=>$page->show(),
		 	);
		 // p($data);die;
		 $this->assign($data);

		 $this->display();

	}
	//编辑评优规则
	function edit(){

		$id = I('id',0,'intval');
		//读取编辑规则
		$guize = M('sanhaoguize')->find($id);

		if(!$guize){
			$this->error('规则不存在');
		}

		$guize = $this->fenxi($guize);
		//读取年级列表
		$nianji = M('nianji')->select();
		//读取学科列表
		$xueke = M('xueke')->select();
		//循环遍历成绩要求，并给各个学科设定分数
		if($guize['xuekefenshu']!='0'){
			//load('extend');
			foreach($guize['xuekefenshu'] as $key => $value){
				//循环遍历是否该学科有成绩要求
				foreach($xueke as $xkkey=>$xkvalue){
					if($xkvalue['id']==$value['xuekeid']){
						$xueke[$xkkey]['fenshu'] = $value['fenshu'];
						break;
					}
				}
			}
		}
		//排除项目ID组合
		if($guize['paichu']!='0'){
			$paichu = array();
			foreach($guize['paichu'] as $value){
				$paichu[] = $value['id'];
			}

			$guize['paichu'] = $paichu;
		}
		$allGuize = M('sanhaoguize')->select();
		$data = array(
			'guize'=>$guize,
			'nianji'=>$nianji,
			'xueke'=>$xueke,
			'sanhaoguize'=>$allGuize,
			);

		$this->assign($data);

		$this->display();
	}

	//分析评优规则函数
	function fenxi($guize){
		//如果学科分数不为0，表示对学科分数有要求
		if($guize['xuekefenshu']!='0'){
			$xuekefenshu = array();
			foreach (json_decode($guize['xuekefenshu']) as $xkkey => $xkvalue) {
				$xuekefenshu[] = array(
					'xuekeid'=>$xkvalue->xuekeid,
					'xueke'=>M('xueke')->where(array('id'=>$xkvalue->xuekeid))->getField('xueke'),
					'fenshu'=>$xkvalue->chengjiyaoqiu,
					);
			}
			$guize['xuekefenshu'] = $xuekefenshu;
		}
		 //继承规则
		if($guize['jicheng']!=0){
			$guize['jicheng'] = array(
				'mingcheng'=>D('Sanhaoguize')->getName($guize['jicheng']),
				'id'=>$guize['jicheng'],
				);
		}
		 //排除规则
		if($guize['paichu']!='0'){
			$paichu = array();
			foreach (explode(',',$guize['paichu']) as $pckey => $pcvalue) {
				$paichu[] = array(
					'mingcheng'=>D('Sanhaoguize')->getName($pcvalue),
					'id'=>$pcvalue,
					);
			}
			$guize['paichu'] = $paichu;
		}
		 //子分类
		if($guize['zifenlei']!='0'){
			$guize['zifenlei'] = json_decode($guize['zifenlei']);
		}

		return $guize;

	}
	//添加评优项目
	function add(){
		//学科数组
		$xueke = M('xueke')->select();
		//年级数组
		$nianji = M('nianji')->select();
		//评优规则
		$sanhaoguize = M('sanhaoguize')->select();


		$data = array(
			'xueke'=>$xueke,
			'nianji'=>$nianji,
			'sanhaoguize'=>$sanhaoguize,
			);

		$this->assign($data);

		$this->display();
	}

	//添加评优项目处理
	function addHandle(){

		$mingcheng = $this->_param('mingcheng');
		// 名称非空判断
		if(empty($mingcheng)) $this->error('请填写评优名称');
		$nianji = $this->_param('nianji');
		// 年级非空判断
		if(empty($nianji)) $this->error('请选择年级');
		$xueke = $this->_param('xueke');
		if(empty($xueke)){
			$xuekeguize = 0;
		}else{
			//组合学科及学科分数为数组，用于转化为JSON数据，位于数据库
			foreach($xueke as $key=>$value){

				$chengjiyaoqiu = $this->_param('fenshu'.$value);

				$xuekeguize[] = array(
					'xuekeid'=>$value,
					'chengjiyaoqiu'=>$chengjiyaoqiu,
					);
			}
			$xuekeguize = json_encode($xuekeguize);
		}
		

		if($this->_param('checkpaichu')==1){
			$paichu = implode(',',$this->_param('selectpaichu'));
		}else{
			$paichu = 0;
		}
		if($this->_param('checkjicheng')==1){
			$jicheng = $this->_param('selectjicheng');
		}else{
			$jicheng = 0;
		}
		if($this->_param('checkrenshu')==1){
			$renshu = $this->_param('txtrenshu');
		}else{
			$renshu = 0;
		}
		if($this->_param('checkbili')==1){
			$bili = $this->_param('txtbili');
		}else{
			$bili = 0;
		}

		if($this->_param('checkzifenlei')==1){
			//echo $_POST['fenlei'];
			$zifenlei = json_encode(explode("\r\n", $_POST['fenfei']));
		}else{
			$zifenlei = 0;
		}

		$data = array(
			'mingcheng'=>$mingcheng,
			'nianji'=>$nianji,
			'xuekefenshu'=>$xuekeguize,
			'renshu'=>$renshu,
			'bili'=>$bili,
			'paichu'=>$paichu,
			'jicheng'=>$jicheng,
			'zifenlei'=>$zifenlei,
			);
		//表示是更新操作
		$id = I('id',0,'intval');
		if($id!=0){
			if(M('sanhaoguize')->where(array('id'=>$id))->save($data)){
				$this->success('规则更新成功',U(GROUP_NAME.'/Sanhao/edit',array('id'=>$id)));
			}else{
				$this->error('规则更新失败');
			}
		}else{
			if(M('sanhaoguize')->add($data)){
				$this->success('规则添加成功');
			}else{
				$this->error('规则添加失败');
			}
		}
	}


	// 评优结果列表
	function termList(){

		// 学期数量

		$term = M('term')->where(array('status'=>1))->find();

		$nianji = M('nianji')->select();

		// 临时增加查询其他学年的评优结果
		$allRuXueNian = array(2014,2015);

		$data = array(
			'term'=>$term,
			'nianji'=>$nianji,
			// 临时增加
			'past'=>$allRuXueNian,
			);

		$this->assign($data);

		$this->display();
	}
	// 显示评优结果
	function result(){
		// 当前学期
		$term = M('term')->where(array('status'=>1))->find();
		// 年级ID
		$nianjiId = I('nianji',0,'intval');
		// 获得该年级
		$nianji = M('nianji')->find($nianjiId);
		// 根据年级获取班级
		$banji = M('banji')->where(array('ruxuenian'=>$nianji['ruxuenian']))->select();
		// 根据年级获取评优项目
		$xiangmu = M('sanhaoguize')->where(array('nianji'=>$nianji['id']))->select();
		// 循环班级 读取评优结果
		foreach($banji as $key=>$value){
			$condition = array(
				'banjiid'=>$value['id'],
				'termid'=>$term['id'],
				// 'termid'=>6,
				);
			$result[] = array(
				'banji'=>$value,
				'result'=>D('SanhaoRelation')->relation('student')->where($condition)->select(),
				);
		}
		// 根据该年级评优项目 重新组织项目数组
		foreach($xiangmu as $key=>$value){
			$xiangmuTemp[$value['id']] = array(
				'id'=>$value['id'],
				'mingcheng'=>$value['mingcheng'],
				);
			if($value['zifenlei']=='0'){
				$xiangmuTemp[$value['id']]['zifenlei'] = 0;
			}else{
				$xiangmuTemp[$value['id']]['zifenlei'] = json_decode($value['zifenlei']);
			}
		}
		// 重新赋值项目
		$xiangmu = $xiangmuTemp;
		// 循环班级结果数据 重新组织数组
		foreach($result as $key=>$value){
			// 循环学生数据
			$studentTemp = $xiangmu;
			foreach($value['result'] as $mkey=>$mvalue){

				$studentTemp[$mvalue['sanhaoid']]['student'][] = $mvalue;
				
			}
			$resultTemp[] = array(
					'banji'=>$value['banji'],
					'student'=>$studentTemp,
					);
		}
		
		$data = array(
			'xiangmu'=>$xiangmu,
			'result'=>$resultTemp,
			);

		$type = I('type',0,'intval');
		switch ($type) {
			// 导出级部评优情况至WORD
			case 1:
				$file = './Uploads/'.$this->toWord($data);
				import('ORG.Net.Http');
				Http::download($file);
				break;
			// 导出级部评优情况至EXCEL
			case 2:
				// p($data);
				// 循环遍历各个班级
				foreach($data['result'] as $key=>$value){
					$nianji = $value['banji']['ruxuenian'];
					$banji = $value['banji']['ruxuenian'].'级'.$value['banji']['banji'].'班';
					// 循环遍历班级项目
					foreach($value['student'] as $mkey=>$mvalue){
						// 项目名称
						$xiangmu = $mvalue['mingcheng'];
						// 循环遍历项目中学生
						if($mvalue['zifenlei']==0){
							// 如果没有子分类
							foreach($mvalue['student'] as $nkey=>$nvalue){
								$excelData[] = array(
									'banji'=>$banji,
									'xuehao'=>$nvalue['xuehao'],
									'xingming'=>$nvalue['name'],
									'jiangxiang'=>$xiangmu,
									);
							}
						}else{
							// 如果有子分类
							$zifenlei = $mvalue['zifenlei'];
							foreach($mvalue['student'] as $nkey=>$nvalue){
								$excelData[] = array(
									'banji'=>$banji,
									'xuehao'=>$nvalue['xuehao'],
									'xingming'=>$nvalue['name'],
									'jiangxiang'=>$xiangmu,
									'zifenlei'=>$zifenlei[$nvalue['zifenleiid']-1],
									);
							}
						}
						
						 
					}
				}
				$arrHeader = array('班级','学号','姓名','奖项','分类');
				$fileName = $nianji.'级评优结果';
				getExcel($fileName,$arrHeader,$excelData);
				break;
			// 在线显示级部报名情况
			default:
				$this->assign($data);
				$this->display();
				break;
		}
			
	}
	// 临时显示过去评优结果
	function resultPast(){
		// 当前学期
		$term = M('term')->where(array('status'=>1))->find();
		// 年级ID
		$nianjiId = I('nianji',0,'intval');
		// 获得该年级
		$nianji = I('ruxuenian');
		// 根据年级获取班级
		$banji = M('banji')->where(array('ruxuenian'=>$nianji))->select();
		// 根据年级获取评优项目
		$xiangmu = M('sanhaoguize')->where(array('nianji'=>$nianjiId))->select();
		// 循环班级 读取评优结果
		foreach($banji as $key=>$value){
			$condition = array(
				'banjiid'=>$value['id'],
				// 'termid'=>$term['id'],
				'termid'=>6,
				);
			$result[] = array(
				'banji'=>$value,
				'result'=>D('SanhaoRelation')->relation('student')->where($condition)->select(),
				);
		}
		// 根据该年级评优项目 重新组织项目数组
		foreach($xiangmu as $key=>$value){
			$xiangmuTemp[$value['id']] = array(
				'id'=>$value['id'],
				'mingcheng'=>$value['mingcheng'],
				);
			if($value['zifenlei']=='0'){
				$xiangmuTemp[$value['id']]['zifenlei'] = 0;
			}else{
				$xiangmuTemp[$value['id']]['zifenlei'] = json_decode($value['zifenlei']);
			}
		}
		// 重新赋值项目
		$xiangmu = $xiangmuTemp;
		// 循环班级结果数据 重新组织数组
		foreach($result as $key=>$value){
			// 循环学生数据
			$studentTemp = $xiangmu;
			foreach($value['result'] as $mkey=>$mvalue){

				$studentTemp[$mvalue['sanhaoid']]['student'][] = $mvalue;
				
			}
			$resultTemp[] = array(
					'banji'=>$value['banji'],
					'student'=>$studentTemp,
					);
		}
		
		$data = array(
			'xiangmu'=>$xiangmu,
			'result'=>$resultTemp,
			);

		$type = I('type',0,'intval');
		switch ($type) {
			// 导出级部评优情况至WORD
			case 1:
				$file = './Uploads/'.$this->toWord($data);
				import('ORG.Net.Http');
				Http::download($file);
				break;
			// 导出级部评优情况至EXCEL
			case 2:
				// p($data);
				// 循环遍历各个班级
				foreach($data['result'] as $key=>$value){
					$nianji = $value['banji']['ruxuenian'];
					$banji = $value['banji']['ruxuenian'].'级'.$value['banji']['banji'].'班';
					// 循环遍历班级项目
					foreach($value['student'] as $mkey=>$mvalue){
						// 项目名称
						$xiangmu = $mvalue['mingcheng'];
						// 循环遍历项目中学生
						if($mvalue['zifenlei']==0){
							// 如果没有子分类
							foreach($mvalue['student'] as $nkey=>$nvalue){
								$excelData[] = array(
									'banji'=>$banji,
									'xuehao'=>$nvalue['xuehao'],
									'xingming'=>$nvalue['name'],
									'jiangxiang'=>$xiangmu,
									);
							}
						}else{
							// 如果有子分类
							$zifenlei = $mvalue['zifenlei'];
							foreach($mvalue['student'] as $nkey=>$nvalue){
								$excelData[] = array(
									'banji'=>$banji,
									'xuehao'=>$nvalue['xuehao'],
									'xingming'=>$nvalue['name'],
									'jiangxiang'=>$xiangmu,
									'zifenlei'=>$zifenlei[$nvalue['zifenleiid']-1],
									);
							}
						}
						
						 
					}
				}
				$arrHeader = array('班级','学号','姓名','奖项','分类');
				$fileName = $nianji.'级评优结果';
				getExcel($fileName,$arrHeader,$excelData);
				break;
			// 在线显示级部报名情况
			default:
				$this->assign($data);
				$this->display('result');
				break;
		}
			
	}
	// 生成word报表
	protected function toWord($data){
		vendor('PHPWord.PHPWord');

		$PHPWord = new PHPWord();

		$section = $PHPWord->createSection();

		// 定义标题文字样式
		$titleFontStyle = array('bold'=>true,'name'=>'隶书','size'=>16, 'color'=>'006699');
		$titleParagraphStyle = array('align'=>'center', 'spaceAfter'=>100);

		// $section->addText('选修课报表',$titleFontStyle,$titleParagraphStyle);
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

		// 报表标题
		$section->addText("评优结果列表",$titleFontStyle,$titleParagraphStyle);

		foreach($data['result'] as $key=>$value){

			
			foreach($value['student'] as $mkey=>$mvalue){
				$section->addText($value['banji']['ruxuenian'].'级'.$value['banji']['banji'].'班'.$mvalue['mingcheng'], $fontStyle);
				// 添加表格
				$table = $section->addTable('myOwnTableStyle');
				// 添加第一行
				// $table->addRow(500);
				// 添加单元格
				// $table->addCell(9000, $styleCell)->addText($value['banji']['ruxuenian'].'级'.$value['banji']['banji'].'班'.$mvalue['mingcheng'], $fontStyle);
				
				// 该评优中的学生结果
				$student = $mvalue['student'];
				$studentCount = count($student);
				// 如果是不带子分类则显示8格
				if($mvalue['zifenlei']==0){
					if($studentCount%8==0){
						$rowCount = $studentCount/8;
					}else{
						$rowCount = floor($studentCount/8)+1;
					}

					for($i=0;$i<$rowCount;$i++){
					// 添加一行
						$table->addRow();
						for($j=0;$j<8;$j++){
							$studentKey = $i*8+$j;
							$cell = $table->addCell(1125);
							$cell->addText($mvalue['student'][$studentKey]['xuehao'],'',$paragraphStyle);
							$cell->addText($mvalue['student'][$studentKey]['name'],'',$paragraphStyle);
						}

					}
				}else{
					// 如果有子分类 则显示4格
					if($studentCount%4==0){
						$rowCount = $studentCount/4;
					}else{
						$rowCount = floor($studentCount/4)+1;
					}

					for($i=0;$i<$rowCount;$i++){
					// 添加一行
						$table->addRow();
						for($j=0;$j<4;$j++){
							$studentKey = $i*4+$j;
							$cell = $table->addCell(2250);
							$cell->addText($mvalue['student'][$studentKey]['xuehao'],'',$paragraphStyle);
							$cell->addText($mvalue['student'][$studentKey]['name'],'',$paragraphStyle);
							$cell->addText($mvalue['zifenlei'][$mvalue['student'][$studentKey]['zifenleiid']-1],'',$paragraphStyle);
						}

					}
				}

				$section->addText('');
			}
			$section->addPageBreak();
		}

		$savePath = date('Ym',time());
		// 检查上传目录
        $this->checkSavePath('./Uploads/'.$savePath);
		$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
		$fileName = '评优结果'.'('.date('Y-m-d',time()).')'.'.docx';
		$fileName  = iconv("utf-8","gb2312",$fileName );
		$objWriter->save('./Uploads/'.$savePath.'/'.$fileName);
		return $savePath.'/'.$fileName;

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
}