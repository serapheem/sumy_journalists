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
			array( 'title, description', 'required' ),
			array( 'title, alias, description, parent_id, state, section, params, metakey, metadesc, metadata', 'safe' ),
			array( 'id, title, alias, parent_id, state, section', 'safe', 'on'=>'search' ),
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
			'parent_id' => '',
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

}
