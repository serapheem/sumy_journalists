<?php

return array(
	'elements' => array(
		isset( $_REQUEST['id'] ) ? '<h1>' . Yii::t( 'pollitems', 'EDIT_ITEM' ) . '</h1>' : '<h1>' . Yii::t( 'pollitems', 'NEW_ITEM' ) . '</h1>',
		
		'title' => array(
			'type' => 'text',
			'maxlength' => 120,
		),
		'poll_id' => array(
			'type' => 'hidden',
			'value' => $_REQUEST['poll_id'],
		),
		
		'<input type="hidden" value="' . ( isset( $_REQUEST['id'] ) ? $_REQUEST['id'] : 0 ) . '" name="id" />',
	),
	'buttons' => array(
		'apply' => array(
			'type' => 'submit',
			'label' => ( isset( $_REQUEST['id'] ) ? Yii::t( 'main', 'SAVE' ) : Yii::t( 'main', 'ADD' ) ),
		),
		'save' => array(
			'type' => 'submit',
			'label' => ( isset( $_REQUEST['id'] ) ? Yii::t( 'main', 'SAVE_AND_CLOSE' ) : Yii::t( 'main', 'ADD_AND_CLOSE' ) ),
		),
		
		'<a href="/admin/poll/items?id=' . $_REQUEST['poll_id'] . '">' 
			. ( isset( $_REQUEST['id'] ) ? Yii::t( 'main', 'CLOSE' ) : Yii::t( 'main', 'CANCEL' ) ) .'</a>',
	),
);