<?php

/**
 * Tyca Controller Class
 */
class TycaController extends AdminController 
{
	/**
	 * Name of default model
	 * 
	 * @access public
	 * @var string
	 */
	public $model = 'Tyca';
	
	/**
	 * Displays edit form and save changes
	 * 
	 * @access public
	 * 
	 * @return void
	 */
    public function actionEdit( ) 
    {
    	// Check the identifier
    	if ( !isset( $_POST['id'] ) && isset( $_GET['id'] ) && $this->validateID( $_GET['id'], false ) )
		{
			$_POST['id'] = $_GET['id'];
		}
		
        $model = $this->loadModel( );
        $form = new CForm( 'admin.views.tyca.form', $model );
		
        if ( is_null( $model->id ) ) 
        {
            $title = 'Нова подія';
        } 
        else {
            $title = $model->title;
        }
        $this->breadcrumbs = array(
            'Tyca' => '/admin/tyca',
            $title
        );
		
		if ( isset( $_POST['Tyca'] ) ) 
        {
            $model->attributes = $_POST['Tyca'];
            
			if ( $model->validate( ) && $model->save( ) ) 
            {
            	if ( isset( $_POST['id'] ) && $_POST['id'] ) 
                {
                    $msg = 'Подія успішно оновлена.';
                } 
                else {
                    $msg = 'Подія успішно додана.';
                }
                Yii::app( )->user->setFlash( 'info', $msg );
				
				if ( !empty( $_POST['save'] ) || ( empty( $_POST['save'] ) && empty( $_POST['apply'] ) ) )
				{
					Yii::app( )
						->getRequest( )
                		->redirect( '/admin/tyca' );
				}
				else {
					Yii::app( )
						->getRequest( )
                		->redirect( '/admin/tyca/edit?id=' . $model->id );
				}
            }
        }
		
        $this->renderText( $form );
		return true;
    }

}
