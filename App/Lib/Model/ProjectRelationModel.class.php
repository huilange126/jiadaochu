<?php
Class ProjectRelationModel extends RelationModel{
    
    protected $tableName = 'project';
    
    protected $_link = array(
    
        'nianji' => array(
        
            'mapping_type'=>MANY_TO_MANY,
            'mapping_name'=>'nianji',
            'foreign_key'=>'pid',
            'relation_foreign_key'=>'nid',
            'relation_table'=>'project_nianji'
        ),

        'ruxuenian'=>array(
            'mapping_type'=>HAS_MANY,
            'class_name'=>'project_nianji',
            'foreign_key'=>'pid',

            ),
        
        'term' => array(
            'mapping_type'=>BELONGS_TO,
            'mapping_name'=>'term',
            'foreign_key'=>'term',
            'mapping_fields'=>'name,id',
            'as_fields'=>'name:term,id:termid',
        ),
        
        'option'=>array(
        
            'mapping_type'=>HAS_MANY,
            // 'class_name'=>'option',
            'mapping_name'=>'choose',
            'foreign_key'=>'pid',
            'mapping_order'=>'sort'
        ),
    );
    
}

?>