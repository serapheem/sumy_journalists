<?php

/**
 * Class describes all the events associated with basic Site operations
 */
class SiteController extends Controller 
{
    public function actionIndex() 
    {
    	$command = Yii::app()->db->createCommand();
        $news = $command->selectDistinct('tbl.*, f.section')
						->from('news tbl')
						->join('frontpage f', 'f.item_id = tbl.id')
						->where( array('AND', 'f.section = :section', 'tbl.publish = 1'),
								array(':section' => 'News') )
						->order('tbl.ordering ASC')
						->queryAll();
		
		$command->reset();
		$know_our = $command->selectDistinct('tbl.*, f.section')
						->from('know_our tbl')
						->join('frontpage f', 'f.item_id = tbl.id')
						->where( array('AND', 'f.section = :section', 'tbl.publish = 1'),
								array(':section' => 'KnowOur') )
						->order('tbl.ordering ASC')
						->queryAll();
						
		$news = array_merge($news, $know_our);
		
		foreach ($news AS $index => &$news_)
		{
			$news_ = (object) $news_;
		}
		
        $this->render('index', array('news' => $news) );
    }

    public function actionNews() 
    {
        if (isset($_GET['id'])) 
        {
            $this->class = 'class="contentBody"';

            $news = News::model()->findByPk($_GET['id']);

            if (empty($news)) 
            {
                throw new CHttpException(404, 'Зазначена новина не знайдена.');
            }

            $this->title = $news->title;
            
            // Check if user view this item at first time
            if (Helper::isNewView('news', $news))
            {
                $news->views++;
                $news->save();
            }
            
            $news->body = Helper::addGallery($news->body);

            $this->render('news', array('news' => $news) );
        } 
        else {
            $this->title = 'Новини';
            $news = News::model()->published()->findAll();
            
            $this->render('articles', array('rows' => $news, 'view' => 'news') );
        }
    }

    public function actionKnowOur() 
    {
        if (isset($_GET['id'])) 
        {
            $this->class = 'class="contentBody"';

            $record = KnowOur::model()->findByPk($_GET['id']);

            if (empty($record)) 
            {
                throw new CHttpException(404, 'Зазначена особа не знайдена.');
            }

            $this->title = $record->title;
            
            // Check if user view this item at first time
            if (Helper::isNewView('know_our', $record))
            {
                $record->views++;
                $record->save();
            }
            
            $record->body = Helper::addGallery($record->body);
            
            $this->render('know_our', array('record' => $record) );
        } 
        else {
            $this->title = 'Знай наших';
            $this->class = 'class="knowour"';

            $rows = KnowOur::model()->published()->findAll();
            $this->render('persons', array('rows' => $rows, 'view' => 'knowour') );
        }
    }

    public function actionCityStyle() 
    {
        if (isset($_GET['id'])) 
        {
            $this->class = 'class="contentBody"';

            $record = CityStyle::model()->findByPk($_GET['id']);

            if (empty($record)) 
            {
                throw new CHttpException(404, 'Зазначена стаття не знайдена.');
            }

            $this->title = $record->title;
            
            // Check if user view this item at first time
            if (Helper::isNewView('city_style', $record))
            {
                $record->views++;
                $record->save();
            }
            
            $record->body = Helper::addGallery($record->body);
            
			$this->render('city_style', array('record' => $record) );
        } 
        else {
            $this->title = 'City стиль';
            $this->class = 'class="citystyle"';

            $city_style = CityStyle::model()->published()->findAll();
            $this->render('articles', array('rows' => $city_style, 'view' => 'citystyle') );
        }
    }

    public function actionTyca() 
    {
        if (isset($_GET['id'])) 
        {
            $this->class = 'class="contentBody"';

            $record = Tyca::model()->findByPk($_GET['id']);

            if (empty($record)) 
            {
                throw new CHttpException(404, 'Зазначена подія не знайдена.');
            }

            $this->title = $record->title;
            
            // Check if user view this item at first time
            if (Helper::isNewView('tyca', $record))
            {
                $record->views++;
                $record->save();
            }
            
            $record->body = Helper::addGallery($record->body);
            
            $this->render('tyca', array('record' => $record) );
        } 
        else {
            $this->title = 'Tyca';
            $this->class = 'class="tyca"';

            $rows = Tyca::model()->published()->findAll();
            $this->render('persons', array('rows' => $rows, 'view' => 'tyca') );
        }
    }

    public function actionPage() 
    {
        $this->class = 'class="pageBox"';

        $row = Pages::model()->find('seo=?', array($_GET['page']));

        if ( empty($row) )
		{
            throw new CHttpException(404, 'На жаль, сторінка не знайдена.');
		}

        $this->title = $row->title;

        $this->renderText($row->body);
    }

    public function actionError() 
    {
        $this->class = 'class="errorBox"';

        $error = Yii::app()->errorHandler->error;
        if ($error) 
        {
            if (Yii::app()->request->isAjaxRequest)
			{
                echo $error['message'];
			} 
			else {
                $this->render('error', $error);
			}
        }
    }
}