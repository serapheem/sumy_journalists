<?php

class KnowOur extends CActiveRecord 
{
    public function rules() 
    {
        return array(
            array('title, body', 'required'),
            array('title, body, publish, frontpage', 'safe'),
        );
    }

    public function attributeLabels() 
    {
        return array(
            'title' => "Ім'я",
            'body' => 'Характеристика',
            'publish' => 'Опублікувати',
            'frontpage' => 'Розмістити на головній',
        );
    }

    public static function model($className = __CLASS__) 
    {
        return parent::model($className);
    }

    public function tableName() 
    {
        return '{{know_our}}';
    }
    
    public function scopes() 
    {
        return array(
            'ordering' => array(
                'order' => 'ordering ASC',
            ),
        );
    }
	
	public function relations()
    {
        return array(
            'frontpage'=>array(self::HAS_ONE, 'Frontpage', 'item_id',
                            'condition'=>"frontpage.section='KnowOur'"),
        );
    }

}
