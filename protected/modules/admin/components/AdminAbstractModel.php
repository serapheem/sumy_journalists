<?php
/**
 * Contains abstract model for admin module
 */
/**
 * Admin Abstract Model class
 */
abstract class AdminAbstractModel extends CActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function __construct($scenario = 'insert')
    {
        parent::__construct($scenario);

        // TODO : read more about that
        //$this->attachEventHandler( 'beforeSave', '' );
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        // TODO : do something with it
        return array(
            array('title, description', 'required'),
            array('title, alias, description, parent_id, state, section, params, metakey, metadesc, metadata', 'safe'),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        // TODO : do something with it
        return array(
            'title' => Yii::t('main', 'TITLE'),
            'alias' => Yii::t('main', 'ALIAS'),
            'body' => Yii::t('main', 'TEXT'),
            'publish' => Yii::t('main', 'PUBLISH'),
            'frontpage' => Yii::t('main', 'FEATURED'),
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function beforeSave()
    {
        $allowedActions = array('insert', 'update');
        if (in_array($this->getScenario(), $allowedActions))
        {
            $this->title = trim($this->title);
            
            $this->modified_at = date('Y-m-d H:i:s');
            $this->modified_by = Yii::app()->user->id;

            if ($this->isNewRecord || empty($this->created_at))
            {
                $this->created_at = $this->modified_at;
            }
            if ($this->isNewRecord || empty($this->created_by))
            {
                $this->created_by = $this->modified_by;
            }

            // TODO : always need to use this class
            if (!$this->alias)
            {
                $this->alias = TranslitHelper::perform($this->title);
            }
            else
            {
                $this->alias = TranslitHelper::perform($this->alias);
            }
        }

        return parent::beforeSave();
    }

    /**
     * @param int $parentId Identifier of the parent category
     * @return array The list of categories for filter
     */
    public function getCatidFilterValues($parentId = null)
    {
        $attrs = array('state' => 1);
        if ($parentId)
        {
            $attrs['parent_id'] = $parentId;
        }
        $items = Categories::model()->findAllByAttributes($attrs);
        
        $result = array();
        foreach ($items as $item)
        {
            $result[$item->id] = $item->title;
        }
        return $result;
    }

    /**
     * @return array The list of possible state values for filter
     */
    public function getStateFilterValues()
    {
        return array(
            1 => Yii::t('main', 'admin.list.filter.state.published'), 
            0 => Yii::t('main', 'admin.list.filter.state.unpublished')
        );
    }

    /**
     * @return array The list of possible state values
     */
    public function getStateValues()
    {
        return array(
            1 => Yii::t('main', 'admin.list.label.published'), 
            0 => Yii::t('main', 'admin.list.label.unpublished')
        );
    }

}
