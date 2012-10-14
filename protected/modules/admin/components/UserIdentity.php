<?php
/**
 * Contains class for user identification
 */

/**
 * User Identity class
 */
class UserIdentity extends CUserIdentity
{
    /**
     * Identifier of user
     * @var int
     */
    private $_id;

    /**
     * Returns the user identifier
     * 
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Processes authentication of user
     * 
     * @return bool
     */
    public function authenticate()
    {
        $record = Users::model()
            ->findByAttributes(array('email' => $this->username));

        if ($record === null)
        {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
        elseif ($record->password !== sha1($record->email . $this->password))
        {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }
        else {
            Users::model()->updateByPk($record->primaryKey, array(
                'ip' => Yii::app()->request->getUserHostAddress(),
                'lasttime' => date('Y-m-d H:i:s'),
            ));

            $this->_id = $record->primaryKey;
            $this->setState('email', $record->email);
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

}
