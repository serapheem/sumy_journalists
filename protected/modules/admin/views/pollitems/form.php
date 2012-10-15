<?php
/**
 * Poll item add/edit form file
 */
return array(
    'action' => $newItem 
        ? $this->createUrl('create') 
        : $this->createUrl('edit', array('id' => $model->primaryKey)),
    'activeForm' => array(
        'class'                     => 'CActiveForm',
        'id'                        => $sectionId . '-form',
        'enableAjaxValidation'      => true,
        'enableClientValidation'    => false,
        'htmlOptions'               => array('class' => 'admin-form'),
        'clientOptions'             => array(
            'validationUrl' => $newItem 
                            ? array('validate') 
                            : array('validate', 'id' => $model->primaryKey),
            'validateOnSubmit' => true,
            'validateOnChange' => true,
        )
    ),
    'elements' => array(
        '<h1>' . Yii::t($sectionId, $newItem 
            ? 'admin.form.title.newItem' 
            : 'admin.form.title.editItem') . '</h1>',
        'title' => array(
            'type' => 'text',
            'maxlength' => 128,
        ),
        'poll_id' => array(
            'type' => 'dropdownlist',
            'items' => $model->getPollidDropDown(),
        ),
        '<input type="hidden" name="returnUrl" value="' . $returnUrl . '" />',
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
        '<a href="' . $returnUrl . '">' 
            . Yii::t('main', 'admin.form.action.' . ($newItem ? 'cancel' : 'close')) 
            . '</a>',
    ),
);