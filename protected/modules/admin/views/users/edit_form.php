<?php

return array(
    'elements' => array(
        '<h1>Редагувати користувача</h1>',
        'name' => array(
            'type' => 'text',
            'maxlength' => 250,
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
        '<input type="hidden" value="' . (isset($_POST['id']) ? $_POST['id'] : 0) . '" name="id" />'
    ),
    'buttons' => array(
        'login' => array(
            'type' => 'submit',
            'label' => 'Змінити',
        ),
        '<a href="/admin/users">Закрити</a>',
    ),
);