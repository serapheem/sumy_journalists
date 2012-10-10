<?php
/**
 * Contains login model
 */

/**
 * Login Model class
 */
class Login extends CFormModel
{
    /**
     * Email of user
     * @var string
     */
    public $email;

    /**
     * User password
     * @var string
     */
    public $password;

    /**
     * Need to remember user
     * @var bool
     */
    public $rememberMe = false;
    
    private $_identity;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array(
            array('email, password', 'required'),
            array('email', 'length', 'max' => 128),
            array('password', 'authenticate'),
            array('rememberMe', 'boolean'),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array(
            'email' => Yii::t('users', 'admin.list.label.email'),
            'password' => Yii::t('users', 'admin.form.label.password'),
            'rememberMe' => Yii::t('users', 'admin.form.label.rememberMe'),
        );
    }

    /**
     * Processes the authenticate of user
     */
    public function authenticate($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            $this->_identity = new UserIdentity($this->email, $this->password);
            $this->_identity->authenticate();

            switch ($this->_identity->errorCode)
            {
                case UserIdentity::ERROR_USERNAME_INVALID:
                    $this->addError('username', Yii::t('main', 'LOGIN_INCORRECT'));
                    break;

                case UserIdentity::ERROR_PASSWORD_INVALID:
                    $this->addError('password', Yii::t('main', 'PASSWORD_INCORRECT'));
                    break;

                default:
                    break;
            }
        }
    }

    /**
     * Processes the login of user
     * 
     * @return bool
     */
    public function login()
    {
        if ($this->_identity === null)
        {
            $this->_identity = new UserIdentity($this->email, $this->password);
            $this->_identity->authenticate();
        }

        $success = false;
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE)
        {
            Yii::app()->user->login($this->_identity, 3600 * 24 * 30);
            $success = true;
        }
        return $success;
    }

}
