<?php

return array(
	'elements' => array(
		( isset( $_REQUEST['id'] ) ? '<h1>Редагувати подію</h1>' : '<h1>Нова подія</h1>' ),
		
		'title' => array(
			'type' => 'text',
			'maxlength' => 120,
		),
		'alias' => array(
			'type' => 'text',
			'maxlength' => 120,
		),
		'body' => array(
			'type' => 'application.extensions.NHCKEditor.CKEditorWidget',
			'attribute'=>'body',
			'editorOptions' => array(
				'width' => '800',
				'height' => '500',
				'language' => 'uk',
				'toolbar' => 'custom',
			),
		),
		'publish' => array(
			'type' => 'checkbox',
		),
		
		'<input type="hidden" value="' . ( isset( $_REQUEST['id'] ) ? $_REQUEST['id'] : 0 ) . '" name="id" />',
		'<input type="hidden" value="true" name="edit" />'
	),
	'buttons' => array(
		'apply' => array(
			'type' => 'submit',
			'label' => ( isset( $_REQUEST['id'] ) ? 'Зберегти' : 'Додати' ),
		),
		'save' => array(
			'type' => 'submit',
			'label' => ( isset( $_REQUEST['id'] ) ? 'Зберегти і закрити' : 'Додати і закрити' ),
		),
		
		'<a href="/admin/tyca">'. ( isset( $_REQUEST['id'] ) ? 'Закрити' : 'Відмінити' ) .'</a>',
	),
);