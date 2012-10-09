<?php
/**
 * File for users model
 */

/**
 * Users Model class
 */
class Users extends CActiveRecord 
{
	/**
	 * Repeat password data
	 * 
	 * @var string
	 */
	public $password2;
    
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
	public static function model($className = __CLASS__) 
	{
	   return parent::model($className);
	}

	/**
	 * {@inheritdoc}
	 */
	public function tableName()
	{
		return '{{users}}';
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return array(
			array('name, email', 'required'),
            array('password, password2', 'required', 'on' => 'insert'),
            array('password2', 'safe'),
			array('password', 'compare', 'compareAttribute' => 'password2'),
			array('email', 'email'),
		);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() 
	{
        $secionName = $this->getTableSchema()->name;
		return array(
            'id' => Yii::t('main', 'admin.list.label.id'),
			'name' => Yii::t('main', 'admin.list.label.name'),
			'email' => Yii::t($secionName, 'admin.list.label.email'),
            'lasttime' => Yii::t($secionName, 'admin.list.label.lastVisited'),
			'ip' => Yii::t($secionName, 'admin.list.label.lastIp'),
			'password' => Yii::t($secionName, 'admin.form.label.password'),
			'password2' => Yii::t($secionName, 'admin.form.label.repeatPassword'),
		);
	}
    
    /**
     * {@inheritdoc}
     */
    protected function beforeValidate()
	{
        return parent::beforeValidate();
	}

    /**
     * {@inheritdoc}
     */
    protected function beforeSave()
    {
        $allowedActions = array('insert', 'update');
        if (in_array($this->getScenario(), $allowedActions))
        {
            $this->name = trim($this->name);
            $this->email = trim($this->email);
            
            if ($this->password)
            {
                $this->password = sha1($this->email . $this->password);
            }
            if ($this->password2)
            {
                $this->password2 = sha1($this->email . $this->password2);
            }
        }

        return parent::beforeSave();
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
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.email', $this->email, true);
        
        return new CActiveDataProvider(get_class($this), array(
                'criteria' => $criteria,
                'sort' => array('defaultOrder' => 't.name'),
                'pagination' => array(
                    'pageSize' => $itemPerPage
                )
            ));
    }

}