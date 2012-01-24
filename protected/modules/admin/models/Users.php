<?php

class Users extends CActiveRecord 
{
    public $password;
    public $password2;

    public function rules() 
    {
        return array(
            array('name, username, password, password2', 'required'),
            array('password', 'compare', 'compareAttribute' => 'password2'),
        );
    }

    public function attributeLabels() 
    {
        return array(
            'name' => 'Ім\'я користувача',
            'username' => 'Логін',
            'password' => 'Пароль',
            'password2' => 'Повторити пароль',
        );
    }

    public static function model($className = __CLASS__) 
    {
        return parent::model($className);
    }

    public function tableName() 
    {
        return '{{users}}';
    }

}