<?php
//后台应用三好规则模型
Class SanhaoguizeModel extends Model{


	//根据分页读取该页数据
	function getPageData($page,$list){

		return D('SanhaoguizeRelation')->relation(true)->limit($page,$list)->select();

	}

	//根据ID获取规则名称
	function getName($id){
		return $this->where(array('id'=>$id))->getField('mingcheng');
	}
}