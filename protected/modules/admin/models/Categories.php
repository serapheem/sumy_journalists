<?php
/**
 * File for categories model
 */

/**
 * Categories Model class
 */
class Categories extends AbstractAdminModel
{
    /**
     * Returns the model object
     * 
     * @param   string  $className 
     * @return  CActiveRecord
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
        return '{{categories}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array(
            array('title, parent_id, state', 'required'),
            array('alias, description, meta_title, meta_keywords, meta_description', 'safe'),
            array('id', 'safe', 'on' => 'search'),
            array('created_at, created_by, modified_at, modified_by', 'safe', 'on' => 'update'),
            array('title, alias, meta_title, meta_keywords, meta_description', 'length', 'max' => 255),
            array('parent_id, state', 'numerical', 'integerOnly' => true),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array(
            'title'         => Yii::t('main', 'admin.list.label.title'),
            'alias'         => Yii::t('main', 'admin.list.label.alias'),
            'description'   => Yii::t('main', 'admin.form.label.text'),
            'parent_id'     => Yii::t($this->getTableSchema()->name, 'admin.form.label.parent'),
            'state'         => Yii::t('main', 'admin.list.label.status'),
            'hits'          => Yii::t('main', 'admin.list.label.hits'),
            
            'created_by'    => Yii::t('main', 'admin.list.label.createdBy'),
            'created_at'    => Yii::t('main', 'admin.list.label.createdAt'),
            'modified_by'   => Yii::t('main', 'admin.list.label.modifiedBy'),
            'modified_at'   => Yii::t('main', 'admin.list.label.modifiedAt'),
            
            'meta_title'    => Yii::t('main', 'admin.form.label.metaTitle'),
            'meta_keywords' => Yii::t('main', 'admin.form.label.metaKeywords'),
            'meta_description' => Yii::t('main', 'admin.form.label.metaDescription'),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return array(
            'created_user' => array(self::BELONGS_TO, 'Users', 'created_by'),
            'modified_user' => array(self::BELONGS_TO, 'Users', 'modified_by'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * 
     * @return CActiveDataProvider the data provider that can return the models 
     *          based on the search/filter conditions.
     */
    public function search($itemPerPage = 25)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('t.alias', $this->alias, true);
        $criteria->compare('t.state', $this->state);

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
     * @return array
     */
    public function getDropDownItems()
    {
        $result = array();
        $items = $this->findAll();

        foreach ($items as $item)
            $result[$item->id] = (strtolower($item->title) == 'root') 
                ? Yii::t($this->getTableSchema()->name, 'admin.form.label.noParent') 
                : $item->title;

        return $result;
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
