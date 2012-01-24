<?php

class Participants extends CActiveRecord 
{
    public static function model($className = __CLASS__) 
    {
        return parent::model($className);
    }

    public function tableName() 
    {
        return '{{participants}}';
    }

    public function scopes() 
    {
        return array(
            'published' => array(
                'condition' => 'publish=1',
                'order' => 'ordering ASC',
            ),
            'top10' => array(
                'condition' => 'top10=1',
            ),
            'results' => array(
                'condition' => 'publish=1 AND top10=1',
                'order' => 'rating DESC',
            ),
        );
    }

}