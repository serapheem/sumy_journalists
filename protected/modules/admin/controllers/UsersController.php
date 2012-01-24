<?php

class UsersController extends AdminController 
{
    public $model = 'Users';

    public function actionIndex( ) 
    {
        $rows = Users::model( )->findAll();
        $this->render('index', array('rows' => $rows));
    }

    public function actionAdd() 
    {
        $model = $this->loadModel();
        $form = new CForm('admin.views.users.form', $model);

        $this->breadcrumbs = array(
            'Користувачі' => '/admin/users',
            'Новий користувач'
        );
        
        if ( isset( $_POST['Users'] ) ) 
        {
            $model->attributes = $_POST['Users'];
			if ( $model->password )
			{
            	$model->password = sha1( $model->email . $model->password );
			}
			if ( $model->password2 )
			{
            	$model->password2 = sha1( $model->email . $model->password2 );
			}

            if ($model->validate() && $model->save()) 
            {
                Yii::app()->user->setFlash('info', 'Користувач доданий.');
                Yii::app()->getRequest()->redirect('/admin/users');
            }
        }

        $this->renderText($form);
    }

    public function actionEdit() 
    {
        $model = $this->loadModel();
		$old_model = clone $model;
        $form = new CForm('admin.views.users.edit_form', $model);

        $this->breadcrumbs = array(
            'Користувачі' => '/admin/users',
            $model->username
        );
        
        if (isset($_POST['Users'])) 
        {
            $model->attributes = $_POST['Users'];
			
			if ( empty($model->password) || empty($model->password2) )
			{
				$model->password = $old_model->password;
	            $model->password2 = $old_model->password;
			}
			else {
	            $model->password = sha1( $model->email . $model->password );
	            $model->password2 = sha1( $model->email . $model->password2 );
			}
            $model->username = $old_model->username;
			
            if ( $model->validate() && $model->save() ) 
            {
                Yii::app()->user->setFlash('info', 'Дані користувача успішно змінені.');
                Yii::app()->getRequest()->redirect('/admin/users');
            }
        }

        $this->renderText($form);
    }

    public function actionDelete() 
    {
        if ( isset( $_POST['delete'] ) && ( sizeof( $_POST['delete'] ) > 0 ) ) 
        {
            foreach ($_POST['delete'] as $id)
			{
                if ($id != 1)
				{
                    Users::model()->deleteByPk($id);
				}
			}

            Yii::app()->user->setFlash('info', 'Користувачі видалені.');
        }

        Yii::app()->getRequest()->redirect('/admin/users');
    }

}