<?php
Class SanhaoguizeRelationModel extends RelationModel{

	protected $tableName = 'sanhaoguize';

	protected $_link = array(
		'nianji'=>array(
			'mapping_type'=>BELONGS_TO,
			'mapping_name'=>'nianji',
			'class_name'=>'nianji',
			'foreign_key'=>'nianji',
			'mapping_fields'=>'ruxuenian,mingcheng',
			'as_fields'=>'ruxuenian:ruxuenian,mingcheng:nianji',
			),
		);
}