<?php

return array(
    'elements' => array(
        (isset($_POST['id']) ? '<h1>Редагувати сторінку</h1>' : '<h1>Нова сторінка</h1>'),
        'title' => array(
            'type' => 'text',
            'maxlength' => 50,
        ),
        'body' => array(
            'type' => 'application.extensions.NHCKEditor.CKEditorWidget',
            'attribute' => 'body',
            'editorOptions' => array(
                'width' => '800',
                'height' => '500',
                'language' => 'uk',
                'toolbar' => 'custom',
            ),
        ),
        '<input type="hidden" value="' . (isset($_POST['id']) ? $_POST['id'] : 0) . '" name="id" />'
    ),
    'buttons' => array(
        'login' => array(
            'type' => 'submit',
            'label' => 'Зберегти',
        ),
        '<a href="/admin/pages">'. (($_POST['id'] != 0) ? 'Закрити' : 'Відмінити') .'</a>',
    ),
);