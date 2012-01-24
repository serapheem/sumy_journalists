<?php

class Frontpage extends CActiveRecord 
{
    public function rules() 
    {
        return array(
            array('section, item_id', 'required'),
        );
    }

    public static function model($className = __CLASS__) 
    {
        return parent::model($className);
    }

    public function tableName() 
    {
        return '{{frontpage}}';
    }

}