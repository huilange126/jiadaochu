<?php
Class StudentModel extends Model{

	//根据条件搜索学生，并返回学生数组
	function getStudent($keywords){

		$condition = array(
			'xuehao'=>array('LIKE','%'.$keywords.'%'),
			'name'=>array('LIKE','%'.$keywords.'%'),
			'_logic'=>'or',
			);

		return $this->where($condition)->select();
	}
}



