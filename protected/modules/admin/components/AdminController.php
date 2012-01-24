<?php/** * Admin Controller Class */
class AdminController extends CController {	/**	 * Shows the main layout file	 * 	 * @access public	 * @var string	 */
	public $layout = 'admin.views.layouts.main';		/**	 * The object of model	 * 	 * @access public	 * @var object	 */
	public $_model = null;		/**	 * The name of model	 * 	 * @access public	 * @var string	 */
	public $model = null;		/**	 * Breadcrumbs to current page	 * 	 * @access public	 * @var array	 */
	public $breadcrumbs = array();
	/**	 * Updates the last viset date befo initialize application	 * 	 * @access public	 * 	 * @return void	 */
	public function init() 	{		Users::model()->updateByPk( 			Yii::app()->user->getId(), 			array( 'lasttime' => date('Y-m-d H:i:s') ) 		);		
		parent::init();	}		/**	 * Loads the model object	 * 	 * @access public	 * @param boolean $create	 * 	 * @return object	 */
	public function loadModel($create = true) 	{		if ($this->model === null)		{			return null;		}
		if ($this->_model === null) 		{			$modelClass = $this->model;			if ( isset( $_POST['id'] ) && ( $_POST['id'] > 0 ) ) 			{				$model = new $modelClass( );				$this->_model = $model->findbyPk( $_POST['id'] );			} 			else if ( $create )			{				$this->_model = new $modelClass( );			}
			if ( $this->_model === null ) 			{				Yii::app( )->user					->setFlash( 'info', 'Запис не знайдено.' );				Yii::app( )->getRequest( )					->redirect( '/admin' );			}		}
		return $this->_model;	}		/**	 * Validates the identifier	 * if not valid redirect to admin index page	 * 	 * @access protected	 * @param integer $id	 * @param boolean $redirect 	 * 	 * @return boolean, or void if no valid	 */
	protected function validateID($id, $redirect = true) 	{		if ( !is_numeric( $id ) || ( $id == 0 ) ) 		{			if ( $redirect )			{				Yii::app( )->getRequest( )					->redirect( '/admin' );			}			return false;		}
		return true;	}
}