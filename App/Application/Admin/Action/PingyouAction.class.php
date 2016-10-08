<?php
//优秀班集体评优后台控制器
Class PingyouAction extends CommonAction{
	//评优教师状态列表
	function index(){

		import('ORG.Util.Page');
		$count = M('teacher')->count();
		$page = new Page($count,20);
        $page->setConfig('theme',"%totalRow% %header% %nowPage%/%totalPage% 页 <li>%upPage%</li> <li>%downPage%</li> <li>%first%</li> <li>%prePage%</li> <li>%linkPage%</li> <li>%nextPage%</li> <li>%end%</li>");
		$term = M('term')->where(array('status=1'))->find();

		D('TeacherRelation')->_link['pingyou']['condition'] = 'termid='.$term['id'];
		D('TeacherRelation')->_link['banji']['condition'] = 'termid='.$term['id'];

		//统计已经评价老师数量
		$finish = 0;

		$teacher = D('TeacherRelation')->relation(true)->select();
		//根据是否存在评分数据判定老师是否进行了班级评优
		foreach($teacher as $key => $value){
			if($value['pingyou']==''){
				$teacher[$key]['status'] = 0;
			}else{
				$teacher[$key]['status'] = 1;

				$finish = $finish + 1;
			}
		}
		load('extend');
		//按照评价状态进行排序
		$teacher = list_sort_by($teacher,'status','desc');
		//截取要显示数组
		$teacher = array_slice($teacher,$page->firstRow,$page->listRows);
		$data = array(
			'teacher'=>$teacher,
			'show'=>$page->show(),
			'num'=>$page->firstRow,
			'count'=>$count,
			'finish'=>$finish,
			'term'=>$term,
			);

		$this->assign($data);

		$this->display();
	}
	//优秀班集体评价结果
	//根据设定的当前 初一 初二 初三的入学年份 获得当前的班级
	function result(){
		//获得当前年级
		$nianji = M('nianji')->select();
		//获得当前学期
		$term = M('term')->where(array('status=1'))->find();
		//根据年级获得当前在校班级
		foreach($nianji as $key=>$value){

			$banji = M('banji')->where(array('ruxuenian'=>$value['ruxuenian']))->select();
			//循环查询的分
			foreach($banji as $banjikey=>$banjivalue){
				$defen = M('youxiubanji')->where(array('termid'=>$term['id'],'bid'=>$banjivalue['id']))->avg('defen');
				$defen = $defen==''?0:$defen;
				$banji[$banjikey]['defen'] = $defen;
			}

			$result[]=array(
				'nianjimingcheng'=>$value['mingcheng'],
				'ruxuenianfen'=>$value['ruxuenian'],
				'banji'=>$banji,
				);
		}

		$data = array(
			'result'=>$result,
			);

		$this->assign($data);

		$this->display();
	}

	//设定有评优项目分值
	function setsystem(){
		$this->display();
	}
	function setsystemHandle(){
		$str = "<?php\r\n return ".var_export(array_change_key_case($_POST,CASE_UPPER),true).";\r\n?>";
		file_put_contents(APP_PATH.'/Conf/pingyou.php',$str);
		$this->success('修改成功',U(GROUP_NAME.'/Pingyou/setsystem'));
	}
}