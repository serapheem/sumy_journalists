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
	 * @var string
	 */
	public $password2;
    
    /**
	 * New password
	 * @var string
	 */
	public $newPassword;
    
    /**
	 * Old password
	 * @var string
	 */
	public $oldPassword;
    
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
			array('email', 'email'),
            array('email', 'unique'),
            array('name, email', 'length', 'max' => 128),
            array('password, password2', 'required', 'on' => 'insert'),
            array('password, password2', 'safe'),
            array('newPassword', 'safe', 'on' => 'update'),
			array('password', 'compare', 'compareAttribute' => 'password2', 'on' => 'insert'),
            array('password2', 'compare', 'compareAttribute' => 'password', 'on' => 'insert'),
            array('newPassword', 'compare', 'compareAttribute' => 'password2', 'on' => 'update'),
            array('password2', 'compare', 'compareAttribute' => 'newPassword', 'on' => 'update'),
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
            'newPassword' => Yii::t($secionName, 'admin.form.label.newPassword'),
			'password2' => Yii::t($secionName, 'admin.form.label.repeatPassword'),
		);
	}
    
    /**
	 * {@inheritdoc}
	 */
	protected function afterFind()
	{
		$this->oldPassword = $this->password;
        parent::afterFind();
	}
    
    /**
	 * {@inheritdoc}
	 */
	public function validate($attributes = null, $clearErrors = true)
	{
        $success = parent::validate($attributes, $clearErrors);
        if ($this->getScenario() == 'update' && $this->newPassword)
        {
            if ($this->oldPassword != sha1($this->email . $this->password))
            {
                $success = false;
                $this->addError('password', Yii::t($this->getTableSchema()->name, 
                    'admin.form.message.error.notCorrectPassword'));
            }
        }
        
		return $success;
	}

    /**
     * {@inheritdoc}
     */
    protected function beforeSave()
    {
        $this->name = trim($this->name);
        $this->email = trim($this->email);
        if ($this->getScenario() == 'insert')
        {
            $this->password = sha1($this->email . $this->password);
        }
        elseif ($this->getScenario() == 'update')
        {
            unset($this->password);
            if ($this->newPassword)
            {
                $this->password = sha1($this->email . $this->newPassword);
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