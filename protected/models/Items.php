<?php
/**
 * File for items model
 */

/**
 * Items Model class
 */
class Items extends AbstractModel
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
        $criteria->compare('t.catid', $this->catid);
        $criteria->compare('t.state', $this->state);
        
        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'sort' => array('defaultOrder' => 't.title'),
            'pagination' => array(
                'pageSize' => $itemPerPage
            )
        ));
    }

}
