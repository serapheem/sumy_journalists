<?php
/**
 * Contains default controller of Admin module
 *
 * @author      Serhiy Hlushko <serhiy.hlushko@gmail.com>
 * @copyright   Copyright 2013 Hlushko inc.
 * @company     Hlushko inc.
 */

/**
 * Manages default's pages of Admin module
 */
class DefaultController extends AdminController
{
    /**
     * {@inheritdoc}
     */
    public $defaultAction = 'index';

    /**
     * {@inheritdoc}
     */
    protected $_modelClass = 'Login';

    /**
     * {@inheritdoc}
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('login'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('index', 'error', 'logout'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            )
        );
    }

    /**
     * Conducts the login user and displays the login page
     */
    public function actionLogin()
    {
        $model = $this->loadModel(true, '');

        $attributes = Yii::app()->input->post($this->getModelClass());
        if ($attributes) {
            $model->attributes = $attributes;
            if ($model->validate() && $model->login()) {
                $this->redirect('/admin');
            }
        }

        $this->renderPartial('login', array('model' => $model));
    }

    /**
     * Conducts the logout user
     * 
     * @access public
     * 
     * @return void
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl . 'admin');
    }

    /**
     * Displays and saves change in site settings
     */
    public function actionIndex()
    {
        $sectionId = $this->getId();
        $settingsFile = Yii::getPathOfAlias('application.config.settings') . '.php';
        $settings = require $settingsFile;

        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $attributes = Yii::app()->input->post('settings');
            if ($attributes && is_array($attributes)) {
                foreach ($attributes as $key => $value) {
                    if (strpos($attributes[$key], "\n")) {
                        $attributes[$key] = nl2br($value);
                    }
                }

                $settings = $attributes;
                $success = file_put_contents(
                    $settingsFile,
                    '<?php return ' . var_export($settings, true) . ';',
                    LOCK_EX
                );

                if ($success) {
                    Yii::app()->getUser()->setFlash(
                        'success',
                        Yii::t($sectionId, 'admin.form.message.success.savedSettings')
                    );
                } else {
                    Yii::app()->getUser()->setFlash(
                        'error',
                        Yii::t($sectionId, 'admin.form.message.error.savedSettings')
                    );
                }
            }
        }

        foreach ($settings as $key => $value) {
            if (strpos($settings[$key], "\n")) {
                $settings[$key] = strip_tags($value);
            }
        }

        $this->render('index', array_replace(array('sectionId' => $sectionId), $settings));
    }

    /**
     * Displays error page
     */
    public function actionError()
    {
        $error = Yii::app()->errorHandler->error;
        if ($error) {
            $this->render('error', $error);
        }
    }

}