<?php

class PublicationsController extends AdminController 
{
    public function actionError() 
    {
        $error = Yii::app()->errorHandler->error;
        if ($error)
		{
            $this->render('error', $error);
		}
    }
    
    public function actionNews() 
    {
        $this->model = 'News';

        if (isset( $_GET['edit'] )) 
        {
            $this->actionNewsEdit();
            return true;
        }

        if (isset( $_POST['publish'] )) 
        {
            $this->actionNewsPublish();
            return true;
        }
        
        if (isset( $_POST['frontpage'] )) 
        {
            $this->actionNewsFrontpage();
            return true;
        }

        if (isset( $_POST['delete'] )) 
        {
            $this->actionNewsDelete();
            return true;
        } 
        else {
            $news = News::model()->ordering()->findAll();
            $this->render('index', array(
            					'data' => $news, 
            					'view' => 'news'
            				) 
						);
        }
    }

    private function actionNewsEdit() 
    {
        $model = $this->loadModel();
        $form = new CForm('admin.views.publications.news_form', $model);

        if (is_null($model->id)) 
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
		
		if ( !empty($model->id) )
		{
			$frontpage = Frontpage::model()->findByAttributes( array(
									'section' => 'News',
									'item_id' => $model->id
								) );
			if ( !empty($frontpage) )
			{
				$model->frontpage = 1;
			}
		}
        
        if (isset( $_POST['News'] )) 
        {
            $model->attributes = $_POST['News'];
            $model->modified = date('Y-m-d H:i:s');
			
			if (empty($model->id) || ($model->id == 0) ) 
			{
				$model->created = $model->modified;
			}

            if ($model->validate() && $model->save()) 
            {
            	// Add or delete news from front page
            	if ( !empty($_POST['News']['frontpage']) )
				{
					$frontpage_model = new Frontpage( );
					$frontpage_model->section = 'News';
					$frontpage_model->item_id = $model->id;
					if ( $frontpage_model->validate() )
					{
						$frontpage_model->save();
					}
				}
				else {
					Frontpage::model()->deleteAllByAttributes( array(
								'section' => 'News',
								'item_id' => $model->id
							));
				}
				
                if (isset($_POST['id']) && ($_POST['id'] != 0) ) 
                {
                    $msg = 'Новина успішно оновлена.';
                } 
                else {
                    $msg = 'Новина успішно додана.';
                }
                Yii::app()->user->setFlash('info', $msg);
                Yii::app()->getRequest()->redirect('/admin/publications/news');
            }
        }

        $this->renderText($form);
    }

    private function actionNewsPublish() 
    {
        if (isset($_POST['publish']) && $this->validateID($_POST['id']) ) 
        {
            News::model()->updateByPk
            (
                $_POST['id'], array(
                    'publish' => abs($_POST['publish'] - 1),
                )
            );
        }

        Yii::app()->getRequest()->redirect('/admin/publications/news');
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
    
    public function actionCityStyle() 
    {
        $this->model = 'CityStyle';

        if (isset($_GET['edit'])) 
        {
            $this->actionCityStyleEdit();
            return true;
        }

        if (isset($_POST['publish'])) 
        {
            $this->actionCityStylePublish();
            return true;
        }
        
        if (isset($_POST['delete'])) 
        {
            $this->actionCityStyleDelete();
            return true;
        } 
        else {
            $rows = CityStyle::model()->ordering()->findAll();
            $this->render('index', array('data' => $rows, 'view' => 'city_style'));
        }
    }

    private function actionCityStyleEdit() 
    {
        $model = $this->loadModel();
        $form = new CForm('admin.views.publications.city_style_form', $model);

        if (is_null($model->id)) 
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
        
        if (isset($_POST['CityStyle'])) 
        {
            $model->attributes = $_POST['CityStyle'];
            $model->modified = date('Y-m-d H:i:s');
			
			if ( empty($model->id) || !$model->id )
			{
				$model->created = date('Y-m-d H:i:s');
			}

            if ($model->validate() && $model->save()) 
            {
                if (isset($_POST['id']) && ($_POST['id'] != 0) ) 
                {
                    $msg = 'Стаття успішно оновлена.';
                } 
                else {
                    $msg = 'Стаття успішно додана.';
                }
                Yii::app()->user->setFlash('info', $msg);
                Yii::app()->getRequest()->redirect('/admin/publications/citystyle');
            }
        }

        $this->renderText($form);
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
    
    public function actionKnowOur() 
    {
        $this->model = 'KnowOur';

        if (isset( $_GET['edit'] )) 
        {
            $this->actionKnowOurEdit();
            return true;
        }

        if (isset( $_POST['publish'] )) 
        {
            $this->actionKnowOurPublish();
            return true;
        }
		
		if (isset( $_POST['frontpage'] )) 
        {
            $this->actionKnowOurFrontpage();
            return true;
        }
        
        if (isset( $_POST['delete'] )) 
        {
            $this->actionKnowOurDelete();
            return true;
        } 
        else {
            $rows = KnowOur::model()->ordering()->findAll();
            $this->render('index', 
	            			array(
	            				'data' => $rows, 
	            				'view' => 'know_our'
	            			)
						);
        }
    }

    private function actionKnowOurEdit() 
    {
        $model = $this->loadModel();
        $form = new CForm('admin.views.publications.know_our_form', $model);

        if (is_null($model->id)) 
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
		
		if ( !empty($model->id) )
		{
			$frontpage = Frontpage::model()->findByAttributes( array(
									'section' => 'KnowOur',
									'item_id' => $model->id
								) );
			if ( !empty($frontpage) )
			{
				$model->frontpage = 1;
			}
		}
        
        if (isset( $_POST['KnowOur'] )) 
        {
            $model->attributes = $_POST['KnowOur'];
            $model->modified = date('Y-m-d H:i:s');
			
            if ( empty($model->id) || !$model->id )
			{
				$model->created = date('Y-m-d H:i:s');
			}
            
            if ($model->validate() && $model->save()) 
            {
            	// Add or delete news from front page
            	if ( !empty($_POST['KnowOur']['frontpage']) )
				{
					$frontpage_model = new Frontpage( );
					$frontpage_model->section = 'KnowOur';
					$frontpage_model->item_id = $model->id;
					if ( $frontpage_model->validate() )
					{
						$frontpage_model->save();
					}
				}
				else {
					Frontpage::model()->deleteAllByAttributes( array(
								'section' => 'KnowOur',
								'item_id' => $model->id
							));
				}
				
                if (isset($_POST['id']) && $_POST['id'] != 0) 
                {
                    $msg = 'Особа успішно оновлена.';
                } 
                else {
                    $msg = 'Особа успішно додана.';
                }
                Yii::app()->user->setFlash('info', $msg);
                Yii::app()->getRequest()->redirect('/admin/publications/knowour');
            }
        }

        $this->renderText($form);
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
    
    public function actionTyca() 
    {
        $this->model = 'Tyca';

        if (isset($_GET['edit'])) 
        {
            $this->actionTycaEdit();
            return true;
        }

        if (isset($_POST['publish'])) 
        {
            $this->actionTycaPublish();
            return true;
        }
        
        if (isset($_POST['delete'])) 
        {
            $this->actionTycaDelete();
            return true;
        } 
        else {
            $rows = Tyca::model()->ordering()->findAll();
            $this->render('index', array(
            						'data' => $rows, 
            						'view' => 'tyca'
            					)
							);
        }
    }

    private function actionTycaEdit() 
    {
        $model = $this->loadModel();
        $form = new CForm('admin.views.publications.tyca_form', $model);

        if (is_null($model->id)) 
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
        
        if (isset($_POST['Tyca'])) 
        {
            $model->attributes = $_POST['Tyca'];
            $model->modified = date('Y-m-d H:i:s');
			
			if ( empty($model->id) || !$model->id )
			{
				$model->created = date('Y-m-d H:i:s');
			}

            if ($model->validate() && $model->save()) 
            {
                if (isset($_POST['id']) && ($_POST['id'] != 0) ) 
                {
                    $msg = 'Подія успішно оновлена.';
                } 
                else {
                    $msg = 'Подія успішно додана.';
                }
                Yii::app()->user->setFlash('info', $msg);
                Yii::app()->getRequest()->redirect('/admin/publications/tyca');
            }
        }

        $this->renderText($form);
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
	
	public function actionParticipants()
    {
        $this->model = 'Participants';

        if (isset( $_GET['edit'] )) 
        {
            $this->actionParticipantsEdit();
            return true;
        }

        if (isset( $_POST['publish'] )) 
        {
            $this->actionParticipantsPublish();
            return true;
        }
		
		if (isset( $_POST['top10'] )) 
        {
            $this->actionParticipantsTop10();
            return true;
        }
        
        if (isset( $_POST['delete'] )) 
        {
            $this->actionParticipantsDelete();
            return true;
        } 
        else {
            $rows = Participants::model()->ordering()->findAll();
            $this->render('index', 
	            			array(
	            				'data' => $rows, 
	            				'view' => 'participants'
	            			)
						);
        }
    }

    private function actionParticipantsEdit() 
    {
        $model = $this->loadModel();
        $form = new CForm('admin.views.publications.participants_form', $model);

        if (is_null($model->id)) 
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
        
        if (isset( $_POST['Participants'] )) 
        {
            $model->attributes = $_POST['Participants'];
            $model->modified = date('Y-m-d H:i:s');
            
            if ( empty($model->id) || ($model->id == 0) ) 
            {
                $model->created = $model->modified;
            }

            if ($model->validate() && $model->save()) 
            {
                if (isset($_POST['id']) && $_POST['id'] != 0) 
                {
                    $msg = 'Учасник успішно оновлений.';
                } 
                else {
                    $msg = 'Учасник успішно доданий.';
                }
                Yii::app()->user->setFlash('info', $msg);
                Yii::app()->getRequest()->redirect('/admin/publications/participants');
            }
        }

        $this->renderText($form);
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