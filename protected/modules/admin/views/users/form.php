<?php

return array(
	'elements' => array(
		'<h1>' . Yii::t( 'users', 'NEW_ITEM' ) . '</h1>',
		
		'name' => array(
			'type' => 'text',
			'maxlength' => 120,
		),
		'username' => array(
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
		),
		'password2' => array(
			'type' => 'password',
			'maxlength' => 50,
		)
	),
	'buttons' => array(
		'apply' => array(
			'type' => 'submit',
			'label' => Yii::t( 'main', 'ADD' ),
		),
		'save' => array(
			'type' => 'submit',
			'label' => Yii::t( 'main', 'ADD_AND_CLOSE' ),
		),
		
		'<a href="/admin/users">' . Yii::t( 'main', 'CANCEL' ) . '</a>',
	),
);