<?php
/**
 * Contains base class of admin module
 *
 * @author      Serhiy Hlushko <serhiy.hlushko@gmail.com>
 * @copyright   Copyright 2013 Hlushko inc.
 * @company     Hlushko inc.
 */

/**
 * Admin Module main class
 */
class AdminModule extends CWebModule
{
    /**
     * Initializes the module
     */
    public function init()
    {
        Yii::app()->errorHandler->errorAction = 'admin/default/error';

        $this->setImport(array(
            'admin.components.*',
            'admin.helpers.*',
            'admin.models.*',
        ));
    }

    /**
     * Does some operation before any action
     * @param CController $controller
     * @param CAction     $action
     *
     * @return bool
     */
    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            if ( ! Yii::app()->getUser()->getIsGuest() || ($action->getId() === 'login')) {
                return true;
            }

            Yii::app()->getRequest()->redirect('/admin/default/login');

            return true;
        } else {
            return false;
        }
    }

}
