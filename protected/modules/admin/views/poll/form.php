<?php

return array(
    'elements' => array(
        ( isset( $_REQUEST['id'] ) ? '<h1>Редагувати голосування</h1>' : '<h1>Нове голосування</h1>' ),
        
        'name' => array(
            'type' => 'text',
            'maxlength' => 120,
        ),
        'publish' => array(
            'type' => 'checkbox',
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
        
        '<a href="/admin/poll">' . ( isset( $_REQUEST['id'] ) ? 'Закрити' : 'Відмінити' ) . '</a>',
    ),
);