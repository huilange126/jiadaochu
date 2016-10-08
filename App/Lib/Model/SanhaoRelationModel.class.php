<?php
Class SanhaoRelationModel extends RelationModel{

	protected $tableName = 'sanhaojieguo';

	protected $_link = array(

		'result'=>array(
			'mapping_type'=>BELONGS_TO,
			'mapping_name'=>'student',
			'class_name'=>'Student',
			'foreign_key'=>'xueshengid',
			'mapping_fields'=>'xuehao,name',
			'as_fields'=>'xuehao:xuehao,name:name'
			),
		'xiangmu'=>array(
			'mapping_type'=>BELONGS_TO,
			'mapping_name'=>'xiangmu',
			'class_name'=>'sanhaoguize',
			'foreign_key'=>'sanhaoid',
			),

		);
}