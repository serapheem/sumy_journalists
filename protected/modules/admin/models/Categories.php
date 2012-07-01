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
	 * @param string $className 
	 * @return CActiveRecord
	 */
	public static function model( $className = __CLASS__ ) 
	{
	   return parent::model($className);
	}
	
	/**
	 * Returns array of rules for different properties
	 * @return array
	 */
	public function rules() 
	{
		return array(
			array( 'title, parent_id, state, section', 'required' ),
			array( 'alias, description, metakey, metadesc', 'safe' ),
			array( 'id', 'safe', 'on' => 'search' ),
			array( 'created, created_by, modified, modified_by', 'safe', 'on' => 'update' ),
			array( 'title', 'length', 'max' => 255 ),
			array( 'alias', 'length', 'max' => 127 ),
			array( 'parent_id, state', 'numerical', 'integerOnly' => true ),
			array( 'section', 'length', 'max' => 63 ),
		);
	}
	
	/**
	 * (non-PHPDoc)
	 * @see CActiveRecord::relations
	 */
	public function relations()
	{
		return array(
			'created_user' => array( self::BELONGS_TO, 'Users', 'created_by' ),
			'modified_user' => array( self::BELONGS_TO, 'Users', 'modified_by' ),
		);
	}
	
	/**
	 * Returns labels for properties
	 * @return array
	 */
	public function attributeLabels() 
	{
		return array(
			'title' => Yii::t( 'main', 'TITLE' ),
			'alias' => Yii::t( 'main', 'ALIAS' ),
			'description' => Yii::t( 'main', 'TEXT' ),
			'parent_id' => Yii::t( 'main', 'Parent' ),
			'state' => Yii::t( 'main', 'STATUS' ),
			'modified' => Yii::t( 'main', 'LAST_UPDATED' ),
			'hits' => Yii::t( 'main', 'HITS' ),
		);
	}

	/**
	 * Returns the name of table
	 * @return string
	 */
	public function tableName() 
	{
		return '{{categories}}';
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search( $itemPerPage = 25 )
	{
		$criteria = new CDbCriteria;
		$criteria->compare( 't.id', $this->id );
		$criteria->compare( 't.title', $this->title, true );
		$criteria->compare( 't.alias', $this->alias, true );
		$criteria->compare( 't.state', $this->state );
		
		return new CActiveDataProvider( get_class($this), array(
			'criteria' => $criteria,
			'sort' => array( 'defaultOrder' => 't.title' /*, 
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
	 * @return array
	 */
	public function getDropDownItems()
	{
		$result = array();
		$items = $this->findAll();
		
		foreach ($items as $key => $item )
			$result[$item->id] = (strtolower( $item->title ) == 'root') ? Yii::t( $this->getTableSchema()->name, '- No parent -' ) : $item->title;
		
		return $result;
	}

	/**
	 * @return array The list of possible state values
	 */
	public function getStateValues()
	{
		return array( 1 => Yii::t( 'main', 'Published' ), 0 => Yii::t( 'main', 'Unpublished' ) );
	}

}
