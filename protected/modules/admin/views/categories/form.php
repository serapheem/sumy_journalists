<?php
/**
 * Category item add/edit form file
 */
return array(
    'action' => '/admin/categories/' . (isset($model->id) ? 'update?id=' . $model->id : 'create'),
    'activeForm' => array(
        'class' => 'CActiveForm',
        'id' => 'categories-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'clientOptions' => array(
            'validationUrl' => array('validate'),
            'validateOnSubmit' => true,
            'validateOnChange' => true,
        )
    ),
    'elements' => array(
        '<h1>' . (isset($model->id) ? Yii::t($this->getId(), 'EDIT_ITEM') : Yii::t($this->getId(), 'NEW_ITEM')) . '</h1>',
        '<div class="width-65 fleft">',
        'details' => array(
            'type' => 'form',
            'title' => Yii::t('main', 'Details'),
            'elements' => array(
                'title' => array(
                    'type' => 'text',
                    'maxlength' => 255,
                ),
                'alias' => array(
                    'type' => 'text',
                    'maxlength' => 127,
                ),
                'parent_id' => array(
                    'type' => 'dropdownlist',
                    'items' => $model->getDropDownItems(),
                ),
                'state' => array(
                    'type' => 'radiolist',
                    'layout' => "{label}\n<div class=\"radiolist-wrapper\">{input}</div>\n{hint}\n{error}",
                    'items' => $model->getStateValues(),
                    'separator' => "\n"
                ),
                'section' => array(
                    'type' => 'text',
                    'maxlength' => 63,
                ),
                'description' => array(
                    'type' => 'application.extensions.NHCKEditor.CKEditorWidget',
                    'attribute' => 'description',
                    'layout' => "{label}\n<br />{input}\n{hint}\n{error}",
                    'editorOptions' => array(
                        'width' => 700,
                        'height' => 500,
                        'language' => 'uk',
                        'toolbar' => 'custom',
                    ),
                    'htmlOptions' => array('class' => 'form-editor')
                ),
                'publish' => array(
                    'type' => 'checkbox',
                ),
                'frontpage' => array(
                    'type' => 'checkbox',
                ),
            )
        ),
        '</div>',
        '<div class="width-35 fleft">',
        'publishing' => array(
            'type' => 'form',
            'title' => Yii::t('main', 'Publishing Options'),
            'elements' => array(
                'created_by' => array(
                    'type' => 'text',
                    'value' => ( isset($model->id) ? $model->created_user->name : '' ),
                    'disabled' => 'disabled',
                    'class' => 'readonly'
                ),
                'created' => array(
                    'type' => 'text',
                    'value' => ( isset($model->id) ? Yii::app()->dateFormatter->formatDateTime($model->created, "long") : '' ),
                    'disabled' => 'disabled',
                    'class' => 'readonly'
                ),
                'modified_by' => array(
                    'type' => 'text',
                    'value' => ( isset($model->id) ? $model->modified_user->name : '' ),
                    'disabled' => 'disabled',
                    'class' => 'readonly'
                ),
                'modified' => array(
                    'type' => 'text',
                    'value' => ( isset($model->id) ? Yii::app()->dateFormatter->formatDateTime($model->modified, "long") : '' ),
                    'disabled' => 'disabled',
                    'class' => 'readonly'
                ),
            )
        ),
        'metadata' => array(
            'type' => 'form',
            'title' => Yii::t('main', 'Metadata Options'),
            'elements' => array(
                'metadesc' => array(
                    'type' => 'textarea',
                    'rows' => 3,
                    'cols' => 40
                ),
                'metakey' => array(
                    'type' => 'textarea',
                    'rows' => 3,
                    'cols' => 40
                ),
            )
        ),
        '</div>',
        '<div class="clrbth"></div>'
    ),
    'buttons' => array(
        'apply' => array(
            'type' => 'submit',
            'label' => ( isset($model->id) ? Yii::t('main', 'SAVE') : Yii::t('main', 'ADD') ),
        ),
        'save' => array(
            'type' => 'submit',
            'label' => ( isset($model->id) ? Yii::t('main', 'SAVE_AND_CLOSE') : Yii::t('main', 'ADD_AND_CLOSE') ),
        ),
        '<a href="/admin/' . $this->getId() . '">' . ( isset($model->id) ? Yii::t('main', 'CLOSE') : Yii::t('main', 'CANCEL') ) . '</a>',
    ),
);