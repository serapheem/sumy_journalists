<?php

return array(
    'elements' => array(
        '<h1>Новий користувач</h1>',
        'name' => array(
            'type' => 'text',
            'maxlength' => 250,
        ),
        'username' => array(
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
        'login' => array(
            'type' => 'submit',
            'label' => 'Додати',
        ),
        '<a href="/admin/users">Відмінити</a>',
    ),
);