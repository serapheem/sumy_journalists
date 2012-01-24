<?php

/**
 * Publications Controller Class
 */
class PublicationsController extends AdminController 
{
	/**
	 * Manages error page
	 * 
	 * @access public
	 * 
	 * @return void
	 */
    public function actionError( ) 
    {
        $error = Yii::app( )->errorHandler->error;
        if ( $error )
		{
            $this->render( 'error', $error );
		}
		return true;
    }
    
	/**
	 * Manages the operation with news
	 * 
	 * @access public
	 * 
	 * @return void
	 */
    public function actionNews( ) 
    {
        $this->model = 'News';

        if ( isset( $_GET['edit'] ) ) 
        {
            $this->actionNewsEdit( );
        }
		elseif ( isset( $_POST['publish'] ) ) 
        {
            $this->actionNewsPublish( );
        }
		elseif ( isset( $_POST['frontpage'] ) ) 
        {
            $this->actionNewsFrontpage( );
        }
		elseif ( isset( $_POST['delete'] ) ) 
        {
            $this->actionNewsDelete( );
        } 
        else {
            $news = News::model( )->ordering( )->findAll( );
            $this->render( 'index', array(
				'data' => $news, 
				'view' => 'news'
			) );
        }
		return true;
    }

	/**
	 * Manages edit operaion with news
	 * 
	 * @access private
	 * 
	 * @return void
	 */
    private function actionNewsEdit( ) 
    {
    	// Check the identifier
    	if ( !isset( $_POST['id'] ) && $this->validateID( $_GET['edit'], false ) )
		{
			$_POST['id'] = $_GET['edit'];
		}
		
        $model = $this->loadModel( );
        $form = new CForm( 'admin.views.publications.news_form', $model );

        if ( is_null( $model->id ) ) 
        {
            $title = 'Нова новина';
        } 
        else {
            $title = $model->title;
        }
        $this->breadcrumbs = array(
            'Новини' => '/admin/publications/news',
            $title
        );
		
		if ( $model->id )
		{
			$frontpage = Frontpage::model( )->findByAttributes( array(
				'section' => 'News',
				'item_id' => $model->id
			) );
			if ( $frontpage )
			{
				$model->frontpage = 1;
			}
		}
        
        if ( isset( $_POST['News'] ) ) 
        {
            $model->attributes = $_POST['News'];
            $model->modified = date( 'Y-m-d H:i:s' );
			
			if ( empty( $model->id ) || !$model->id ) 
			{
				$model->created = $model->modified;
			}
			if ( !$model->alias )
			{
				$model->alias = Helper::translit( $model->title );
			}
			else {
				$model->alias = Helper::translit( $model->alias );
			}

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
					Frontpage::model( )->deleteAllByAttributes( array(
						'section' => 'News',
						'item_id' => $model->id
					));
				}
				
                if ( isset( $_POST['id'] ) && $_POST['id'] ) 
                {
                    $msg = 'Новина успішно оновлена.';
                } 
                else {
                    $msg = 'Новина успішно додана.';
                }
                Yii::app( )->user
                	->setFlash( 'info', $msg );
				
				if ( !empty( $_POST['save'] ) )
				{
					Yii::app( )->getRequest( )
                		->redirect( '/admin/publications/news' );
				}
				else {
					Yii::app( )->getRequest( )
                		->redirect( '/admin/publications/news/edit/' . $model->id );
				}
            }
        }

        $this->renderText( $form );
		return true;
    }

	/**
	 * Publishes news
	 * 
	 * @access private
	 * 
	 * @return void
	 */
    private function actionNewsPublish( ) 
    {
        if ( isset( $_POST['publish'] ) && $this->validateID( $_POST['id'] ) ) 
        {
            News::model( )->updateByPk( $_POST['id'], 
            	array(
	                'publish' => abs( $_POST['publish'] - 1 )
	            ) 
			);
        }

        Yii::app( )->getRequest( )
        	->redirect( '/admin/publications/news' );
		return true;
    }
    
    private function actionNewsFrontpage() 
    {
        if (isset($_POST['frontpage']) && $this->validateID($_POST['id']) ) 
        {
        	$id = (int) $_POST['id'];
        	if ($_POST['frontpage'])
			{
				$model = new Frontpage( );
				$model->section = 'News';
				$model->item_id = $id;
				if ( $model->validate() )
				{
					$model->save();
				}
			}
			else {
				Frontpage::model()->deleteAllByAttributes( array(
							'section' => 'News',
							'item_id' => $id
						));
			}
        }

        Yii::app()->getRequest()->redirect('/admin/publications/news');
    }

    private function actionNewsDelete() 
    {
        if (isset($_POST['delete']) && (sizeof($_POST['delete']) > 0) ) 
        {
            foreach ($_POST['delete'] as $id)
			{
                News::model()->deleteByPk($id);
			}

            Yii::app()->user->setFlash('info', 'Новини успішно видалені.');
        }

        Yii::app()->getRequest()->redirect('/admin/publications/news');
    }
    
	/**
	 * Manages the operation with city style items
	 * 
	 * @access public
	 * 
	 * @return void
	 */
    public function actionCityStyle( ) 
    {
        $this->model = 'CityStyle';

        if ( isset( $_GET['edit'] ) ) 
        {
            $this->actionCityStyleEdit( );
        }
		elseif ( isset( $_POST['publish'] ) ) 
        {
            $this->actionCityStylePublish( );
        }
		elseif ( isset( $_POST['delete'] ) ) 
        {
            $this->actionCityStyleDelete( );
        } 
        else {
            $rows = CityStyle::model()->ordering( )
            	->findAll( );
            $this->render( 'index', array( 
            	'data' => $rows, 
            	'view' => 'city_style' 
			) );
        }
		return true;
    }

	/**
	 * Manages edit operaion with city style items
	 * 
	 * @access private
	 * 
	 * @return void
	 */
    private function actionCityStyleEdit( ) 
    {
    	// Check the identifier
    	if ( !isset( $_POST['id'] ) && $this->validateID( $_GET['edit'], false ) )
		{
			$_POST['id'] = $_GET['edit'];
		}
		
        $model = $this->loadModel( );
        $form = new CForm( 'admin.views.publications.city_style_form', $model );

        if ( is_null( $model->id ) ) 
        {
            $title = 'Додати статтю';
        } 
        else {
            $title = $model->title;
        }
        $this->breadcrumbs = array(
            'City - стиль' => '/admin/publications/citystyle',
            $title
        );
        
        if ( isset( $_POST['CityStyle'] ) ) 
        {
            $model->attributes = $_POST['CityStyle'];
            $model->modified = date( 'Y-m-d H:i:s' );
			
			if ( empty( $model->id ) || !$model->id )
			{
				$model->created = $model->modified;
			}
			if ( !$model->alias )
			{
				$model->alias = Helper::translit( $model->title );
			}
			else {
				$model->alias = Helper::translit( $model->alias );
			}

            if ( $model->validate() && $model->save( ) ) 
            {
                if ( isset( $_POST['id'] ) && $_POST['id'] ) 
                {
                    $msg = 'Стаття успішно оновлена.';
                } 
                else {
                    $msg = 'Стаття успішно додана.';
                }
                Yii::app()->user
                	->setFlash( 'info', $msg );
				
				if ( !empty( $_POST['save'] ) )
				{
					Yii::app( )->getRequest( )
                		->redirect( '/admin/publications/citystyle' );
				}
				else {
					Yii::app( )->getRequest( )
                		->redirect( '/admin/publications/citystyle/edit/' . $model->id );
				}
            }
        }

        $this->renderText($form);
		return true;
    }

    private function actionCityStylePublish() 
    {
        if (isset($_POST['publish']) && $this->validateID($_POST['id']) ) 
        {
            CityStyle::model()->updateByPk( $_POST['id'], 
            	array(
                    'publish' => abs($_POST['publish'] - 1),
                )
            );
        }

        Yii::app()->getRequest()->redirect('/admin/publications/citystyle');
    }
    
    private function actionCityStyleDelete() 
    {
        if (isset($_POST['delete']) && (sizeof($_POST['delete']) > 0) ) 
        {
            foreach ($_POST['delete'] as $id)
			{
                CityStyle::model()->deleteByPk($id);
			}

            Yii::app()->user->setFlash('info', 'Статті успішно видалені.');
        }

        Yii::app()->getRequest()->redirect('/admin/publications/citystyle');
    }
    
	/**
	 * Manages the operation with news
	 * 
	 * @access public
	 * 
	 * @return void
	 */
    public function actionKnowOur( ) 
    {
        $this->model = 'KnowOur';

        if ( isset( $_GET['edit'] ) ) 
        {
            $this->actionKnowOurEdit( );
        }
		elseif ( isset( $_POST['publish'] ) ) 
        {
            $this->actionKnowOurPublish( );
        }
		elseif (isset( $_POST['frontpage'] )) 
        {
            $this->actionKnowOurFrontpage();
        }
		elseif (isset( $_POST['delete'] )) 
        {
            $this->actionKnowOurDelete();
        } 
        else {
            $rows = KnowOur::model()->ordering()
            	->findAll();
            $this->render('index', array(
				'data' => $rows, 
				'view' => 'know_our'
			) );
        }
    }

	/**
	 * Manages edit operaion with know our items
	 * 
	 * @access private
	 * 
	 * @return void
	 */
    private function actionKnowOurEdit() 
    {
    	// Check the identifier
    	if ( !isset( $_POST['id'] ) && $this->validateID( $_GET['edit'], false ) )
		{
			$_POST['id'] = $_GET['edit'];
		}
		$model = $this->loadModel();
        $form = new CForm('admin.views.publications.know_our_form', $model);

        if ( is_null( $model->id ) ) 
        {
            $title = 'Нова особа';
        } 
        else {
            $title = $model->title;
        }
        $this->breadcrumbs = array(
            'Знай наших' => '/admin/publications/knowour',
            $title
        );
		
		if ( $model->id )
		{
			$frontpage = Frontpage::model( )->findByAttributes( array(
				'section' => 'KnowOur',
				'item_id' => $model->id
			) );
			if ( $frontpage )
			{
				$model->frontpage = 1;
			}
		}
        
        if ( isset( $_POST['KnowOur'] ) ) 
        {
            $model->attributes = $_POST['KnowOur'];
            $model->modified = date( 'Y-m-d H:i:s' );
			
            if ( empty( $model->id ) || !$model->id )
			{
				$model->created = $model->modified;
			}
			if ( !$model->alias )
			{
				$model->alias = Helper::translit( $model->title );
			}
			else {
				$model->alias = Helper::translit( $model->alias );
			}
            
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
					Frontpage::model()->deleteAllByAttributes( array(
						'section' => 'KnowOur',
						'item_id' => $model->id
					));
				}
				
                if ( isset($_POST['id']) && $_POST['id'] ) 
                {
                    $msg = 'Особа успішно оновлена.';
                } 
                else {
                    $msg = 'Особа успішно додана.';
                }
                Yii::app()->user
                	->setFlash('info', $msg);
				
				if ( !empty( $_POST['save'] ) )
				{
					Yii::app( )->getRequest( )
                		->redirect( '/admin/publications/knowour' );
				}
				else {
					Yii::app( )->getRequest( )
                		->redirect( '/admin/publications/knowour/edit/' . $model->id );
				}
            }
        }

        $this->renderText($form);
		return true;
    }

    private function actionKnowOurPublish() 
    {
        if (isset($_POST['publish']) && $this->validateID($_POST['id']) ) 
        {
            KnowOur::model()->updateByPk
            (
                $_POST['id'], array(
                    'publish' => abs($_POST['publish'] - 1),
                )
            );
        }

        Yii::app()->getRequest()->redirect('/admin/publications/knowour');
    }
	
	private function actionKnowOurFrontpage() 
    {
        if (isset($_POST['frontpage']) && $this->validateID($_POST['id']) ) 
        {
        	$id = (int) $_POST['id'];
        	if ($_POST['frontpage'])
			{
				$model = new Frontpage( );
				$model->section = 'KnowOur';
				$model->item_id = $id;
				if ( $model->validate() )
				{
					$model->save();
				}
			}
			else {
				Frontpage::model()->deleteAllByAttributes( array(
							'section' => 'KnowOur',
							'item_id' => $id
						));
			}
        }

        Yii::app()->getRequest()->redirect('/admin/publications/knowour');
    }
    
    private function actionKnowOurDelete() 
    {
        if (isset($_POST['delete']) && (sizeof($_POST['delete']) > 0) ) 
        {
            foreach ($_POST['delete'] as $id)
			{
                KnowOur::model()->deleteByPk($id);
			}

            Yii::app()->user->setFlash('info', 'Особи успішно видалені.');
        }

        Yii::app()->getRequest()->redirect('/admin/publications/knowour');
    }
    
	/**
	 * Manages the operation with news
	 * 
	 * @access public
	 * 
	 * @return void
	 */
    public function actionTyca( ) 
    {
        $this->model = 'Tyca';

        if ( isset( $_GET['edit'] ) ) 
        {
            $this->actionTycaEdit();
        }
		elseif ( isset( $_POST['publish'] ) ) 
        {
            $this->actionTycaPublish();
        }
		elseif ( isset( $_POST['delete'] ) ) 
        {
            $this->actionTycaDelete();
        } 
        else {
            $rows = Tyca::model()->ordering()
            	->findAll();
            $this->render('index', array(
				'data' => $rows, 
				'view' => 'tyca'
			) );
        }
		return true;
    }

	/**
	 * Manages edit operaion with news
	 * 
	 * @access private
	 * 
	 * @return void
	 */
    private function actionTycaEdit() 
    {
    	// Check the identifier
    	if ( !isset( $_POST['id'] ) && $this->validateID( $_GET['edit'], false ) )
		{
			$_POST['id'] = $_GET['edit'];
		}
		
        $model = $this->loadModel( );
        $form = new CForm( 'admin.views.publications.tyca_form', $model );

        if ( is_null( $model->id ) ) 
        {
            $title = 'Нова подія';
        } 
        else {
            $title = $model->title;
        }
        $this->breadcrumbs = array(
            'Tyca' => '/admin/publications/tyca',
            $title
        );
        
        if ( isset( $_POST['Tyca'] ) ) 
        {
            $model->attributes = $_POST['Tyca'];
            $model->modified = date( 'Y-m-d H:i:s' );
			
			if ( empty($model->id) || !$model->id )
			{
				$model->created = $model->modified;
			}
			if ( !$model->alias )
			{
				$model->alias = Helper::translit( $model->title );
			}
			else {
				$model->alias = Helper::translit( $model->alias );
			}

            if ( $model->validate( ) && $model->save( ) ) 
            {
                if ( isset( $_POST['id'] ) && $_POST['id'] ) 
                {
                    $msg = 'Подія успішно оновлена.';
                } 
                else {
                    $msg = 'Подія успішно додана.';
                }
                Yii::app()->user
                	->setFlash( 'info', $msg );
					
				if ( !empty( $_POST['save'] ) )
				{
					Yii::app( )->getRequest( )
                		->redirect( '/admin/publications/tyca' );
				}
				else {
					Yii::app( )->getRequest( )
                		->redirect( '/admin/publications/tyca/edit/' . $model->id );
				}
            }
        }

        $this->renderText($form);
		return true;
    }

    private function actionTycaPublish() 
    {
        if (isset($_POST['publish']) && $this->validateID($_POST['id']) ) 
        {
            Tyca::model()->updateByPk($_POST['id'], 
            			array(
		                    'publish' => abs($_POST['publish'] - 1),
		                )
            		);
        }

        Yii::app()->getRequest()->redirect('/admin/publications/tyca');
    }
    
    private function actionTycaDelete() 
    {
        if (isset($_POST['delete']) && (sizeof($_POST['delete']) > 0) ) 
        {
            foreach ($_POST['delete'] as $id)
			{
                Tyca::model()->deleteByPk($id);
			}

            Yii::app()->user->setFlash('info', 'Події успішно видалені.');
        }

        Yii::app()->getRequest()->redirect('/admin/publications/tyca');
    }
	
	/**
	 * Manages the operation with participants
	 * 
	 * @access public
	 * 
	 * @return void
	 */
	public function actionParticipants()
    {
        $this->model = 'Participants';

        if ( isset( $_GET['edit'] ) ) 
        {
            $this->actionParticipantsEdit();
        }
		elseif ( isset( $_POST['publish'] ) ) 
        {
            $this->actionParticipantsPublish();
        }
		elseif ( isset( $_POST['top10'] ) ) 
        {
            $this->actionParticipantsTop10();
        }
		elseif ( isset( $_POST['delete'] ) ) 
        {
            $this->actionParticipantsDelete();
        } 
        else {
            $rows = Participants::model()->ordering()
            	->findAll();
            $this->render('index', array(
				'data' => $rows, 
				'view' => 'participants'
			) );
        }
		return true;
    }

	/**
	 * Manages edit operaion with participants
	 * 
	 * @access private
	 * 
	 * @return void
	 */
    private function actionParticipantsEdit() 
    {
    	// Check the identifier
    	if ( !isset( $_POST['id'] ) && $this->validateID( $_GET['edit'], false ) )
		{
			$_POST['id'] = $_GET['edit'];
		}

        $model = $this->loadModel( );
        $form = new CForm( 'admin.views.publications.participants_form', $model );

        if ( is_null( $model->id ) ) 
        {
            $title = 'Новий учасник';
        } 
        else {
            $title = $model->title;
        }
        $this->breadcrumbs = array(
            'Учасники' => '/admin/publications/participants',
            $title
        );
        
        if ( isset( $_POST['Participants'] ) ) 
        {
            $model->attributes = $_POST['Participants'];
            $model->modified = date( 'Y-m-d H:i:s' );
            
            if ( empty($model->id) || !$model->id ) 
            {
                $model->created = $model->modified;
            }
			if ( !$model->alias )
			{
				$model->alias = Helper::translit( $model->title );
			}
			else {
				$model->alias = Helper::translit( $model->alias );
			}

            if ( $model->validate( ) && $model->save( ) ) 
            {
                if ( isset( $_POST['id'] ) && $_POST['id'] ) 
                {
                    $msg = 'Учасник успішно оновлений.';
                } 
                else {
                    $msg = 'Учасник успішно доданий.';
                }
                Yii::app()->user
                	->setFlash('info', $msg);
					
				if ( !empty( $_POST['save'] ) )
				{
					Yii::app( )->getRequest( )
                		->redirect( '/admin/publications/participants' );
				}
				else {
					Yii::app( )->getRequest( )
                		->redirect( '/admin/publications/participants/edit/' . $model->id );
				}
            }
        }

        $this->renderText($form);
		return true;
    }

    private function actionParticipantsPublish() 
    {
        if (isset($_POST['publish']) && $this->validateID($_POST['id']) ) 
        {
            Participants::model()->updateByPk
            (
                $_POST['id'], array(
                    'publish' => abs($_POST['publish'] - 1),
                )
            );
        }

        Yii::app()->getRequest()->redirect('/admin/publications/participants');
    }
	
	private function actionParticipantsTop10() 
    {
        if (isset($_POST['top10']) && $this->validateID($_POST['id']) ) 
        {
            Participants::model()->updateByPk(
                $_POST['id'], array(
                    'top10' => abs($_POST['top10'] - 1),
                )
            );
        }

        Yii::app()->getRequest()->redirect('/admin/publications/participants');
    }
    
    private function actionParticipantsDelete() 
    {
        if (isset($_POST['delete']) && (sizeof($_POST['delete']) > 0) ) 
        {
            foreach ($_POST['delete'] as $id)
			{
                Participants::model()->deleteByPk($id);
			}

            Yii::app()->user->setFlash('info', 'Учасники успішно видалені.');
        }

        Yii::app()->getRequest()->redirect('/admin/publications/knowour');
    }
    
    public function actionSaveOrder() 
    {
        $order = $_POST['order'];
        $model = $_POST['model'];
        
        if (!empty($order) && is_array($order)) 
        {
            foreach ($order as $k => $value) 
            {
                $record = $model::model()->findByPk($k);
                
                if ($record->ordering != $value) 
                {
                    $record->ordering = $value;
                    $record->save();
                }
            }
        }

        $this->reorder($model);
        
        Yii::app()->user->setFlash('info', 'Новий порядок збережений.');
        Yii::app()->getRequest()->redirect('/admin/publications/' . strtolower($model));
    }

    public function actionChangeOrder() 
    {
        $id = $_POST['id'];
        $type = $_POST['type'];
        $model = $_POST['model'];
        
        if (!empty($type) && $this->validateID($id)) 
        {
            $record = $model::model()->findByPk($id);

            if ($type == 'up' && ($record->ordering > 1) ) 
            {
                $record->ordering -= 2;
                $record->save();
            } 
            elseif ($type == 'down') 
            {
                $record->ordering += 2;
                $record->save();
            }
        }

        $this->reorder($model);

        Yii::app()->getRequest()->redirect('/admin/publications/' . strtolower($model));
    }

    private function reorder($model) 
    {
        $rows = $model::model()->ordering()->findAll();

        if (!empty($rows)) 
        {
            for ($i = 0, $n = count($rows); $i < $n; $i++) 
            {
                if ($rows[$i]->ordering != $i + 1) 
                {
                    $rows[$i]->ordering = $i + 1;
                    $rows[$i]->save();
                }
            }
        }

        return true;
    }

    
}