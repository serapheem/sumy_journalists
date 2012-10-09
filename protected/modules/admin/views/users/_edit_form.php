<?php

return array(
	'elements' => array(
		'<h1>' . Yii::t( 'users', 'EDIT_ITEM' ) . '</h1>',
		
		'name' => array(
			'type' => 'text',
			'maxlength' => 120,
		),
		'email' => array(
			'type' => 'text',
			'maxlength' => 120,
		),
		'password' => array(
			'type' => 'password',
			'maxlength' => 50,
			'value' => '',
		),
		'password2' => array(
			'type' => 'password',
			'maxlength' => 50,
			'value' => '',
		),
		
		'<input type="hidden" value="' . ( isset( $_REQUEST['id'] ) ? $_REQUEST['id'] : 0 ) . '" name="id" />'
	),
	'buttons' => array(
		'apply' => array(
			'type' => 'submit',
			'label' => Yii::t( 'main', 'SAVE' ),
		),
		'save' => array(
			'type' => 'submit',
			'label' => Yii::t( 'main', 'SAVE_AND_CLOSE' ),
		),
		
		'<a href="/admin/users">' . Yii::t( 'main', 'CLOSE' ) . '</a>',
	),
);