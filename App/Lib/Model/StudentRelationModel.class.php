<?php
Class StudentRelationModel extends RelationModel{
    
    
    Protected $tableName = 'student';
    
    public $_link = array(
    
        'banji' => array(
            'mapping_type'=>BELONGS_TO,
            'mapping_name'=>'banji',
            'class_name'=>'banji',
            'foreign_key'=>'bid',
            'mapping_fields'=>'ruxuenian,banji',
            'as_fields'=>'ruxuenian,banji'
        ),
        // 期末成绩学校发布的
        'chengji'=>array(
            'mapping_type'=>HAS_MANY,
            'mapping_name'=>'chengji',
            'class_name'=>'chengji',
            'foreign_key'=>'xueshengid',
            'mapping_fields'=>'xuekeid,fenshu',
            ),
        // 平日考试
        'kaoshi'=>array(
            'mapping_type'=>MANY_TO_MANY,
            'mapping_name'=>'kaoshi',
            'class_name'=>'kaoshi',
            'relation_table'=>'kaoshichengji',
            'foreign_key'=>'xueshengid',
            'relation_foreign_key'=>'kaoshiid'
            ),
        'enrollment'=>array(
            'mapping_type'=>MANY_TO_MANY,
            'class_name'=>'enrollment_content',
            'relation_table'=>'enrollment_list',
            'foreign_key'=>'sid',
            'relation_foreign_key'=>'cid',
            ),
        'jiangcheng'=>array(
            'mapping_type'=>HAS_MANY,
            'class_name'=>'jiangcheng',
            'mapping_name'=>'jiangcheng',
            'foreign_key'=>'xuesheng_id',
            'condition'=>'status=0',
            ),
    );
    
}


?>