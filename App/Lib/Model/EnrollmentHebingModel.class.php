<?php
Class EnrollmentHebingModel extends RelationModel{

	protected $tableName = 'enrollment_hebing';

	protected $_link = array(

		'enrollment'=>array(
			'mapping_type'=>BELONGS_TO,
			'class_name'=>'enrollment',
			'foreign_key'=>'eid',
			'mapping_name'=>'enrollment',
			),
		'content'=>array(
			'mapping_type'=>HAS_MANY,
			'class_name'=>'enrollment_content',
			'foreign_key'=>'fenzu',
			'mapping_name'=>'content',
			),
		);
}

?>