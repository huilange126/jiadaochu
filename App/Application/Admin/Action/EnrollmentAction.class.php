<?php
//报名任务后台控制器
Class EnrollmentAction extends CommonAction{


	//报名任务列表
	function index(){
		
		$count = M('enrollment')->count();

		//如果是POST提交，表明是搜索过来的
		if(IS_POST){
			$keywords = I('keywords',0,'htmlspecialchars');
			//p($keywords);die;
			$condition = array(
				'mingcheng'=>array('LIKE','%'.$keywords.'%')
				);
			$enrollment = D('Enrollment')->getEnrollment($condition);
			//echo D('Enrollment')->getLastSql();die;
			$data = array(
				'enrollment'=>$enrollment,
				'num'=>0,
				);

		}else{
			import('ORG.Util.Page');
			$page = new Page($count,10);
			$page->setConfig('theme',"%totalRow% %header% %nowPage%/%totalPage% 页 <li>%upPage%</li> <li>%downPage%</li> <li>%first%</li> <li>%prePage%</li> <li>%linkPage%</li> <li>%nextPage%</li> <li>%end%</li>");

			$condition = "1=1";
			$enrollment = D('Enrollment')->getEnrollment($condition,$page->firstRow,$page->listRows);

			$data = array(
				'enrollment'=>$enrollment,
				'show'=>$page->show(),
				'num'=>$page->firstRow,
				);
		}
		$this->assign($data);
		$this->display();


	}
	//添加报名任务
	//限定每个学生限制报几个项目 应该在任务中设置
	//报名任务适应那几个年级也应该在这里设置
	function add(){

		$nianji = M('nianji')->select();

		$data = array(
			'nianji'=>$nianji,
			);

		$this->assign($data);

		$this->display();
	}
	//添加报名任务处理
	function addHandle(){

		$mingcheng = I('txtMingcheng','htmlspecialchars');
		if($mingcheng=='') $this->error('任务名称不能为空');
		// $nianji = $_POST['chkNianji'];

		$nianji = I('chkNianji');
		$xianzhi = I('selNum');

		if(I('txtStart')=='')$this->error('开始日期不能为空');
		$start = strtotime(I('txtStart'));

		if(I('txtEnd')=='')$this->error('截止日期不能为空');
		$end = strtotime(I('txtEnd'));

		$status = I('status',0,'intval');

		$data = array(
			'mingcheng'=>$mingcheng,
			'renshu'=>$xianzhi,
			'start'=>$start,
			'end'=>$end,
			'status'=>$status,
			);

		$model = M();
		$model->startTrans();

		if(!$enrollment=M('Enrollment')->add($data)){
			$this->error('任务添加失败请重新尝试');
		}
		$status = true;
		foreach($nianji as $key => $value){
			$data = array(
				'enrollment_id'=>$enrollment,
				'nianji_id'=>$value
				);
			if(!M('enrollment_nianji')->add($data)){
			//表示插入数据错误
				$status = false;
				break;
			}
		}
		if($status==true){
			$model->commit();
			$this->success('任务添加成功');
		}else{
			$model->rollback();
			$this->error('任务添加失败，请重新尝试');
		}

	}
	//编辑报名任务
	function edit(){
		$id = I('id',0,'intval');

		$enrollment = D('EnrollmentRelation')->relation(true)->find($id);
		if(!$enrollment) $this->error('没有找到相关报名任务');
		//将年级数组处理成为年级id数组
		foreach($enrollment['nianji'] as $value){
			$nianji[] = $value['id'];
		}
		$enrollment['nianji'] = $nianji;

		//取得年级
		$nianji = M('nianji')->select();

		$data = array(
			'enrollment'=>$enrollment,
			'nianji'=>$nianji,
			);

		$this->assign($data);

		$this->display();
	}
	//编辑任务处理
	function editHandle(){
		$mingcheng = I('txtMingcheng','htmlspecialchars');
		if($mingcheng=='') $this->error('任务名称不能为空');
		// $nianji = $_POST['chkNianji'];

		$nianji = I('chkNianji');
		$xianzhi = I('selNum');

		if(I('txtStart')=='')$this->error('开始日期不能为空');
		$start = strtotime(I('txtStart'));

		if(I('txtEnd')=='')$this->error('截止日期不能为空');
		$end = strtotime(I('txtEnd'));

		$status = I('status',0,'intval');

		$data = array(
			'mingcheng'=>$mingcheng,
			'renshu'=>$xianzhi,
			'start'=>$start,
			'end'=>$end,
			'status'=>$status,
			);

		$id = I('id');
		//事务开始
		$model = M();
		$model->startTrans();
		if(!M('enrollment')->where(array('id'=>$id))->save($data)){
			$this->error('更新失败，请重新尝试');
		}

		if(!M('enrollment_nianji')->where(array('enrollment_id'=>$id))->delete()){
			//如果删除失败，则需要回滚
			$model->rollback();
			$this->error('更新失败，请重新尝试');
		}
		$status = true;
		foreach($nianji as $key => $value){
			$data = array(
				'enrollment_id'=>$id,
				'nianji_id'=>$value,
				);
			if(!M('enrollment_nianji')->add($data)){
				$status = false;
				break;
			}
		}

		if($status){
			$model->commit();
			$this->success('更新成功',U(GROUP_NAME.'/Enrollment/edit',array('id'=>$id)));
		}else{
			$model->rollback();
			$this->error('更新失败，请重新尝试');
		}
	}
	// 报名任务详细内容查看
	function detail(){
		$id = I('id',0,'intval');
		$enrollment = D('EnrollmentRelation')->relation(true)->find($id);
		if(!$enrollment) $this->error('没有找到相关报名任务');

		//p($enrollment);
		$data = array(
			'enrollment'=>$enrollment,
			);
		// p($data);die;
		$this->assign($data);
		$this->display();
	}
	//删除报名任务
	// 删除报名任务 1删除任务 2删除下面的项目 3删除项目下的报名学生
	function del(){
		echo 'del ';
	}

	// 查看报名情况
	function Chakan(){
		// 获得报名任务ID
		$id = I('id',0,'intval');
		// 获得当前学期id
		$tid = M('term')->where(array('status'=>1))->getField('id');

		$enrollment = D('EnrollmentRelation')->relation(true)->find($id);
		// 将项目中的年级JSON数据转化为数组
		foreach($enrollment['content'] as $key=>$value){
			$enrollment['content'][$key]['nianji'] = json_decode($value['nianji']);
		}

		// 按照级部分配项目
		foreach($enrollment['nianji'] as $key=>$value){
			// 清空临时项目
			$xiangmuTemp = '';
			$jibuTemp = array(
				'id'=>$value['id'],
				'ruxuenian'=>$value['ruxuenian'],
				'mingcheng'=>$value['mingcheng']
				);
			// 读取该年级所属班级ID列表
			$jibuTemp['banji'] = M('banji')->where(array('ruxuenian'=>$value['ruxuenian']))->getField('id',true);
			foreach($enrollment['content'] as $ckey=>$cvalue){
				// 检测该年级是否含有该项目
				if(in_array($jibuTemp['id'],$cvalue['nianji'])){
					// 报名该项目的 该年级 当前学期 的学生 ID
					$studentIdList = M('enrollment_list')->where(array('bid'=>array('IN',$jibuTemp['banji']),'cid'=>$cvalue['id'],'eid'=>$enrollment['id'],'tid'=>$tid))->getField('sid',true); 
					// 根据学生ID列表读取学生信息
					$student = M('student')->where(array('id'=>array('IN',$studentIdList)))->select();
					$cvalue['student'] = $student;
					$xiangmuTemp[] = $cvalue;
					// 读取该项目的年级的报名学生

				}
			}
			$jibuTemp['xiangmu'] = $xiangmuTemp;
			$jibu[] = $jibuTemp;
		}
		// p($jibu);die;
		// 循环级部数据 查看是否有分组项目
		foreach($jibu as $key=>$value){
			// 如果有的话，则需要将该项目剔除掉，合并在分组项目中
			$fenzuContent = '';
			foreach($value['xiangmu'] as $xkey=>$xvalue){
				if($xvalue['fenzu']!=0){
					if($fenzuContent[$xvalue['fenzu']]==''){
						$hebing = M('enrollment_hebing')->find($xvalue['fenzu']);
						$fenzuContent[$xvalue['fenzu']]['mingcheng'] = $hebing['mingcheng'];
						$fenzuContent[$xvalue['fenzu']]['jiti'] = $xvalue['jiti'];
						$fenzuContent[$xvalue['fenzu']]['fenzu'] = $xvalue['fenzu'];
					}
					// 合并分组项目数组
					$fenzuContent[$xvalue['fenzu']]['content'][] = $xvalue;
					// 剔除有分组项目
					unset($jibu[$key]['xiangmu'][$xkey]);
				}
			}
			// 将合并分组追加至级部数据中
			$jibu[$key]['xiangmu'][] = $fenzuContent[$hebing['id']];
		}
		// 循环级部数据 查看是否是集体项目 
		foreach($jibu as $key=>$value){
			// 如果是集体项目则需要 将该项目中学生按照班级进行拆分
			foreach($value['xiangmu'] as $jitiKey=>$jitiValue){
				$student = array();
				if($jitiValue['jiti']==1){
					if($jitiValue['fenzu']==0){
						// 表示该项目是集体项目但没有分组
						foreach($jitiValue['student'] as $mkey=>$mvalue){
						// $student[$mvalue['bid']][] = $mvalue; 
							if(array_key_exists($mvalue['bid'],$student)){
								// 检测该班级是否存在
								$student[$mvalue['bid']]['student'][] = $mvalue; 
							}else{
							// 不存在情况
								$student[$mvalue['bid']]['banji']=M('banji')->find($mvalue['bid']);
								$student[$mvalue['bid']]['student'][] = $mvalue; 
							}
						}

						// 重新分配学生
						$jibu[$key]['xiangmu'][$jitiKey]['student'] = $student;
					}else{
						// 表示该项目是集体项目并且有分组
						foreach($jitiValue['content'] as $mkey=>$mvalue){
							$student = array();
							foreach($mvalue['student'] as $nkey=>$nvalue){
								if(array_key_exists($nvalue['bid'],$student)){
									// 检测该班级是否存在
									$student[$nvalue['bid']]['student'][] = $nvalue; 
								}else{
									// 不存在情况
									$student[$nvalue['bid']]['banji']=M('banji')->find($nvalue['bid']);
									$student[$nvalue['bid']]['student'][] = $nvalue; 
								}
							}
							// 重新分配学生
							$jibu[$key]['xiangmu'][$jitiKey]['content'][$mkey]['student'] = $student;
						}
						
					}
				}
				
			}
		}
		// p($jibu);die;
		$type = I('type',0,'intval');

		switch ($type) {
				case 0:
					$baobiao = 'putong';
					// 生成Word文件
					$file = $this->toWord($jibu);
					break;
				case 1:
					$baobiao = 'yundonghui';
					$data = $this->toWordSport($jibu);
					$file['zhixuce'] = $data['file'];
					$jianluce = $data['jianluce'];
					$jianluceTiansai = $data['tiansaiJianluce'];
					// $fileName  = iconv("utf-8","gb2312",$fileName )
					$file['jingsai'] = $this->jianludan($jianluce);
					$file['tiansai'] = $this->jianludan($jianluceTiansai,1);
					break;
				case 2:
					$baobiao = 'quweiyundonghui';
					// 生成Word文件
					$file = $this->toWordQuwei($jibu);
					break;
			}

		$data = array(
			'jibu'=>$jibu,
			'tpye'=>$type,
			'id'=>$id,
			'file'=>$file,
			);

		// p($data);die;
		$this->assign($data);

		$this->display($baobiao);	
	}
	// 选择查看类型
	function chakanType(){
		// 报名任务id
		$id = I('id',0,'intval');
		// type=0表示普通列表类型 1表示运动会类型
		$type = array(
			array(
				'eid'=>$id,
				'type'=>1,
				'title'=>'运动会报表样式',
				),
			array(
				'eid'=>$id,
				'type'=>0,
				'title'=>'普通报表样式（选修课适用）',
				),
			array(
				'eid'=>$id,
				'type'=>2,
				'title'=>'趣味运动会样式(项目分组、集体项目、个人项目相结合)'
				),
			);

		$data = array(
			'type'=>$type,
			);

		$this->assign($data);

		$this->display();
	}
	// 班级报名详情
	function banjiDetail(){
		// 获取报名任务id
		$id = I('id',0,'intval');
		// 读取报名任务
		$enrollment = D('EnrollmentRelation')->relation('nianji')->find($id);
		// p($enrollment);die;
		// 获得该报名任务的年级入学年列表
		foreach($enrollment['nianji'] as $key=>$value){
			$ruxuenian[] = $value['ruxuenian'];
		}
		$condition = array(
			'ruxuenian'=>array(
				'IN',$ruxuenian
				),
			);
		$banji = M('banji')->where($condition)->select();
		// p($banji);die;
		// $student = D('EnrollmentListView')->where(array('bid'=>57))->order('sid ASC')->select();
		$tid = M('term')->where(array('status'=>1))->getField('id');
		// 生成压缩文件内容列表
		$zipURL = array();
		foreach($banji as $key=>$value){
			$data['banji'] = $value;
			// 获取学生信息
			D('StudentRelation')->_link['enrollment']['condition'] = 'a.eid='.$enrollment['id'].' AND a.tid='.$tid;

			$student = D('StudentRelation')->relation(true)->order('xuehao ASC')->where(array('bid'=>$value['id']))->select();
			// echo D('StudentRelation')->getLastSql();die;
			$data['student'] = $student;
			// p($data);
			$file = $this->banjiToWord($data);
			$url = __ROOT__.'/Uploads/'.$file;
			$zipURL[] = './Uploads/'.$file;
			echo $value['username'].'报表生成完毕 <a href="'.$url.'">查看</a>'.'<br>';
			ob_flush();
            flush();
		}
		 
		// // ob_end_clean(); 
		// 生成打包文件
		$filename = iconv('utf-8', 'gb2312','./Uploads/班级报表.zip');
		$zip = new ZipArchive;
		if ($zip->open($filename,ZipArchive::OVERWRITE) === TRUE) {
			foreach($zipURL as $key=>$value){
				$zip->addFile($value,basename($value));
			}
			$zip->close();
			$dabaoURL = __ROOT__.'/Uploads/班级报表.zip';
			echo '打包下载报表 <a href='.$dabaoURL.'>点击下载</a>'.'<br>';
			ob_flush();
            flush();
		} else {
			echo '生成失败，请重新尝试';
		}
		// toZip('班级报表.zip');
		
	}
	// 班级详情生成报表
	protected function banjiToWord($arr){
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
		$section->addText($arr['banji']['username']."报名列表",$titleFontStyle,$titleParagraphStyle);
			
		// 添加表格
		$table = $section->addTable('myOwnTableStyle');
		// 添加第一行
		$table->addRow(500);
		// 添加单元格
		$table->addCell(1000, $styleCell)->addText('序号', $fontStyle,$paragraphStyle);
		$table->addCell(1000, $styleCell)->addText('学号', $fontStyle,$paragraphStyle);
		$table->addCell(1000, $styleCell)->addText('姓名', $fontStyle,$paragraphStyle);
		$table->addCell(6000, $styleCell)->addText('记录', $fontStyle);
		// 循环遍历学生数据
		foreach($arr['student'] as $key=>$value){
			// 清空学生报项目名称
			$allContent = '';
			$table->addRow();
			$table->addCell(1000)->addText($key+1,'',$paragraphStyle);
			$table->addCell(1000)->addText($value['xuehao'],'',$paragraphStyle);
			$table->addCell(1000)->addText($value['name'],'',$paragraphStyle);
			
			foreach($value['enrollment'] as $cKey=>$cValue){
				// 组合学生所报项目名称
				$allContent = ($allContent=='')?$cValue['mingcheng']:$allContent.'  '.$cValue['mingcheng'];
			}

			$table->addCell(6000)->addText($allContent,'',$paragraphStyle);;
		}

		$savePath = date('Ym',time());
		// 检查上传目录
        $this->checkSavePath('./Uploads/'.$savePath);
		$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
		$fileName = $arr['banji']['username'].'('.date('Y-m-d',time()).')'.'.docx';
		$objWriter->save('./Uploads/'.$savePath.'/'.$fileName);
		return $savePath.'/'.$fileName;
	}
	// 导出运动会秩序册及检录册
	function toWordSport($arr){
		vendor('PHPWord.PHPWord');
		$PHPWord = new PHPWord();
		$section = $PHPWord->createSection();
		// 定义标题文字样式
		$titleFontStyle = array('bold'=>true,'name'=>'隶书','size'=>16, 'color'=>'006699');
		$titleParagraphStyle = array('align'=>'center', 'spaceAfter'=>100);
		// 定义表格样式
		$styleTable = array('borderSize'=>6, 'borderColor'=>'006699', 'cellMargin'=>80);
		$styleFirstRow = array('borderBottomSize'=>18, 'borderBottomColor'=>'0000FF', 'bgColor'=>'66BBFF');
		// 定义单元格样式
		$styleCell = array('valign'=>'center');
		$styleCellBTLR = array('valign'=>'center', 'textDirection'=>PHPWord_Style_Cell::TEXT_DIR_BTLR);
		// 定义字体加粗和文字居中样式
		$fontStyle = array('bold'=>true);
		$paragraphStyle = array('align'=>'center');
		// 添加表格样式
		$PHPWord->addTableStyle('myOwnTableStyle', $styleTable);

		$jibu = $arr;
		// p($jibu);die;
		// 循环级部信息
		foreach($jibu as $jibuKey=>$jibuValue){
			// 级部名称
			$jibuName = $jibuValue['mingcheng'];
			$xiangmu = $jibuValue['xiangmu'];
			// 级部总标题
			$section->addText($jibuName,$titleFontStyle,$titleParagraphStyle);
			// 循环项目
			foreach($xiangmu as $xiangmuKey=>$xiangmuValue){
				$theXiangmu = $xiangmuValue;
				// 报名学生
				$student = $theXiangmu['student'];
				// 表示径赛
				if($theXiangmu['leixing']==2){
					// 表示分性别
					if($theXiangmu['nannv']==2){
						// 清空男女数组
						$studentNan = array();
						$studentNv = array();
						if($theXiangmu['jiti']==1){
							// 表示集体项目,则直接班级上
							$allBanji = M('banji')->where('ruxuenian='.$jibuValue['ruxuenian'])->select();
							foreach($allBanji as $allBanjiKey=>$allBanjiValue){
								$jitiStudent = array(
									'name'=>$allBanjiValue['username'],
									);
								$studentNan[] = $jitiStudent;
								$studentNv[] = $jitiStudent;
							}
						}
						if($theXiangmu['jiti']==0){
							// 表示分男女生项目
							foreach($student as $studentKey=>$studentValue){
							// 男女分组
								if($studentValue['xingbie']==1){
									$studentNan[] = $studentValue; 
								}else{
									$studentNv[] = $studentValue;
								}
							}
						}
						
						// 添加表格
						$section->addText(' ',$titleFontStyle,$titleParagraphStyle);
						$section->addText($jibuName.'男子'.$theXiangmu['mingcheng'], $fontStyle,$paragraphStyle);
						$section->addText(' ',$titleFontStyle,$titleParagraphStyle);
						$table = $section->addTable('myOwnTableStyle');
						// 添加第一行
						$table->addRow(500);
						$table->addCell(1000, $styleCell)->addText('组\道次', $fontStyle,$paragraphStyle);
						$table->addCell(1000, $styleCell)->addText('一', $fontStyle,$paragraphStyle);
						$table->addCell(1000, $styleCell)->addText('二', $fontStyle,$paragraphStyle);
						$table->addCell(1000, $styleCell)->addText('三', $fontStyle,$paragraphStyle);
						$table->addCell(1000, $styleCell)->addText('四', $fontStyle,$paragraphStyle);
						$table->addCell(1000, $styleCell)->addText('五', $fontStyle,$paragraphStyle);
						$table->addCell(1000, $styleCell)->addText('六', $fontStyle,$paragraphStyle);
						$table->addCell(1000, $styleCell)->addText('七', $fontStyle,$paragraphStyle);
						$table->addCell(1000, $styleCell)->addText('八', $fontStyle,$paragraphStyle);
						// 男生分组内容
						$studentData = $this->zuhexuesheng($studentNan);
						$studentTemp = $studentData['student'];
						$studentJianlu = $studentData['studentJianlu'];
						// 检录单部分
						$jianludanData[] = array(
							'xiangmu'=>$theXiangmu['mingcheng'],
							'xingbie'=>'男子',
							'nianji'=>$jibuName,
							'student'=>$studentJianlu,
							'zushu'=>count($studentJianlu),
							);
						$zuxuhao = 0;
						foreach($studentTemp as $studentTempKey=>$studentTempValue){
							if(($studentTempKey)%8==0||$studentTempKey==0){
								$zuxuhao++;
								$table->addRow(500);
								$table->addCell(1000, $styleCell)->addText($zuxuhao, $fontStyle,$paragraphStyle);
							}
							$cell = $table->addCell(1000, $styleCell);
							$xuehao = $this->sportNumber($studentTemp[$studentTempKey]['xuehao']);
							$cell->addText($xuehao, $fontStyle,$paragraphStyle);
							$cell->addText($studentTemp[$studentTempKey]['name'], $fontStyle,$paragraphStyle);
						}
						// 生成男生数据结束
						// 添加表格
						$section->addText(' ',$titleFontStyle,$titleParagraphStyle);
						$section->addText($jibuName.'女生'.$theXiangmu['mingcheng'], $fontStyle,$paragraphStyle);
						$section->addText(' ',$titleFontStyle,$titleParagraphStyle);
						$table = $section->addTable('myOwnTableStyle');
						// 添加第一行
						$table->addRow(500);
						$table->addCell(1000, $styleCell)->addText('组\道次', $fontStyle,$paragraphStyle);
						$table->addCell(1000, $styleCell)->addText('一', $fontStyle,$paragraphStyle);
						$table->addCell(1000, $styleCell)->addText('二', $fontStyle,$paragraphStyle);
						$table->addCell(1000, $styleCell)->addText('三', $fontStyle,$paragraphStyle);
						$table->addCell(1000, $styleCell)->addText('四', $fontStyle,$paragraphStyle);
						$table->addCell(1000, $styleCell)->addText('五', $fontStyle,$paragraphStyle);
						$table->addCell(1000, $styleCell)->addText('六', $fontStyle,$paragraphStyle);
						$table->addCell(1000, $styleCell)->addText('七', $fontStyle,$paragraphStyle);
						$table->addCell(1000, $styleCell)->addText('八', $fontStyle,$paragraphStyle);
						// 女生分组内容
						// 生成女生数据开始
						$studentData = $this->zuhexuesheng($studentNv);
						$studentTemp = $studentData['student'];
						$studentJianlu = $studentData['studentJianlu'];
						// 检录单部分
						$jianludanData[] = array(
							'xiangmu'=>$theXiangmu['mingcheng'],
							'xingbie'=>'女子',
							'nianji'=>$jibuName,
							'student'=>$studentJianlu,
							'zushu'=>count($studentJianlu),
							);
						$zuxuhao = 0;
						foreach($studentTemp as $studentTempKey=>$studentTempValue){
							if(($studentTempKey)%8==0||$studentTempKey==0){
								$zuxuhao++;
								$table->addRow(500);
								$table->addCell(1000, $styleCell)->addText($zuxuhao, $fontStyle,$paragraphStyle);
							}
							$cell = $table->addCell(1000, $styleCell);
							$xuehao = $this->sportNumber($studentTemp[$studentTempKey]['xuehao']);
							$cell->addText($xuehao, $fontStyle,$paragraphStyle);
							$cell->addText($studentTemp[$studentTempKey]['name'], $fontStyle,$paragraphStyle);
						}
						// 生成女生数据结束
					}else{
						switch ($theXiangmu['nannv']) {
							case 0:
								$theXingbie = '女子';
								break;
							case 1:
								$theXingbie = '男子';
								break;
							case 3:
								$theXingbie = '全部';
								break;
						}
						// 添加表格
						$section->addText(' ',$titleFontStyle,$titleParagraphStyle);
						$section->addText($jibuName.$theXingbie.$theXiangmu['mingcheng'], $fontStyle,$paragraphStyle);
						$section->addText(' ',$titleFontStyle,$titleParagraphStyle);
						$table = $section->addTable('myOwnTableStyle');
						// 添加第一行
						$table->addRow(500);
						$table->addCell(1000, $styleCell)->addText('组\道次', $fontStyle,$paragraphStyle);
						$table->addCell(1000, $styleCell)->addText('一', $fontStyle,$paragraphStyle);
						$table->addCell(1000, $styleCell)->addText('二', $fontStyle,$paragraphStyle);
						$table->addCell(1000, $styleCell)->addText('三', $fontStyle,$paragraphStyle);
						$table->addCell(1000, $styleCell)->addText('四', $fontStyle,$paragraphStyle);
						$table->addCell(1000, $styleCell)->addText('五', $fontStyle,$paragraphStyle);
						$table->addCell(1000, $styleCell)->addText('六', $fontStyle,$paragraphStyle);
						$table->addCell(1000, $styleCell)->addText('七', $fontStyle,$paragraphStyle);
						$table->addCell(1000, $styleCell)->addText('八', $fontStyle,$paragraphStyle);
						// 分组内容
						$studentData = $this->zuhexuesheng($student);
						// p($studentData);
						$studentTemp = $studentData['student'];
						$studentJianlu = $studentData['studentJianlu'];
						// 检录单部分
						$jianludanData[] = array(
							'xiangmu'=>$theXiangmu['mingcheng'],
							'xingbie'=>$theXingbie,
							'nianji'=>$jibuName,
							'student'=>$studentJianlu,
							'zushu'=>count($studentJianlu),
							);
						$zuxuhao = 0;
						foreach($studentTemp as $studentTempKey=>$studentTempValue){
							if(($studentTempKey)%8==0||$studentTempKey==0){
								$zuxuhao++;
								$table->addRow(500);
								$table->addCell(1000, $styleCell)->addText($zuxuhao, $fontStyle,$paragraphStyle);
							}
							$cell = $table->addCell(1000, $styleCell);
							$xuehao = $this->sportNumber($studentTemp[$studentTempKey]['xuehao']);
							$cell->addText($xuehao, $fontStyle,$paragraphStyle);
							$cell->addText($studentTemp[$studentTempKey]['name'], $fontStyle,$paragraphStyle);
						}
						// 生成数据结束

					}

				}else{
					// 表示田赛
					if($theXiangmu['nannv']==2){
						// 清空男女数组
						$studentNan = array();
						$studentNv = array();
						// 表示分男女生项目
						foreach($student as $studentKey=>$studentValue){
							// 男女分组
							if($studentValue['xingbie']==1){
								$studentNan[] = $studentValue; 
							}else{
								$studentNv[] = $studentValue;
							}
						}
						// 添加表格
						$section->addText(' ',$titleFontStyle,$titleParagraphStyle);
						$section->addText($jibuName.'男子'.$theXiangmu['mingcheng'], $fontStyle,$paragraphStyle);
						$section->addText(' ',$titleFontStyle,$titleParagraphStyle);
						$table = $section->addTable('myOwnTableStyle');
						// 男生分组内容
						$studentTemp = $studentNan;
						// 重新排序
						shuffle($studentTemp);
						// 检录单部分
						$jianludanDataTiansai[] = array(
							'xiangmu'=>$theXiangmu['mingcheng'],
							'xingbie'=>'男子',
							'nianji'=>$jibuName,
							'student'=>$studentTemp,
							'zushu'=>count($studentJianlu),
							);
						foreach($studentTemp as $studentTempKey=>$studentTempValue){

							if(($studentTempKey)%8==0||$studentTempKey==0){
								// $zuxuhao++;
								$table->addRow(500);
							}
							$cell = $table->addCell(1125, $styleCell);
							$xuehao = $this->sportNumber($studentTemp[$studentTempKey]['xuehao']);
							$cell->addText($xuehao, $fontStyle,$paragraphStyle);
							$cell->addText($studentTemp[$studentTempKey]['name'], $fontStyle,$paragraphStyle);
						}
						// 生成男生数据结束
						// 添加表格
						$section->addText(' ',$titleFontStyle,$titleParagraphStyle);
						$section->addText($jibuName.'女生'.$theXiangmu['mingcheng'], $fontStyle,$paragraphStyle);
						$section->addText(' ',$titleFontStyle,$titleParagraphStyle);
						$table = $section->addTable('myOwnTableStyle');		
						// 女生分组内容
						// 生成女生数据开始
						$studentTemp = $studentNv;
						// 重新排序
						shuffle($studentTemp);
						// 检录单部分
						$jianludanDataTiansai[] = array(
							'xiangmu'=>$theXiangmu['mingcheng'],
							'xingbie'=>'女子',
							'nianji'=>$jibuName,
							'student'=>$studentTemp,
							'zushu'=>count($studentJianlu),
							);
						// echo $studentTemp;
						// $zuxuhao = 0;
						foreach($studentTemp as $studentTempKey=>$studentTempValue){

							if(($studentTempKey)%8==0||$studentTempKey==0){
								// $zuxuhao++;
								$table->addRow(500);
								// $table->addCell(1000, $styleCell)->addText($zuxuhao, $fontStyle,$paragraphStyle);

							}
							$cell = $table->addCell(1125, $styleCell);
							$xuehao = $this->sportNumber($studentTemp[$studentTempKey]['xuehao']);
							$cell->addText($xuehao, $fontStyle,$paragraphStyle);
							$cell->addText($studentTemp[$studentTempKey]['name'], $fontStyle,$paragraphStyle);

						}
						// 生成女生数据结束

					}
				}
			}

		}
		// $jianludan = $this->jianludan($jianludanData);

		$savePath = date('Ym',time());
		// 检查上传目录
        $this->checkSavePath('./Uploads/'.$savePath);
		$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
		$fileName = 'zhixuce'.'('.date('Y-m-d',time()).')'.'.doc';
		$fileName  = iconv("utf-8","gb2312",$fileName );
		$objWriter->save('./Uploads/'.$savePath.'/'.$fileName);
		$data = array(
			'jianluce'=>$jianludanData,
			'tiansaiJianluce'=>$jianludanDataTiansai,
			'file'=>$savePath.'/'.$fileName
			);
		return $data;
	}
	// 生成检录单
	// $type=0表示竞赛
	// $type=1表示田赛
	function jianludan($jianludan,$type=0){

		vendor('PHPWord.PHPWord');
		$PHPWord = new PHPWord();
		$section = $PHPWord->createSection();
		// 定义标题文字样式
		$titleFontStyle = array('bold'=>true,'name'=>'隶书','size'=>16, 'color'=>'006699');
		$titleParagraphStyle = array('align'=>'center', 'spaceAfter'=>100);
		// 定义表格样式
		$styleTable = array('borderSize'=>6, 'borderColor'=>'006699', 'cellMargin'=>80);
		$styleFirstRow = array('borderBottomSize'=>18, 'borderBottomColor'=>'0000FF', 'bgColor'=>'66BBFF');
		// 定义单元格样式
		$styleCell = array('valign'=>'center');
		$styleCellBTLR = array('valign'=>'center', 'textDirection'=>PHPWord_Style_Cell::TEXT_DIR_BTLR);
		// 定义字体加粗和文字居中样式
		$fontStyle = array('bold'=>true);
		$paragraphStyle = array('align'=>'center');
		// 添加表格样式
		$PHPWord->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);
		// 处理主体内容开始
		// 级部总标题
		// $jibuName = $jianludan['jibuName'];
		if($type==0){
			foreach($jianludan as $key=>$value){
				$xiangmu = $value['xiangmu'];
				$xingbie = $value['xingbie'];
				$nianji = $value['nianji'];
				$studentJianlu = $value['student'];
				$fenzuCount = count($studentJianlu);
				foreach($studentJianlu as $mkey=>$mvalue){

					$section->addText(' ',$titleFontStyle,$titleParagraphStyle);
					$section->addText($nianji.$xingbie.$xiangmu.'  共分'.$fenzuCount.'组 第'.++$mkey.'组',$fontStyle,$titleParagraphStyle);
					$section->addText(' ',$titleFontStyle,$titleParagraphStyle);
					$table = $section->addTable('myOwnTableStyle');
					// 添加第一行
					$table->addRow(500);
					$table->addCell(1000, $styleCell)->addText('组\道次', $fontStyle,$paragraphStyle);
					$table->addCell(1000, $styleCell)->addText('一', $fontStyle,$paragraphStyle);
					$table->addCell(1000, $styleCell)->addText('二', $fontStyle,$paragraphStyle);
					$table->addCell(1000, $styleCell)->addText('三', $fontStyle,$paragraphStyle);
					$table->addCell(1000, $styleCell)->addText('四', $fontStyle,$paragraphStyle);
					$table->addCell(1000, $styleCell)->addText('五', $fontStyle,$paragraphStyle);
					$table->addCell(1000, $styleCell)->addText('六', $fontStyle,$paragraphStyle);
					$table->addCell(1000, $styleCell)->addText('七', $fontStyle,$paragraphStyle);
					$table->addCell(1000, $styleCell)->addText('八', $fontStyle,$paragraphStyle);
					$table->addRow(500);
					$table->addCell(1000, $styleCell)->addText('姓名', $fontStyle,$paragraphStyle);
					foreach($mvalue as $xkey=>$xvalue){
						$cell = $table->addCell(1000, $styleCell);
						$cell ->addText($this->sportNumber($xvalue['xuehao']), $fontStyle,$paragraphStyle);
						$cell ->addText($xvalue['name'], $fontStyle,$paragraphStyle);
					}
					// 添加第一行
					$table->addRow(500);
					$table->addCell(1000, $styleCell)->addText('成绩', $fontStyle,$paragraphStyle);
					$table->addCell(1000, $styleCell)->addText('', $fontStyle,$paragraphStyle);
					$table->addCell(1000, $styleCell)->addText('', $fontStyle,$paragraphStyle);
					$table->addCell(1000, $styleCell)->addText('', $fontStyle,$paragraphStyle);
					$table->addCell(1000, $styleCell)->addText('', $fontStyle,$paragraphStyle);
					$table->addCell(1000, $styleCell)->addText('', $fontStyle,$paragraphStyle);
					$table->addCell(1000, $styleCell)->addText('', $fontStyle,$paragraphStyle);
					$table->addCell(1000, $styleCell)->addText('', $fontStyle,$paragraphStyle);
					$table->addCell(1000, $styleCell)->addText('', $fontStyle,$paragraphStyle);
					// 添加第一行
					$table->addRow(500);
					$table->addCell(1000, $styleCell)->addText('名次', $fontStyle,$paragraphStyle);
					$table->addCell(1000, $styleCell)->addText('', $fontStyle,$paragraphStyle);
					$table->addCell(1000, $styleCell)->addText('', $fontStyle,$paragraphStyle);
					$table->addCell(1000, $styleCell)->addText('', $fontStyle,$paragraphStyle);
					$table->addCell(1000, $styleCell)->addText('', $fontStyle,$paragraphStyle);
					$table->addCell(1000, $styleCell)->addText('', $fontStyle,$paragraphStyle);
					$table->addCell(1000, $styleCell)->addText('', $fontStyle,$paragraphStyle);
					$table->addCell(1000, $styleCell)->addText('', $fontStyle,$paragraphStyle);
					$table->addCell(1000, $styleCell)->addText('', $fontStyle,$paragraphStyle);
				}

			}
			$jianluceName = 'jingsaidianluce';
		}
		if($type==1){

			foreach($jianludan as $key=>$value){
				$xiangmu = $value['xiangmu'];
				$xingbie = $value['xingbie'];
				$nianji = $value['nianji'];
				$studentJianlu = $value['student'];
				// 学生数量
				$tiansaiXueShengShuLiang = count($studentJianlu);
				$section->addText(' ',$titleFontStyle,$titleParagraphStyle);
				$section->addText($nianji.$xingbie.$xiangmu.' 共计：'.$tiansaiXueShengShuLiang.'人',$fontStyle,$titleParagraphStyle);
				$table = $section->addTable('myOwnTableStyle');
				$table->addRow(500);
				$table->addCell(1000, $styleCell)->addText('序号', $fontStyle,$paragraphStyle);
				$table->addCell(1000, $styleCell)->addText('姓名', $fontStyle,$paragraphStyle);
				$table->addCell(1500, $styleCell)->addText('成绩1', $fontStyle,$paragraphStyle);
				$table->addCell(1500, $styleCell)->addText('成绩2', $fontStyle,$paragraphStyle);
				$table->addCell(1500, $styleCell)->addText('成绩3', $fontStyle,$paragraphStyle);
				$table->addCell(1500, $styleCell)->addText('最终成绩', $fontStyle,$paragraphStyle);
				$table->addCell(1000, $styleCell)->addText('名次', $fontStyle,$paragraphStyle);
				
				foreach($studentJianlu as $mkey=>$mvalue){
					$table->addRow(500);
					$table->addCell(1000, $styleCell)->addText(++$mkey, $fontStyle,$paragraphStyle);
					
					$cell = $table->addCell(1000, $styleCell);
					$cell->addText($this->sportNumber($mvalue['xuehao']), $fontStyle,$paragraphStyle);
					$cell->addText($mvalue['name'], $fontStyle,$paragraphStyle);
					$table->addCell(1500, $styleCell)->addText('', $fontStyle,$paragraphStyle);
					$table->addCell(1500, $styleCell)->addText('', $fontStyle,$paragraphStyle);
					$table->addCell(1500, $styleCell)->addText('', $fontStyle,$paragraphStyle);
					$table->addCell(1500, $styleCell)->addText('', $fontStyle,$paragraphStyle);
					$table->addCell(1000, $styleCell)->addText('', $fontStyle,$paragraphStyle);
				}
				$section->addText('', $fontStyle,$paragraphStyle);
				$section->addText('裁判员签名：', $fontStyle,array('align'=>left));
				$section->addPageBreak();
			}

			$jianluceName = 'tiansaichengjice';
		}
		
		
		// 处理主体内容结束
		$savePath = date('Ym',time());
			// 检查上传目录
		$this->checkSavePath('./Uploads/'.$savePath);
		$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
		$fileName = $jianluceName.'('.date('Y-m-d',time()).')'.'.docx';
		$fileName  = iconv("utf-8","gb2312",$fileName );
		$objWriter->save('./Uploads/'.$savePath.'/'.$fileName);
		return $savePath.'/'.$fileName;
		
	}
	// 导出PHPWORD 趣味运动会样式
	function toWordQuwei($arr){
		vendor('PHPWord.PHPWord');
		$PHPWord = new PHPWord();
		$section = $PHPWord->createSection();
		// 定义标题文字样式
		$titleFontStyle = array('bold'=>true,'name'=>'隶书','size'=>16, 'color'=>'006699');
		$titleParagraphStyle = array('align'=>'center', 'spaceAfter'=>100);
		// 定义表格样式
		$styleTable = array('borderSize'=>6, 'borderColor'=>'006699', 'cellMargin'=>80);
		$styleFirstRow = array('borderBottomSize'=>18, 'borderBottomColor'=>'0000FF', 'bgColor'=>'66BBFF');
		// 定义单元格样式
		$styleCell = array('valign'=>'center');
		$styleCellBTLR = array('valign'=>'center', 'textDirection'=>PHPWord_Style_Cell::TEXT_DIR_BTLR);
		// 定义字体加粗和文字居中样式
		$fontStyle = array('bold'=>true);
		$paragraphStyle = array('align'=>'center');
		// 添加表格样式
		$PHPWord->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);
		// 循环显示年级数据
		foreach($arr as $key=>$value){
			//循环显示项目数据
			foreach($value['xiangmu'] as $mkey=>$mvalue){
				// $section->addText($value['mingcheng']."报名列表",$titleFontStyle,$titleParagraphStyle);
				// 添加表格
				$table = $section->addTable('myOwnTableStyle');
				// 添加标题行
				$table->addRow(500);
				$table->addCell(9000, $styleCell)->addText($mvalue['mingcheng'], $fontStyle);
				if($mvalue['jiti']!=0){
					// 表示是集体项目
					if($mvalue['fenzu']==0){
						// 表示没有分组
						// 添加第一行
						$table->addRow(500);
						// 添加单元格
						$table->addCell(600, $styleCell)->addText('序号', $fontStyle,$paragraphStyle);
						$table->addCell(1400, $styleCell)->addText('班级', $fontStyle,$paragraphStyle);
						$table->addCell(6000, $styleCell)->addText('学生', $fontStyle,$paragraphStyle);
						$table->addCell(1000, $styleCell)->addText('得分', $fontStyle);
						foreach($mvalue['student'] as $nkey=>$nvalue){
							// 按照班级进行了集体排列
							// 添加一行
							$table->addRow();
							$xuhao = 0;
							$xuhao++;
							$table->addCell(600, $styleCell)->addText($xuhao,'',$paragraphStyle);
							$table->addCell(1400, $styleCell)->addText($nvalue['banji']['ruxuenian'].'级'.$nvalue['banji']['banji'].'班','',$paragraphStyle);
							$studentList = '';
							foreach($nvalue['student'] as $xkey=>$xvalue){
								$studentList = ($studentList=='')?$xvalue['name']:$studentList.'  '.$xvalue['name'];
							}
							$table->addCell(6000, $styleCell)->addText($studentList,'',array('align'=>'left'));
							$table->addCell(1000, $styleCell)->addText('');
						}
					}
					if($mvalue['fenzu']!=0){
						// 表示进行了分组
						// 添加第一行
						$table->addRow(500);
						// 添加单元格
						$table->addCell(3000, $styleCell)->addText('分队', $fontStyle,$paragraphStyle);
						// $table->addCell(600, $styleCell)->addText('序号', $fontStyle,$paragraphStyle);
						// $table->addCell(1000, $styleCell)->addText('班级', $fontStyle,$paragraphStyle);
						$table->addCell(5000, $styleCell)->addText('学生', $fontStyle,$paragraphStyle);
						$table->addCell(1000, $styleCell)->addText('得分', $fontStyle);
						foreach($mvalue['content'] as $nkey=>$nvalue){
							// 添加一行
							$table->addRow();
							$table->addCell(3000, $styleCell)->addText($nvalue['mingcheng'],'',$paragraphStyle);
							$xuhao = 0;
							
							// $cellxuhao = $table->addCell(600,$styleCell);
							// $cellbanji = $table->addCell(1000,$styleCell);
							$cellxuesheng = $table->addCell(5000,$styleCell);
							shuffle($nvalue['student']);
							foreach($nvalue['student'] as $xkey=>$xvalue){
								// $cellxuhao->addText($xuhao++, $fontStyle,$paragraphStyle);
								// $cellbanji->addText($xvalue['banji']['username'], $fontStyle,$paragraphStyle);

								$student = '';
								foreach($xvalue['student'] as $ykey=>$yvalue){
									$student = ($student=='')?$yvalue['name']:$student.' '.$yvalue['name'];
								}
								$xuhao++;
								$cellxuesheng->addText('第'.$xuhao.'组'.$xvalue['banji']['username'].$student,'','');
							}
							$table->addCell(1000,$styleCell)->addText();
						}
					}
				}
				if($mvalue['jiti']==0){
					// 表示是个人项目
					// 根据学生数量计算有多少行
					$studentCount = count($mvalue['student']);
					if($studentCount%8==0){
						$rowCount = $studentCount/8;
					}else{
						$rowCount = floor($studentCount/8)+1;
					}
					// 对学生重新排序
					shuffle($mvalue['student']);
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
				}
				$section->addPageBreak();
			}
			
		}

		$savePath = date('Ym',time());
		// 检查上传目录
        $this->checkSavePath('./Uploads/'.$savePath);
		$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
		$fileName = $this->wenjianming().'.docx';
		$objWriter->save('./Uploads/'.$savePath.'/'.$fileName);
		return $savePath.'/'.$fileName;

	}
	// 导出PHP WORD 选修课样式
	function toWord($arr){

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
		// 定义字体加粗和文字居中样式
		$fontStyle = array('bold'=>true);
		$paragraphStyle = array('align'=>'center');
		// 添加表格样式
		$PHPWord->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);
		// 循环显示年级数据
		foreach($arr as $key=>$value){
			//循环显示项目数据
			foreach($value['xiangmu'] as $mkey=>$mvalue){
				$section->addText($value['mingcheng']."报名列表",$titleFontStyle,$titleParagraphStyle);
			
				// 添加表格
				$table = $section->addTable('myOwnTableStyle');
				// 添加标题行
				$table->addRow(500);
				$table->addCell(9000, $styleCell)->addText($mvalue['mingcheng'], $fontStyle);
				// 添加第一行
				$table->addRow(500);
				// 添加单元格
				$table->addCell(1000, $styleCell)->addText('序号', $fontStyle,$paragraphStyle);
				$table->addCell(1000, $styleCell)->addText('学号', $fontStyle,$paragraphStyle);
				$table->addCell(1000, $styleCell)->addText('姓名', $fontStyle,$paragraphStyle);
				$table->addCell(6000, $styleCell)->addText('记录', $fontStyle);
				// 循环学生显示学生数据
				foreach($mvalue['student'] as $nkey=>$nvalue){
					$table->addRow();
					$table->addCell(1000)->addText($nkey+1,'',$paragraphStyle);
					$table->addCell(1000)->addText($nvalue['xuehao'],'',$paragraphStyle);
					$table->addCell(1000)->addText($nvalue['name'],'',$paragraphStyle);
					$table->addCell(6000)->addText("");
				}
				$section->addPageBreak();
			}
			
		}
		$savePath = date('Ym',time());
		// 检查上传目录
        $this->checkSavePath('./Uploads/'.$savePath);
		$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
		$fileName = $this->wenjianming().'.docx';
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
	// 生成文件名
	protected function wenjianming(){
		load('extend');

		return time().rand_string($len=6,1);
	}

	// 重新排列组合学生
	protected function zuhexuesheng($student){
		// 如果为空直接返回
		if(empty($student)) return $student;
		// 学生数据备份
		$studentLast = $student;
		// 学生数量
		$studentCount = count($student);
		// 判断学生数是否是8的倍数，计算行数
		if($studentCount%8==0){
			$rowCount = $studentCount/8;
		}else{
			$rowCount = floor($studentCount/8)+1;
		}

		$studentResult = array();
		$student = $studentLast;
		// 竖向分配学生
		$m = 0;
		for($i=0;$i<8;$i++){
			// 循环列
			for($j=0;$j<$rowCount;$j++){
				$studentResult[$j][$i] = $student[$m];
				$m++;
				
			}
		}
		// 检测每一组人数，添加空列
		foreach($studentResult as $key=>$value){
			$shijiXuesheng = array_filter($value);
			shuffle($shijiXuesheng);
			
			$count = count($shijiXuesheng);
			// 初始化一组
			$zuArray = array();
			if($count<=4){
				$zuArray = array(1,1);
				for($i=0;$i<6;$i++){
					if(empty($shijiXuesheng[$i])){
						$zuArray[] = 1;
					}else{
						$zuArray[] = $shijiXuesheng[$i];
					}
				}
			}
			if($count>4 && $count<7){
				$zuArray = array(1);
				for($i=0;$i<7;$i++){
					if(empty($shijiXuesheng[$i])){
						$zuArray[] = 1;
					}else{
						$zuArray[] = $shijiXuesheng[$i];
					}
				}
			}
			if($count>6){
				for($i=0;$i<8;$i++){
					if(empty($shijiXuesheng[$i])){
						$zuArray[] = 1;
					}else{
						$zuArray[] = $shijiXuesheng[$i];
					}
				}
			}

			$studentResult[$key] = $zuArray;
		}
		$studentJianlu = $studentResult;
		// 重新组合回元数据
		$m = 0;
		foreach($studentResult as $mkey=>$mvalue){
			foreach($mvalue as $nkey=>$nvalue){
				$student[$m] = $nvalue;
				$m++;
				
			}
		}
		$data = array(
			'student'=>$student,
			'studentJianlu'=>$studentJianlu,
			);
		return $data;
	}

	// 数组插入占位符
	function insertZhanwei($arr,$start,$length){
		$tiankong = array(1);
		$myArray = $arr;
		for($i=0;$i<$length;$i++){
			array_splice($myArray, $start,0, $tiankong);
		}
		
		return $myArray;
	}

	// 截取学号组合运动号 青岛附中专用
	function sportNumber($xuehao){
		$nianji = substr($xuehao, 2,2);
		$banji = substr($xuehao, 5,2);
		$haoma = substr($xuehao, -2,2);

		return $nianji.$banji.$haoma;
	}

	// 将数据传入word模板中，并返回数据
	function toWordnew($data){

		$this->assign($data);//把获取的数据传递的模板，替换模板里面的变量
		$content = $this->fetch('sport');//获取模板内容信息word是模板的名称

		$fileContent = WordMake($content);//生成word内容

		return $fileContent;
		
	}
	// 生成word文档
	function toWordFinal($content){
		$name = iconv("utf-8", "GBK",'秩序册');//转换好生成的word文件名编码
		$fp = fopen($name.".doc", 'w');//打开生成的文档
		fwrite($fp, $content);//写入包保存文件
		fclose($fp);
	}




}