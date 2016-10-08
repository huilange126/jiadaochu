<?php
Class ChengjiRelationModel extends RelationModel{

	protected $tableName = 'chengji';

	protected $_link = array(

		'xueke'=>array(
			'mapping_type'=>BELONGS_TO,
			'class_name'=>'xueke',
			'foreign_key'=>'xuekeid',
			'mapping_fields'=>'xueke',
			'as_fields'=>'xueke:xueke',
			),

		);
	
}