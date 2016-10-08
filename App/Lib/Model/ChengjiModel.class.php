<?php
Class ChengjiModel extends Model{

	//根据学生ID，获取该学生有成绩的学期ID列表
	function getStudentCjTermList($id){
		return $this->where(array('xueshengid'=>$id))->distinct(true)->getField('termid',true);
	}

	//根据学期id和学生id获取该学生这学期的成绩数组
	function getChengji($termid,$studentid){

		$condition = array(
            'xueshengid'=>$studentid,
            'termid'=>$termid,
            );

        $chengji = D('ChengjiRelation')->relation(true)->order('xuekeid ASC')->where($condition)->select();

        return $chengji;
	}
}