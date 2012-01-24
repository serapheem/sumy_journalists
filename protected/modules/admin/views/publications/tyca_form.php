<?php

return array(
    'elements' => array(
        (isset($_POST['id']) ? '<h1>Редагувати подію</h1>' : '<h1>Нова подія</h1>'),
        'title' => array(
            'type' => 'text',
            'maxlength' => 50,
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
            (isset($_POST['id']) ? '' : 'checked') => (isset($_POST['id']) ? '' : 'checked'),
        ),
        '<input type="hidden" value="' . (isset($_POST['id']) ? $_POST['id'] : 0) . '" name="id" />',
        '<input type="hidden" value="true" name="edit" />'
    ),
    'buttons' => array(
        'login' => array(
            'type' => 'submit',
            'label' => (isset($_POST['id']) ? 'Зберегти' : 'Додати'),
        ),
        '<a href="/admin/publications/tyca">'. (isset($_POST['id']) ? 'Закрити' : 'Відмінити') .'</a>',
    ),
);