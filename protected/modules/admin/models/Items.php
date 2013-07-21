<?php
/**
 * Contains Item model
 *
 * @author      Serhiy Hlushko <serhiy.hlushko@gmail.com>
 * @copyright   Copyright 2013 Hlushko inc.
 * @company     Hlushko inc.
 */

/**
 * Items Model class
 */
class Item extends AdminModel
{
    //public $featured;
    
    /**
	 * {@inheritdoc}
	 */
	protected function afterConstruct()
	{
		parent::afterConstruct();
        
        if ($catid = Yii::app()->request->getQuery('catid'))
        {
            $this->catid = $catid;
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
        return '{{items}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array(
            array('title, fulltext, catid, state', 'required'),
            array('slug, featured, meta_title, metakey, metadesc', 'safe'),
            array('id', 'safe', 'on' => 'search'),
            array('created_at, created_by, modified_at, modified_by', 'safe', 'on' => 'update'),
            array('title, slug, meta_title, metakey, metadesc', 'length', 'max' => 255),
            array('catid, state, ordering', 'numerical', 'integerOnly' => true),
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
                'attributes' => array('title', 'slug', 'meta_title', 'metakey', 'metadesc'),
            ),
            'SlugBehavior' => array(
                'class' => 'admin.components.behaviors.SlugBehavior',
            ),
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created_at',
                'updateAttribute' => 'modified_at',
                'setUpdateOnCreate' => true,
            ),
            'AuthorBehavior' => array(
                'class' => 'admin.components.behaviors.AuthorBehavior',
            ),
            'FeaturedBehavior' => array(
                'class' => 'admin.components.behaviors.FeaturedBehavior',
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        $sectionId = strtolower(__CLASS__);
        return array(
            'id'            => Yii::t('main', 'admin.list.label.id'),
			'title'         => Yii::t('main', 'admin.list.label.title'),
            'slug'          => Yii::t('main', 'admin.list.label.slug'),
            'catid'         => Yii::t('main', 'admin.list.label.category'),
            'state'         => Yii::t('main', 'admin.list.label.status'),
            'featured'      => Yii::t($sectionId, 'admin.list.label.featured'),
            'fulltext'      => Yii::t('main', 'admin.form.label.text'),
            'hits'          => Yii::t('main', 'admin.list.label.hits'),
            'rating'        => Yii::t('main', 'admin.list.label.rating'),
            
            'created_by'    => Yii::t('main', 'admin.list.label.createdBy'),
            'created_at'    => Yii::t('main', 'admin.list.label.createdAt'),
            'modified_by'   => Yii::t('main', 'admin.list.label.modifiedBy'),
            'modified_at'   => Yii::t('main', 'admin.list.label.modifiedAt'),
            
            'meta_title'    => Yii::t('main', 'admin.form.label.metaTitle'),
            'metakey'       => Yii::t('main', 'admin.form.label.metaKeywords'),
            'metadesc'      => Yii::t('main', 'admin.form.label.metaDescription'),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        $sectionId = strtolower(__CLASS__);
        return array(
            'category' => array(self::BELONGS_TO, 'Categories', 'catid'),
            'created_user' => array(self::BELONGS_TO, 'Users', 'created_by'),
            'modified_user' => array(self::BELONGS_TO, 'Users', 'modified_by'),
            'featured' => array(self::HAS_ONE, 'Frontpage', 'item_id', 
                            'condition' => 'featured.section=\'' . $sectionId . '\'' ),
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
        $criteria->compare('t.slug', $this->slug, true);
        $criteria->compare('t.catid', $this->catid);
        $criteria->compare('t.state', $this->state);
        
        // $sectionId = strtolower(__CLASS__);
        // $criteria->with = array('featured'); var_dump($criteria->toArray()); die;
        //$criteria->compare('users.full_name', $this->search_user, true);
        //$criteria->compare('t.featured', $this->featured);

        return new CActiveDataProvider(get_class($this), array(
                'criteria' => $criteria,
                'sort' => array('defaultOrder' => 't.title' /* , 
                  'attributes' => array(
                  'nameCity'=>array( // сортировка по связанном полю
                  'asc' => $expr='nameCity.name_city',
                  'desc' => $expr.' DESC',
                  ),
                  'nameCity1'=>array( // сортировка по связанном полю
                  'asc' => $expr='nameCity1.name_city',
                  'desc' => $expr.' DESC',
                  ),
                  'id'=>array( // сортировка по id
                  'asc' => $expr='t.id', // t.id написано потому что у нас id есть в двух таблицах
                  'desc' => $expr.' DESC',
                  ),
                  'name_person', // не требует подробного описания т.к. это поле индивидуально для двух таблиц
                  ) */
                ),
                'pagination' => array(
                    'pageSize' => $itemPerPage
                )
            ));
    }
    
    /**
     * Returns the list of existing categories
     * where key is identifier and value is title of the category
     * 
     * @param int $parentId Identifier of the parent category
     * 
     * @return array
     */
    public function getCatidDropDown($parentId = null)
    {
        $result = array();
        $condition = 'id<>:id';
        $params = array('id' => 1);
        if ($parentId)
        {
            $condition .= ' AND parent_id = :parent_id';
            $params['parent_id'] = $parentId;
        }
        $items = Categories::model()->orderByTitle()->findAll($condition, $params);

        $sectionId = strtolower(__CLASS__);
        foreach ($items as $item)
            $result[$item->primaryKey] = (strtolower($item->title) == 'root') 
                ? Yii::t($sectionId, 'admin.form.label.noParent') 
                : $item->title;

        return $result;
    }

    /**
     * @return array The list of possible featured values for filter
     */
    public function getFeaturedFilterValues()
    {
        $sectionId = strtolower(__CLASS__);
        return array(
            'prompt' => Yii::t($sectionId, 'admin.list.filter.featured.select'),
            1 => Yii::t($sectionId, 'admin.list.filter.featured.featured'), 
            0 => Yii::t($sectionId, 'admin.list.filter.featured.unfeatured')
        );
    }

    /**
     * @return array The list of possible featured values
     */
    public function getFeaturedValues()
    {
        $sectionId = strtolower(__CLASS__);
        return array(
            1 => Yii::t($sectionId, 'admin.form.label.featured'), 
            0 => Yii::t($sectionId, 'admin.form.label.unfeatured')
        );
    }

}
