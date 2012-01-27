<?php

/**
 * Know Our Controller Class
 */
class KnowOurController extends AdminController 
{
	/**
	 * Name of default model
	 * 
	 * @access public
	 * @var string
	 */
	public $model = 'KnowOur';
	
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
        $form = new CForm( 'admin.views.knowour.form', $model );
		
        if ( is_null( $model->id ) ) 
        {
            $title = 'Нова особа';
        } 
        else {
            $title = $model->title;
        }
        $this->breadcrumbs = array(
            'Знай наших' => '/admin/knowour',
            $title
        );
		
		$frontpage = null;
		if ( $model->id )
		{
			$frontpage = Frontpage::model( )
				->findByAttributes( array(
					'section' => 'KnowOur',
					'item_id' => $model->id
				) );
			if ( $frontpage )
			{
				$model->frontpage = 1;
			}
		}
		if ( !isset( $model->frontpage ) )
		{
			$model->frontpage = 0;
		}
         
        if ( isset( $_POST['KnowOur'] ) ) 
        {
            $model->attributes = $_POST['KnowOur'];
            
			if ( $model->validate( ) && $model->save( ) ) 
            {
            	// Add or delete news from front page
            	if ( $model->frontpage && is_null( $frontpage ) )
				{
					$frontpage_model = new Frontpage( );
					$frontpage_model->section = 'KnowOur';
					$frontpage_model->item_id = $model->id;
					if ( $frontpage_model->validate( ) )
					{
						$frontpage_model->save( );
					}
				}
				elseif ( !$model->frontpage ) 
				{
					Frontpage::model( )
						->deleteAllByAttributes( array(
							'section' => 'KnowOur',
							'item_id' => $model->id
						));
				}
				
                if ( isset( $_REQUEST['id'] ) && $_REQUEST['id'] ) 
                {
                    $msg = 'Особа успішно оновлена.';
                } 
                else {
                    $msg = 'Особа успішно додана.';
                }
                Yii::app( )->user->setFlash( 'info', $msg );
				
				if ( !empty( $_POST['save'] ) || ( empty( $_POST['save'] ) && empty( $_POST['apply'] ) ) )
				{
					Yii::app( )
						->getRequest( )
                		->redirect( '/admin/knowour' );
				}
				else {
					Yii::app( )
						->getRequest( )
                		->redirect( '/admin/knowour/edit?id=' . $model->id );
				}
            }
        }
		
        $this->renderText( $form );
		return true;
    }

}
