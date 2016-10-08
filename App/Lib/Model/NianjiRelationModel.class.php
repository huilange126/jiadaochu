<?php
Class NianjiRelationModel extends RelationModel{
    
    protected $tableName = 'nianji';
    
    protected $_link = array(
        // 评优项目
        'project' => array(
            'mapping_type'=>MANY_TO_MANY,
            'mapping_name'=>'project',
            'foreign_key'=>'nid',
            'relation_foreign_key'=>'pid',
            'relation_table'=>'project_nianji',
        ),
        // // 读取所属班级
        // 'banji' => array(
        //     'mapping_type'=>HAS_MANY,
        //     'class_name'=>'banji',
        //     'foreign_key'=>'ruxuenian',
        //     'parent_key'=>'ruxuenian',
        //     ),
    );
    
}


?>