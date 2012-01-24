<?php
class AdminController extends CController 
{
	public $layout = 'admin.views.layouts.main';
	public $_model = null;
	public $model = null;
	public $breadcrumbs = array();
	
	public function init() 
	{
		Users::model()->updateByPk( Yii::app()->user->getId(), 
							array(
								'lasttime' => date('Y-m-d H:i:s'), 
								)
							);
		parent::init();
	}

	public function loadModel($create = true) 
	{
		if ($this->model === null)
		{
			return null;
		}
		if ($this->_model === null) 
		{
			$modelClass = $this->model;
			if (isset($_POST['id']) && $_POST['id'] > 0) 
			{
				$model = new $modelClass();
				$this->_model = $model->findbyPk($_POST['id']);
			} 
			else if ($create)
			{
				$this->_model = new $modelClass();
			}
			if ($this->_model === null) 
			{
				Yii::app()->user->setFlash('info', 'Запис не знайдено.');
				Yii::app()->getRequest()->redirect('/admin');
			}
		}
		return $this->_model;
	}

	protected function validateID($id) 
	{
		if (!is_numeric($id) || $id == 0) 
		{
			Yii::app()->getRequest()->redirect('/admin');
		}
		return true;
	}

}
