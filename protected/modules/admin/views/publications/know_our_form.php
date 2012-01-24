<?php

return array(
    'elements' => array(
        (isset($_POST['id']) ? '<h1>Редагувати особу</h1>' : '<h1>Нова особа</h1>'),
        'title' => array(
            'type' => 'text',
            'maxlength' => 120,
        ),
        'alias' => array(
            'type' => 'text',
            'maxlength' => 120,
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
        'frontpage' => array(
            'type' => 'checkbox',
        ),
        '<input type="hidden" value="' . (isset($_POST['id']) ? $_POST['id'] : 0) . '" name="id" />',
        '<input type="hidden" value="true" name="edit" />'
    ),
    'buttons' => array(
        'apply' => array(
            'type' => 'submit',
            'label' => (isset($_POST['id']) ? 'Зберегти' : 'Додати'),
        ),
        'save' => array(
            'type' => 'submit',
            'label' => (isset($_POST['id']) ? 'Зберегти і закрити' : 'Додати і закрити'),
        ),
        '<a href="/admin/publications/knowour">'. (isset($_POST['id']) ? 'Закрити' : 'Відмінити') .'</a>',
    ),
);