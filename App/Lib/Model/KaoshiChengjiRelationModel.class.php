<?php
Class KaoshiChengjiRelationModel extends RelationModel{

	protected $tableName = 'kaoshichengji';

	protected $_link = array(
		'kaoshi'=>array(
			'mapping_type'=>BELONGS_TO,
			'class_name'=>'kaoshi',
			'foreign_key'=>'kaoshiid',
			),
		'student'=>array(
			'mapping_type'=>BELONGS_TO,
			'class_name'=>'student',
			'foreign_key'=>'xueshengid',
			),
		);
}