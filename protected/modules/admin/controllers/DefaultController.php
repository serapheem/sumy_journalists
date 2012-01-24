<?php

class DefaultController extends AdminController 
{
    public function actionIndex() 
    {
        $settingsFile = Yii::getPathOfAlias('application.config.settings') . '.php';
        $settings = require $settingsFile;

        if ( isset($_POST['settings'])) 
        {
            foreach ($_POST['settings'] as $key => $value) 
            {
                if (strpos($_POST['settings'][$key], "\n"))
                    $_POST['settings'][$key] = nl2br($value);
            }

            file_put_contents(
                    $settingsFile, '<?php return ' . var_export($settings = $_POST['settings'], true) . ';', LOCK_EX
            );

            Yii::app()->user->setFlash('info', 'Установки змінені.');
        }

        foreach ($settings as $key => $value) 
        {
            if (strpos($settings[$key], "\n"))
                $settings[$key] = strip_tags($value);
        }

        $this->render('index', $settings);
    }

    public function actionError() {
        $error = Yii::app()->errorHandler->error;
        if ($error)
            $this->render('error', $error);
    }

    public function actionLogin() 
    {
        $model = new Login( );

        if (isset($_POST['Login'])) 
        {
            $model->attributes = $_POST['Login'];

            if ($model->validate() && $model->login())
                $this->redirect('/admin');
        }

        $this->renderPartial('login', array('model' => $model));
    }

    public function actionLogout() 
    {
        Yii::app()->user->logout();
        $this->redirect( Yii::app()->homeUrl . 'admin' );
    }

}