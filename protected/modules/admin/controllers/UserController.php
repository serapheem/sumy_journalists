<?php
/**
 * Contains User controller class
 */

/**
 * Manages functionality of all Users
 */
class UsersController extends AdminAbstractController 
{
    /**
     * {@inheritdoc}
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated users to perform 'view' actions
                'actions' => array('admin', 'create', 'validate'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated users to perform 'view' actions
                'actions' => array('edit', 'delete'),
                'users' => array('@'),
                'expression' => '$user->id == 1',
            ),
            array('allow', // allow authenticated users to perform 'view' actions
                'actions' => array('edit', 'delete'),
                'users' => array('@'),
                'expression' => '$user->id == Yii::app()->request->getQuery(\'id\')',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
}