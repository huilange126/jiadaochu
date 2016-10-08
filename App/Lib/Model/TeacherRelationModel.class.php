<?php
Class TeacherRelationModel extends RelationModel{
    
    Protected $tableName = 'teacher';

    //public $xueqi;

    public $_link = array(
    
        'xueke'=>array(
        
            'mapping_type'=>BELONGS_TO,
            
            'class_name'=>'xueke',
            
            'mappting_name'=>'xueke',
            
            'foreign_key'=>'xid',
            
            'mapping_fields'=>'xueke',
            
            'as_fields'=>'xueke',
            
            ///'mapping_order'=>'xid'
        ),
        'banji'=>array(
            'mapping_type'=>MANY_TO_MANY,
            'class_name'=>'banji',
            'mapping_name'=>'banji',
            'foreign_key'=>'tid',
            //'condition'=>'termid='.$xueqi,
            'relation_foreign_key'=>'bid',
            'relation_table'=>'teacher_banji'
            ),
        'pingyou'=>array(
            'mapping_type'=>HAS_MANY,
            'class_name'=>'youxiubanji',
            'foreign_key'=>'tid',
            ),
    
    );

}


?>