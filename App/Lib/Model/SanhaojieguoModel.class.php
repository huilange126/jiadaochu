<?php
Class SanhaojieguoModel extends Model{

	//根据条件返回评优结果数量
	function getCount($condition){
		return $this->where($condition)->count();
	}
}