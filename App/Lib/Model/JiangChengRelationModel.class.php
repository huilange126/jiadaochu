<?php
Class JiangChengRelationModel extends RelationModel{

	protected $tableName = 'jiangcheng';

	public $_link = array(
		'student'=>array(
			'mapping_type'=>BELONGS_TO,
			'class_name'=>'student',
			'foreign_key'=>'xuesheng_id',
			'mapping_name'=>'student',
			),
		);
}