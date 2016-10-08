<?php
Class KaoshiRelationModel extends RelationModel{

	protected $tableName = 'kaoshi';

	public $_link = array(

		'xueke'=>array(
			'mapping_type'=>BELONGS_TO,
			'class_name'=>'xueke',
			'foreign_key'=>'xueke',
			'mapping_fields'=>'xueke',
			'as_fields'=>'xueke:xueke',
			),
		'xueqi'=>array(
			'mapping_type'=>BELONGS_TO,
			'class_name'=>'term',
			'foreign_key'=>'xueqi',
			'mapping_fields'=>'name',
			'as_fields'=>'name:xueqi',
			),
		'banji'=>array(
			'mapping_type'=>BELONGS_TO,
			'class_name'=>'banji',
			'foreign_key'=>'banji',
			'mapping_fields'=>'ruxuenian,banji',
			'as_fields'=>'ruxuenian:ruxuenian,banji:banji',
			),
		'chengji'=>array(
			'mapping_type'=>HAS_MANY,
			'class_name'=>'kaoshichengji',
			'foreign_key'=>'kaoshiid',
			),

		);
}

?>