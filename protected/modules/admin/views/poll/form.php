<?php

return array(
    'elements' => array(
        (isset($_POST['id']) ? '<h1>Редагувати голосування</h1>' : '<h1>Нове голосування</h1>'),
        'name' => array(
            'type' => 'text',
            'maxlength' => 50,
        ),
        'publish' => array(
            'type' => 'checkbox',
        ),
        '<input type="hidden" value="' . (isset($_POST['id']) ? $_POST['id'] : 0) . '" name="id" />',
    ),
    'buttons' => array(
        'login' => array(
            'type' => 'submit',
            'label' => (isset($_POST['id']) ? 'Зберегти' : 'Додати'),
        ),
        '<a href="/admin/poll">'. (isset($_POST['id']) ? 'Закрити' : 'Відмінити') .'</a>',
    ),
);