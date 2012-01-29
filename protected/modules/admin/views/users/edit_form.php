<?php

return array(
	'elements' => array(
		'<h1>Редагувати користувача</h1>',
		
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
			'label' => 'Змінити',
		),
		'save' => array(
			'type' => 'submit',
			'label' => 'Змінити і закрити',
		),
		
		'<a href="/admin/users">Закрити</a>',
	),
);