<?php
/**
 * Custom category item add/edit form file
 */
return array(
    'action' => $newItem 
        ? $this->createUrl('create') 
        : $this->createUrl('edit', array('id' => $model->id)),
    'activeForm' => array(
        'class'                     => 'CActiveForm',
        'id'                        => $sectionId . '-form',
        'enableAjaxValidation'      => true,
        'enableClientValidation'    => false,
        'clientOptions'             => array(
            'validationUrl' => array('validate'),
            'validateOnSubmit' => true,
            'validateOnChange' => true,
        )
    ),
    'elements' => array(
        '<h1>' . Yii::t($sectionId, $newItem 
            ? 'admin.form.title.newItem' 
            : 'admin.form.title.editItem') . '</h1>',
        '<div class="width-65 fleft">',
        'general' => array(
            'type' => 'form',
            'title' => Yii::t('main', 'admin.form.section.generalData'),
            'elements' => array(
                'title' => array(
                    'type' => 'text',
                    'maxlength' => 255,
                ),
                'alias' => array(
                    'type' => 'text',
                    'maxlength' => 255,
                ),
//                'parent_id' => array(
//                    'type' => 'dropdownlist',
//                    'items' => $model->getParentDropDown(),
//                ),
                'state' => array(
                    'type' => 'radiolist',
                    'layout' => "{label}\n<div class=\"radiolist-wrapper\">{input}</div>\n{hint}\n{error}",
                    'items' => $model->getStateValues(),
                    'separator' => "\n"
                ),
                'description' => array(
                    'type' => 'application.extensions.NHCKEditor.CKEditorWidget',
                    'attribute' => 'description',
                    'layout' => "{label}\n<br />{input}\n{hint}\n{error}",
                    'editorOptions' => array(
                        'width' => 700,
                        'height' => 200,
                        'language' => 'uk',
                        'toolbar' => 'custom',
                    ),
                    'htmlOptions' => array('class' => 'form-editor')
                ),
            )
        ),
        '</div>',
        '<div class="width-35 fleft">',
        'publishing' => array(
            'type' => 'form',
            'title' => Yii::t('main', 'admin.form.section.publishData'),
            'elements' => array(
                'created_by' => array(
                    'type' => 'text',
                    'value' => $newItem ? '' : $model->created_user->name,
                    'disabled' => 'disabled',
                    'class' => 'readonly'
                ),
                'created_at' => array(
                    'type' => 'text',
                    'value' => $newItem ? '' : Yii::app()->dateFormatter->formatDateTime($model->created_at, 'long'),
                    'disabled' => 'disabled',
                    'class' => 'readonly'
                ),
                'modified_by' => array(
                    'type' => 'text',
                    'value' => $newItem ? '' : $model->modified_user->name,
                    'disabled' => 'disabled',
                    'class' => 'readonly'
                ),
                'modified_at' => array(
                    'type' => 'text',
                    'value' => $newItem ? '' : Yii::app()->dateFormatter->formatDateTime($model->modified_at, 'long'),
                    'disabled' => 'disabled',
                    'class' => 'readonly'
                ),
            )
        ),
        'metadata' => array(
            'type' => 'form',
            'title' => Yii::t('main', 'admin.form.section.metaData'),
            'elements' => array(
                'meta_title' => array(
                    'type' => 'text',
                    'maxlength' => 255
                ),
                'metakey' => array(
                    'type' => 'textarea',
                    'rows' => 3,
                    'cols' => 43,
                    'maxlength' => 255
                ),
                'metadesc' => array(
                    'type' => 'textarea',
                    'rows' => 3,
                    'cols' => 43,
                    'maxlength' => 255
                ),
            )
        ),
        '</div>',
        '<div class="clrbth"></div>'
    ),
    'buttons' => array(
        'apply' => array(
            'type' => 'submit',
            'label' => Yii::t('main', 'admin.form.action.' . ($newItem ? 'create' : 'save')),
        ),
        'save' => array(
            'type' => 'submit',
            'label' => Yii::t('main', 'admin.form.action.' . ($newItem ? 'create2close' : 'save2close')),
        ),
        '<a href="' . $this->createUrl($this->defaultAction) . '">' 
            . Yii::t('main', 'admin.form.action.' . ($newItem ? 'cancel' : 'close')) 
            . '</a>',
    ),
);