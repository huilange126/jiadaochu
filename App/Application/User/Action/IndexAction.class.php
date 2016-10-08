<?php
Class IndexAction extends CommonAction{

	function index(){
		// p($this->student);die;
		// 学生id
		$studentId = $this->student['id'];
		// 班级id 根据班级读取考试信息
		$bid = $this->student['bid'];
		// $kaoshi = D('KaoshiRelation')->relation(true)->where(array('xueshengid'=>$studentId))->select();
		// 分页设置
		$condition = array('banji'=>$bid,'status'=>1);
		$count = M('kaoshi')->where($condition)->count();
		$page = getPageObject($count,10);
		// 获得分页页码 用于手机端
		$nowpage = I('p',1,'intval');
		$kaoshi = D('KaoshiRelation')->relation('xueke')->order('id DESC')->where($condition)->limit($page->firstRow,$page->listRows)->select();
		$data = array(
			'student'=>$this->student,
			'kaoshi'=>$kaoshi,
			'show'=>$page->show(),
			'nowpage'=>$nowpage,
			'num'=>$page->firstRow,
			'count'=>$page->totalPages,
			);
		
		$this->assign($data);
		$this->display();
	}

	// 考试信息详情
	function detail(){

		$kaoshiId = I('id',0,'intval');

		if($kaoshiId==0) $this->error('考试不存在');

		$studentId = $this->student['id'];
		// 查询学生本次考试信息
		D('KaoshiRelation')->_link['chengji']['condition'] = 'xueshengid='.$studentId;
		$kaoshi = D('KaoshiRelation')->relation(true)->find($kaoshiId);
		// 组合分数
		if(empty($kaoshi['chengji'])){
			$kaoshi['defen'] = '无成绩';
			$kaoshi['mingci'] = 'N';
		}else{
			$kaoshi['defen'] = $kaoshi['chengji'][0]['fenshu'];
			// 计算名次
			$kaoshi['mingci'] = $this->paixu($kaoshi['defen'],$kaoshiId);
		}
		// 所有学生考试成绩数据
		$allChengji = M('kaoshichengji')->where(array('kaoshiid'=>$kaoshiId))->getField('fenshu',true);
		// p($allChengji);die;
		$bingzhuangtu = $this->bingzhuangtu($allChengji,$kaoshi['manfen'],10);
		// 组合为echart格式数据
		foreach($bingzhuangtu as $key=>$value){
			if($echartTitle==''){
				$echartTitle = "'".$value['title']."'";
			}else{
				$echartTitle = $echartTitle.','."'".$value['title']."'";
			}
			if($echartData==''){
				$echartData = "{value:".$value['renshu'].",name:"."'".$value['title']."'}";
			}else{
				$echartData = $echartData.','."{value:".$value['renshu'].", name:"."'".$value['title']."'}";
			}
		}
		// p($echartData);die;
		$data = array(
			'student'=>$this->student,
			'kaoshi'=>$kaoshi,
			'echartTitle'=>$echartTitle,
			'echartData'=>$echartData,
			);

		$this->assign($data);
		$this->display();
	}

	// 计算学生成绩名次
	protected function paixu($fenshu,$kaoshi){
		$kaoshiFenshu = array();
		$kaoshiFenshu = M('kaoshichengji')->where(array('kaoshiid'=>$kaoshi))->getField('fenshu',true);

		rsort($kaoshiFenshu);
		// p($kaoshiFenshu);die;
		return array_search($fenshu, $kaoshiFenshu)+1;
	}
	// 饼状图、统计学生成绩分布情况
	// @shuju 考试所有学生成绩
	// @manfen 表示本次考试满分值
	// @kuadu 表示分析成绩间距
	protected function bingzhuangtu($shuju,$manfen,$kuadu){
		$fenduan = $manfen;
		$pinlv[] = $manfen;
		// 多个跨度计算满分
		$pinlv[] = $manfen+$kuadu;
		while($fenduan>0){
			// $pinlv[] = array(
			// 	'shangxian'=>$fenduan,
			// 	'xiaxian'=>($fenduan-$kuadu)>=0?($fenduan-$kuadu):0,
			// 	);
			$temp = $fenduan-$kuadu;
			$pinlv[] = ($temp>=0)?$temp:0;
			$fenduan = $fenduan-$kuadu;
		}
		$tongji = array();
		// 将频数升序排列
		sort($pinlv);
	
		foreach($shuju as $key=>$value){
			$weizhi = $this->binarySearch($pinlv,$value);
			// echo $weizhi.'<br>';
			$tongji[$weizhi] = $tongji[$weizhi]+1;
		}

		// 结果数组
		$result = array();
		foreach($tongji as $key=>$value){
			$result[] = array(
				'shangxian'=>$pinlv[$key+1],
				'xiaxian'=>$pinlv[$key],
				'renshu'=>$value,
				);
		}
		// 循环检测是否有满分
		foreach($result as $key=>$value){
			if($value['xiaxian']==$manfen){
				$dataEchart[] = array(
					'title'=>'满分',
					'renshu'=>$value['renshu'],
					);
			}else{
				$dataEchart[] = array(
					'title'=>$value['xiaxian'].'分'.$value['shangxian'].'之间',
					'renshu'=>$value['renshu'],
					);
			}
		}
		return $dataEchart;
	}
	// 二分法查找
	function binarySearch($array, $val) {
		$count = count($array);
		$low = 0;
		$high = $count - 1;

		$data = array();
		while ($low <= $high) {
			$mid = intval(($low + $high) / 2);
			if ($val>=$array[$mid]&&$val<$array[$mid+1]) {
				return $mid;
			}
			if ($array[$mid] < $val) {
				$low = $mid + 1;
			} else {
				$high = $mid - 1;
			}
		}
		return false;
	}
}