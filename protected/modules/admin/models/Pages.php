<?php

class Pages extends CActiveRecord {

    public function rules() {
        return array(
            array('title, body', 'required'),
            array('title, body, seo', 'safe'),
        );
    }

    public function attributeLabels() {
        return array(
            'title' => 'Назва',
            'body' => 'Текст',
        );
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{pages}}';
    }

}