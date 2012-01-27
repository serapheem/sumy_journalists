<?php

/**
 * Participants Controller Class
 */
class ParticipantsController extends AdminController 
{
	/**
	 * Name of default model
	 * 
	 * @access public
	 * @var string
	 */
	public $model = 'Participants';
	
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
        $form = new CForm( 'admin.views.participants.form', $model );
		
        if ( is_null( $model->id ) ) 
        {
            $title = 'Новий учасник';
        } 
        else {
            $title = $model->title;
        }
        $this->breadcrumbs = array(
            'Учасники' => '/admin/participants',
            $title
        );
		
		if ( isset( $_POST['Participants'] ) ) 
        {
            $model->attributes = $_POST['Participants'];
            
			if ( $model->validate( ) && $model->save( ) ) 
            {
            	if ( isset( $_REQUEST['id'] ) && $_REQUEST['id'] ) 
                {
                    $msg = 'Учасник успішно оновлений.';
                } 
                else {
                    $msg = 'Учасник успішно доданий.';
                }
                Yii::app( )->user->setFlash( 'info', $msg );
				
				if ( !empty( $_POST['save'] ) || ( empty( $_POST['save'] ) && empty( $_POST['apply'] ) ) )
				{
					Yii::app( )
						->getRequest( )
                		->redirect( '/admin/participants' );
				}
				else {
					Yii::app( )
						->getRequest( )
                		->redirect( '/admin/participants/edit?id=' . $model->id );
				}
            }
        }
		
        $this->renderText( $form );
		return true;
    }

}
