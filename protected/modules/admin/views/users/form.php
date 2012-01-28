<?php

return array(
    'elements' => array(
        '<h1>Новий користувач</h1>',
        
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
            'label' => 'Додати',
        ),
        'save' => array(
            'type' => 'submit',
            'label' => 'Додати і закрити',
        ),
        
        '<a href="/admin/users">Відмінити</a>',
    ),
);