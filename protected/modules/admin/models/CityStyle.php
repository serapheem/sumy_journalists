<?php

class CityStyle extends CActiveRecord {

    public function rules() {
        return array(
            array('title, body', 'required'),
            array('title, body, publish', 'safe'),
        );
    }

    public function attributeLabels() {
        return array(
            'title' => 'Назва',
            'body' => 'Текст',
            'publish' => 'Опублікувати',
        );
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{city_style}}';
    }
    
    public function scopes() {
        return array(
            'ordering' => array(
                'order' => 'ordering ASC',
            ),
        );
    }

}
