<?php
Class DefenRelationModel extends RelationModel{
    
    protected $tableName = 'defen';
    
    protected $_link = array(
    
        'teacher'=>array(
            
            'mapping_type'=>BELONGS_TO,
            'class_name'=>'teacher',
            'foreign_key'=>'tid',
            'mapping_fields'=>'name',
            'as_fields'=>'name:tname',
        
        ),
    
    );
    
}


?>