<?php
Class PingRelationModel extends RelationModel{
    
    Protected $tableName = 'teacher_banji';
    
    Protected $_link = array(
    
        'teacher'=>array(
            'mapping_type'=>BELONGS_TO,
            'mapping_name'=>'teacher',
            'foreign_key'=>'tid',
            // 获取教师名和学科ID
            'mapping_fields'=>'name,xid',
            'as_fields'=>'name,xid',
            //'mapping_order'=>'xid ASC'
        
        ),
    );
}

?>

