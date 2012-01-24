<?php

return array(
    'elements' => array(
        (isset($_POST['id']) ? '<h1>Редагувати варіант</h1>' : '<h1>Новий варіант</h1>'),
        'name' => array(
            'type' => 'text',
            'maxlength' => 50,
        ),
        'poll_id' => array(
            'type' => 'hidden',
            'value' => $_GET['poll-id'],
        ),
        '<input type="hidden" value="' . (isset($_POST['id']) ? $_POST['id'] : 0) . '" name="id" />',
    ),
    'buttons' => array(
        'login' => array(
            'type' => 'submit',
            'label' => (isset($_POST['id']) ? 'Зберегти' : 'Додати'),
        ),
        '<a href="/admin/poll/items/poll-id/'.$_GET['poll-id'].'">'. (isset($_POST['id']) ? 'Закрити' : 'Відмінити') .'</a>',
    ),
);