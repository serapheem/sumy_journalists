<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

class AdminModule extends CWebModule {

	public function init() {
		Yii::app()->errorHandler->errorAction = 'admin/default/error';

		$this->setImport(array(
			'admin.models.*',
			'admin.components.*',
		));
	}

	public function beforeControllerAction($controller, $action) {
		if (parent::beforeControllerAction($controller, $action)) {
			$controller->layout = 'admin.views.main';

			if (!Yii::app()->user->isGuest || $action->id === 'login')
				return true;

			Yii::app()->getRequest()->redirect('/admin/default/login');
			return true;
		}
		else
			return false;
	}

}
