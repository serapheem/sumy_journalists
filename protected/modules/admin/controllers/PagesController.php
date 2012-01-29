<?php/** * Pages Controller Class */
class PagesController extends AdminController{	/**	 * Name of default model	 * 	 * @access public	 * @var string	 */
	public $model = 'Pages';		/**	 * Displays the list of items	 * 	 * @access public	 * 	 * @return void	 */
	public function actionIndex( )	{		$model = $this->model;		$rows = $model::model( )			->findAll( );
		$this->render( 'list', array( 'rows' => $rows ) );		return true;	}		/**	 * Displays edit form and save changes	 * 	 * @access public	 * 	 * @return void	 */	public function actionEdit( )	{		$model = $this->loadModel( );		$form = new CForm( 'admin.views.pages.form', $model );
		if ( is_null( $model->id ) )		{			$title = 'Нова сторінка';		}		else {			$title = $model->title;		}
		$this->breadcrumbs = array(			'Статичні сторінки' => '/admin/pages',			$title		);
		if ( isset( $_POST['Pages'] ) )		{			$model->attributes = $_POST['Pages'];
			if ( $model->validate( ) && $model->save( ) )			{				if ( isset( $_REQUEST['id'] ) && $_REQUEST['id'] )				{					$msg = 'Сторінка успішно змінена.';				}				else {					$msg = 'Сторінка успішно додана.';				}				Yii::app( )->user->setFlash( 'info', $msg );								if ( !empty( $_POST['save'] ) || ( empty( $_POST['save'] ) && empty( $_POST['apply'] ) ) )				{					Yii::app( )						->getRequest( )						->redirect( '/admin/pages' );				}				else {					Yii::app( )						->getRequest( )						->redirect( '/admin/pages/edit?id=' . $model->id );				}			}		}				$this->renderText( $form );		return true;	}	}