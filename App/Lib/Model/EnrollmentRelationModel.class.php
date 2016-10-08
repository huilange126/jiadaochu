<?php
//报名任务关联模型
Class EnrollmentRelationModel extends RelationModel{

	protected $tableName = 'enrollment';

	public $_link = array(
		'nianji'=>array(
			'mapping_type'=>MANY_TO_MANY,
			'mapping_name'=>'nianji',
			'class_name'=>'nianji',
			'foreign_key'=>'enrollment_id',
			'relation_foreign_key'=>'nianji_id',
			'relation_table'=>'enrollment_nianji',
			),
		'content'=>array(
			'mapping_type'=>HAS_MANY,
			'class_name'=>'enrollment_content',
			'foreign_key'=>'eid',
			'mapping_name'=>'content',
			'condition'=>'status=1',
			),
		'hebing'=>array(
			'mapping_type'=>HAS_MANY,
			'class_name'=>'enrollment_hebing',
			'foreign_key'=>'eid',
			),
		);
}