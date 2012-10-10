<?php
/**
 * Contains default controller of admin module
 */

/**
 * Default Controller Class
 */
class DefaultController extends AdminAbstractController
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
                'actions' => array('logout'),
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
            $model->attributes = $modelClass;
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
        $settingsFile = Yii::getPathOfAlias('application.config.settings') . '.php';
        $settings = require $settingsFile;

        if (isset($_POST['settings']) && is_array($_POST['settings']))
        {
            foreach ($_POST['settings'] AS $key => $value)
            {
                if (strpos($_POST['settings'][$key], "\n"))
                {
                    $_POST['settings'][$key] = nl2br($value);
                }
            }

            $settings = $_POST['settings'];
            file_put_contents($settingsFile, '<?php return ' . var_export($settings, true) . ';', LOCK_EX);

            Yii::app()->user->setFlash('info', Yii::t('main', 'SETTINGS_CHANGED'));
        }

        foreach ($settings AS $key => $value)
        {
            if (strpos($settings[$key], "\n"))
            {
                $settings[$key] = strip_tags($value);
            }
        }

        $this->render('index', $settings);
        return true;
    }

    /**
     * Displays error page
     * 
     * @access public
     * 
     * @return void
     */
    public function actionError()
    {
        $error = Yii::app()->errorHandler->error;
        if ($error)
        {
            $this->render('error', $error);
        }
        return true;
    }

}