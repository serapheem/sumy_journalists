<?php
/**
 * Contains controller class of categories
 */

/**
 * Categories Controller Class
 */
class CategoriesController extends AdminAbstractController
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
                'expression' => '$user->id == 1',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            )
        );
    }

}
