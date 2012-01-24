<?php

class PagesController extends AdminController 
{
	public $model = 'Pages';
	
	public function actionIndex() 
	{
		$rows = Pages::model()->findAll();
		$this->render('index', array('rows' => $rows));
	}

	public function actionEdit() 
	{
		$model = $this->loadModel();
		$form = new CForm('admin.views.pages.form', $model);
		if (is_null($model->id)) 
		{
			$title = 'Нова сторінка';
		} 
		else {
			$title = $model->title;
		}        
		$this->breadcrumbs = array('Статичні сторінки' => '/admin/pages', $title);
		
		if ( isset($_POST['Pages']) ) 
		{
			$model->attributes = $_POST['Pages'];
			
			if (empty($model->seo)) 
			{
				$model->seo = Helper::translit($model->title);
			} 
			else {
				$model->seo = Helper::translit($model->seo);
			}            
			$model->author = Yii::app()->user->getState('username');
			$model->lasttime = date('Y-m-d H:i:s');
			if ($model->validate() && $model->save()) 
			{
				if (isset($_POST['id']) && $_POST['id'] > 0) 
				{
					Yii::app()->user->setFlash('info', 'Сторінка успішно змінена.');
				} 
				else {
					Yii::app()->user->setFlash('info', 'Сторінка успішно додана.');
				}   
				Yii::app()->getRequest()->redirect('/admin/pages');
			}
		}       
		$this->renderText($form);
	}

	public function actionDelete() 
	{
		if (isset($_POST['delete']) && sizeof($_POST['delete']) > 0) 
		{
			foreach ($_POST['delete'] as $id)
			{
				Pages::model()->deleteByPk($id);
			}
			Yii::app()->user->setFlash('info', 'Сторінки видалені.');
		}   
		Yii::app()->getRequest()->redirect('/admin/pages');
	}

}
