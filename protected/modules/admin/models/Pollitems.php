<?php
/**
 * Contains Poll items class
 */

/**
 * Poll Items model class
 */
class Pollitems extends CActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	protected function afterConstruct()
	{
		parent::afterConstruct();
        
        if ($catid = Yii::app()->request->getQuery('catid'))
        {
            $this->poll_id = $catid;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * {@inheritdoc}
     */
    public function tableName()
    {
        return '{{poll_items}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array(
            array('id', 'safe', 'on' => 'search'),
            array('poll_id, title', 'required'),
            array('title', 'length', 'max' => 128),
            array('poll_id, count, ordering', 'numerical', 'integerOnly' => true),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return array(
            'CleanBehavior' => array(
                'class' => 'admin.components.behaviors.CleanBehavior',
                'attributes' => array('title'),
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array(
            'id'        => Yii::t('main', 'admin.list.label.id'),
			'title'     => Yii::t('main', 'admin.list.label.title'),
            'poll_id'   => Yii::t('main', 'admin.section.pollcats'),
            'count'     => Yii::t('pollitems', 'admin.list.label.votesNumber'),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return array(
            'poll' => array(self::BELONGS_TO, 'Pollcats', 'poll_id'),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function scopes()
    {
        return array(
            'ordering' => array('order' => 'ordering ASC'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * 
     * @return CActiveDataProvider the data provider that can return the models 
     *          based on the search/filter conditions.
     */
    public function search($itemPerPage = 20)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('t.poll_id', $this->poll_id);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'sort' => array('defaultOrder' => 't.title'),
            'pagination' => array(
                'pageSize' => $itemPerPage
            )
        ));
    }
    
    /**
     * @return array The list of poll categories for filter
     */
    public function getPollidFilterValues()
    {
        $items = Pollcats::model()->findAll();
        
        $result = array();
        foreach ($items as $item)
        {
            $result[$item->primaryKey] = $item->title;
        }
        return $result;
    }
    
    /**
     * Returns the list of existing poll categories
     * where key is identifier and value is title of the category
     * 
     * @return array
     */
    public function getPollidDropDown()
    {
        $result = array();
        $items = Pollcats::model()->findAll();

        foreach ($items as $item)
            $result[$item->primaryKey] = $item->title;

        return $result;
    }

}