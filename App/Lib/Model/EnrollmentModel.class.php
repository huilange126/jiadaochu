<?php
//报名任务模型
Class EnrollmentModel extends Model{

	//根据条件选取报名任务
	function getEnrollment($condition,$first=0,$list=10){
		return $this->where($condition)->limit($first,$list)->order('id DESC')->select();
	}

}