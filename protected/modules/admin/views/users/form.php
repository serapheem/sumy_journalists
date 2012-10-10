<?php
/**
 * User item add/edit form file
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
            'validationUrl' => $newItem 
                            ? array('validate') 
                            : array('validate', 'id' => $model->id),
            'validateOnSubmit' => true,
            'validateOnChange' => true,
        )
    ),
    'elements' => array(
        '<h1>' . Yii::t($sectionId, $newItem 
            ? 'admin.form.title.newItem' 
            : 'admin.form.title.editItem') . '</h1>',
        'name' => array(
            'type' => 'text',
            'maxlength' => 128,
        ),
        'email' => array(
            'type' => 'text',
            'maxlength' => 128,
        ),
        'password' => array(
			'type' => 'password',
			'maxlength' => 64,
            'value' => ''
		),
		'newPassword' => array(
			'type' => 'password',
			'maxlength' => 64,
            'value' => ''
		),
		'password2' => array(
			'type' => 'password',
			'maxlength' => 64,
            'value' => ''
		)
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