<?php

class Poll extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{poll}}';
    }
    
    public function relations() {
        return array(
            'items' => array(self::HAS_MANY, 'PollItems', 'poll_id', 'order' => 'ordering ASC'),
        );
    }
    
    public function scopes() {
        return array(
            'published' => array(
                'condition' => 'publish=1',
                'order' => 'RAND() ASC',
                'limit'=>1,
            ),
        );
    }

}