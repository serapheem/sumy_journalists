<?php
/**
 * Contains controller class of users
 */

/**
 * Users Controller Class
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
                'actions' => array('admin', 'create', 'edit', 'validate', 'delete'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            )
        );
    }

}