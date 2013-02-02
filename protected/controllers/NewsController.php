<?php
/**
 * Contains controller class of news
 */

/**
 * News Controller Class
 */
class NewsController extends AbstractController
{
    /**
     * {@inheritdoc}
     */
    protected $_modelClass = 'Items';
    
    /**
     * Identifier of the current category
     * @var int
     */
    protected $_catid = 3;
    
    
    /**
     * {@inheritdoc}
     */
    public function actionIndex()
    {
        if (!$this->_catid)
            throw new BadMethodCallException('Identifier of the category wasn\'t set!');
        
        $modelClass = $this->getModelClass();
        if (!class_exists($modelClass))
        {
            $this->_model = null;
            $dataProvider = null;
        }
        else
        {
            $this->_model = $this->loadModel(true, 'search');
            $this->_model->unsetAttributes(); // clear any default values
            if ($attributes = Yii::app()->request->getQuery($modelClass))
                $this->_model->attributes = $attributes;

            $this->_model->catid = $this->_catid;
            $this->_model->state = 1;
            $dataProvider = $this->_model->search($this->_itemsPerPage);
        }
        $this->render('list', array(
            'sectionId' => $this->getId(),
            'modelClass' => $modelClass,
            'itemPerPage' => $this->_itemsPerPage,
            'model' => $this->_model,
            'dataProvider' => $dataProvider
        ));
        
        //parent::actionIndex();
    }

    /**
     * Shows the selected item
     */
    public function actionShow()
    {
        $this->class = 'class="news"';
        
        $sectionId = $this->getId();
        $request = Yii::app()->request;
        
        $slug = $request->getParam('slug');
        $id = $request->getParam('id') ?: (int) $slug;
        $_GET['id'] = $id;
        
        $model = $this->loadModel(false);
        if (empty($model)) 
        {
            throw new CHttpException( 404, Yii::t( 'news', 'ITEM_NOT_FOUND' ) );
        }

        $this->title = $model->title;

        // Check if user view this item at first time
        if (Helper::isNewView('news', $model))
        {
            $model->views++;
            $model->save();
        }

        $model->body = Helper::addGallery($model->body);

        $this->render('news', array('record' => $model));
    }
    
}
