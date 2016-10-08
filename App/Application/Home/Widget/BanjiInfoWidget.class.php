<?php
// 前台班级界面，显示班级基础信息widget
Class BanjiInfoWidget extends Widget{

	function render($data){
		// 获取班级和学期信息
		$banji = M('banji')->find($_SESSION['banjiuid']);
		$term = M('term')->where(array('status'=>1))->find();

		$data = array(
			'banji'=>$banji,
			'term'=>$term,
			);

		$content = $this->renderFile('BanjiInfo',$data);
        return $content;  
	}
}