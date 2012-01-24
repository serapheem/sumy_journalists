<?php

class News extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{news}}';
    }

    public function scopes() {
        return array(
            'published' => array(
                'condition' => 'publish=1',
                'order' => 'ordering ASC',
            ),
        );
    }

}