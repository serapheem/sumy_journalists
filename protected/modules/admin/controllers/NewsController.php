<?php

/**
 * News Controller Class
 */
class NewsController extends AdminController 
{
	/**
	 * Name of default model
	 * 
	 * @access public
	 * @var string
	 */
	public $model = 'News';
	
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
		$form = new CForm( 'admin.views.news.form', $model );
		
		if ( is_null( $model->id ) ) 
		{
			$title = 'Нова новина';
		} 
		else {
			$title = $model->title;
		}
		$this->breadcrumbs = array(
			'Новини' => '/admin/news',
			$title
		);
		
		$frontpage = null;
		if ( $model->id )
		{
			$frontpage = Frontpage::model( )
				->findByAttributes( array(
					'section' => 'News',
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
		 
		if ( isset( $_POST['News'] ) ) 
		{
			$model->attributes = $_POST['News'];
			
			if ( $model->validate( ) && $model->save( ) ) 
			{
				// Add or delete news from front page
				if ( $model->frontpage && is_null( $frontpage ) )
				{
					$frontpage_model = new Frontpage( );
					$frontpage_model->section = 'News';
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
							'section' => 'News',
							'item_id' => $model->id
						));
				}
				
				if ( isset( $_REQUEST['id'] ) && $_REQUEST['id'] ) 
				{
					$msg = 'Новина успішно оновлена.';
				} 
				else {
					$msg = 'Новина успішно додана.';
				}
				Yii::app( )->user->setFlash( 'info', $msg );
				
				if ( !empty( $_POST['save'] ) || ( empty( $_POST['save'] ) && empty( $_POST['apply'] ) ) )
				{
					Yii::app( )
						->getRequest( )
						->redirect( '/admin/news' );
				}
				else {
					Yii::app( )
						->getRequest( )
						->redirect( '/admin/news/edit?id=' . $model->id );
				}
			}
		}
		
		$this->renderText( $form );
		return true;
	}

}
