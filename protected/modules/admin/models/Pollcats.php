<?php
/**
 * Contains Poll model class
 */

/**
 * Poll model class
 */
class Pollcats extends AdminAbstractModel
{
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
        return '{{poll}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array(
            array('id', 'safe', 'on' => 'search'),
            array('title, state', 'required'),
            array('title', 'length', 'max' => 128),
            array('state', 'numerical', 'integerOnly' => true),
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
            'id'    => Yii::t('main', 'admin.list.label.id'),
			'title' => Yii::t('main', 'admin.list.label.title'),
            'state' => Yii::t('main', 'admin.list.label.status'),
        );
    }

    /**
     * {@inheritdoc} 
     */
    public function relations()
    {
        return array(
            'items' => array(self::HAS_MANY, 'Pollitems', 'poll_id', 'order' => 'ordering ASC'),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function scopes()
    {
        return array(
            'ordering' => array(
                'order' => 'title ASC',
            ),
            'published' => array(
                'condition' => 'state=1',
                'order' => 'RAND() ASC',
                'limit' => 1,
            ),
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