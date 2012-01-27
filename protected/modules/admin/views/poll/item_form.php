<?php

return array(
    'elements' => array(
        ( isset( $_REQUEST['id'] ) ? '<h1>Редагувати варіант</h1>' : '<h1>Новий варіант</h1>' ),
        
        'name' => array(
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
            'label' => ( isset( $_REQUEST['id'] ) ? 'Зберегти' : 'Додати' ),
        ),
        'save' => array(
            'type' => 'submit',
            'label' => ( isset( $_REQUEST['id'] ) ? 'Зберегти і закрити' : 'Додати і закрити' ),
        ),
        
        '<a href="/admin/poll/items?id=' . $_REQUEST['poll_id'] . '">'. ( isset( $_REQUEST['id'] ) ? 'Закрити' : 'Відмінити' ) .'</a>',
    ),
);