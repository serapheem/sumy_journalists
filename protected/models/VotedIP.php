<?php

class VotedIP extends CActiveRecord 
{
    public static function model($className = __CLASS__) 
    {
        return parent::model($className);
    }

    public function tableName() 
    {
        return '{{voted_ips}}';
    }

    public function scopes() 
    {
        return array(
            
        );
    }

}