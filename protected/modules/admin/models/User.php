<?php
/**
 * Contains model for User table
 *
 * @author      Serhiy Hlushko <serhiy.hlushko@gmail.com>
 * @copyright   Copyright 2013 Hlushko inc.
 * @company     Hlushko inc.
 */

/**
 * Users Model class
 */
class User extends AdminModel
{
    /**
     * Repeat password data
     * @var string
     */
    public $repeatedPassword;

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
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * {@inheritdoc}
     */
    public function tableName()
    {
        return '{{user}}';
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
            array('password, repeatedPassword', 'required', 'on' => 'insert'),
            array('password, repeatedPassword', 'safe'),
            array('newPassword', 'safe', 'on' => 'update'),
            array('password', 'compare', 'compareAttribute' => 'repeatedPassword', 'on' => 'insert'),
            array('repeatedPassword', 'compare', 'compareAttribute' => 'password', 'on' => 'insert'),
            array('newPassword', 'compare', 'compareAttribute' => 'repeatedPassword', 'on' => 'update'),
            array('repeatedPassword', 'compare', 'compareAttribute' => 'newPassword', 'on' => 'update'),
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
                'attributes' => array('name', 'email', 'password', 'repeatedPassword', 'newPassword'),
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
            'id' => Yii::t('main', 'admin.list.label.id'),
            'name' => Yii::t('main', 'admin.list.label.name'),
            'email' => Yii::t($sectionId, 'admin.list.label.email'),
            'lasttime' => Yii::t($sectionId, 'admin.list.label.lastVisited'),
            'ip' => Yii::t($sectionId, 'admin.list.label.lastIp'),
            'password' => Yii::t($sectionId, 'admin.form.label.password'),
            'newPassword' => Yii::t($sectionId, 'admin.form.label.newPassword'),
            'repeatedPassword' => Yii::t($sectionId, 'admin.form.label.repeatPassword'),
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function afterFind()
    {
        parent::afterFind();

        $this->oldPassword = $this->password;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($attributes = null, $clearErrors = true)
    {
        $success = parent::validate($attributes, $clearErrors);
        if ($this->getScenario() == 'update' && $this->newPassword) {
            if ($this->oldPassword != sha1($this->email . $this->password)) {
                $success = false;
                $sectionId = strtolower(__CLASS__);
                $this->addError(
                    'password',
                    Yii::t($sectionId, 'admin.form.message.error.notCorrectPassword')
                );
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
        if ($this->getScenario() == 'insert') {
            $this->password = sha1($this->email . $this->password);
        } elseif ($this->getScenario() == 'update') {
            unset($this->password);
            if ($this->newPassword) {
                $this->password = sha1($this->email . $this->newPassword);
            }
        }

        return parent::beforeSave();
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @param int $itemPerPage Number of items which will be rendered
     *
     * @return CActiveDataProvider the data provider that can return the models
     *          based on the search/filter conditions.
     */
    public function search($itemPerPage = 20)
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