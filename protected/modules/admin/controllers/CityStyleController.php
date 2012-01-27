<?php

/**
 * City Style Controller Class
 */
class CityStyleController extends AdminController 
{
	/**
	 * Name of default model
	 * 
	 * @access public
	 * @var string
	 */
	public $model = 'CityStyle';
	
	/**
	 * Displays edit form and save changes
	 * 
	 * @access public
	 * 
	 * @return void
	 */
    public function actionEdit( ) 
    {
    	$model = $this->loadModel( );
        $form = new CForm( 'admin.views.citystyle.form', $model );
		
        if ( is_null( $model->id ) ) 
        {
            $title = 'Нова стаття';
        } 
        else {
            $title = $model->title;
        }
        $this->breadcrumbs = array(
            'City - стиль' => '/admin/citystyle',
            $title
        );
		
		if ( isset( $_POST['CityStyle'] ) ) 
        {
            $model->attributes = $_POST['CityStyle'];
            
			if ( $model->validate( ) && $model->save( ) ) 
            {
            	if ( isset( $_REQUEST['id'] ) && $_REQUEST['id'] ) 
                {
                    $msg = 'Стаття успішно оновлена.';
                } 
                else {
                    $msg = 'Стаття успішно додана.';
                }
                Yii::app( )->user->setFlash( 'info', $msg );
				
				if ( !empty( $_POST['save'] ) || ( empty( $_POST['save'] ) && empty( $_POST['apply'] ) ) )
				{
					Yii::app( )
						->getRequest( )
                		->redirect( '/admin/citystyle' );
				}
				else {
					Yii::app( )
						->getRequest( )
                		->redirect( '/admin/citystyle/edit?id=' . $model->id );
				}
            }
        }
		
        $this->renderText( $form );
		return true;
    }

}
