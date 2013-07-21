<?php
/**
 * Contains default controller of admin module
 */

/**
 * Default Controller Class
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
                'actions' => array('index', 'logout'),
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
        $modelClass = $this->getModelClass();
        $model = new $modelClass();
        
        $attributes = Yii::app()->request->getPost($modelClass);
        if ($attributes)
        {
            $model->attributes = $attributes;
            if ($model->validate() && $model->login())
            {
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
        return true;
    }

    /**
     * Displays and saves change in site configuration
     */
    public function actionIndex()
    {
        $sectionId = $this->getId();
        $settingsFile = Yii::getPathOfAlias('application.config.settings') . '.php';
        $settings = require $settingsFile;

        $attributes = Yii::app()->request->getPost('settings');
        if ($attributes && is_array($attributes))
        {
            foreach ($attributes as $key => $value)
            {
                if (strpos($attributes[$key], "\n"))
                {
                    $attributes[$key] = nl2br($value);
                }
            }

            $settings = $attributes;
            $success = file_put_contents($settingsFile, '<?php return ' . var_export($settings, true) . ';', LOCK_EX);

            if ($success)
                Yii::app()->user->setFlash('success', Yii::t($sectionId, 'admin.form.message.success.savedSettings'));
            else 
                Yii::app()->user->setFlash('error', Yii::t($sectionId, 'admin.form.message.error.savedSettings'));
        }

        foreach ($settings as $key => $value)
        {
            if (strpos($settings[$key], "\n"))
            {
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
        if ($error)
        {
            $this->render('error', $error);
        }
    }

}