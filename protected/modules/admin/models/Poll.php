<?php

class Poll extends CActiveRecord {

	public function rules() {
		return array(
			array('name, publish', 'required'),
		);
	}

	public function attributeLabels() {
		return array(
			'name' => 'Назва',
			'publish' => 'Опублікувати',
		);
	}

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{poll}}';
	}

}