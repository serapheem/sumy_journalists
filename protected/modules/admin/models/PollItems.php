<?php

class PollItems extends CActiveRecord {

	public function rules() {
		return array(
			array('name, poll_id', 'required'),
		);
	}

	public function attributeLabels() {
		return array(
			'name' => 'Назва',
		);
	}

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{poll_items}}';
	}
	
	public function scopes() {
		return array(
			'ordering' => array(
				'order' => 'ordering ASC',
			),
		);
	}

}