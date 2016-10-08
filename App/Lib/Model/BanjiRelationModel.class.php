<?php
Class BanjiRelationModel extends RelationModel{
    
    protected $tableName = 'banji';
    
    public $_link = array(
    
        'teacher' => array(
            
            'mapping_type'=>MANY_TO_MANY,
            'mapping_name'=>'teacher',
            'foreign_key'=>'bid',
            'relation_foreign_key'=>'tid',
            'relation_table'=>'teacher_banji',
            //'condition'=>'termid=5',
            'mapping_order'=>'xid'
        ),
        'student'=>array(
            'mapping_type'=>HAS_MANY,
            'class_name'=>'student',
            'mapping_name'=>'student',
            'foreign_key'=>'bid',
            'mapping_order'=>'xuehao ASC',
            //'parent_id'=>'id',
        ),
        
    );
    
}


?>