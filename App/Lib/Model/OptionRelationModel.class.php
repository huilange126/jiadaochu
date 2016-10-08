<?php
Class OptionRelationModel extends RelationModel{
    
    protected $tableName = 'option';
    
    protected $_link = array(
    
        'student_project_option'=>array(
            'mapping_type'=>HAS_MANY,
            'mapping_name'=>'result',
            'foreign_key'=>'oid',
        ),
    
    );
    
}


?>