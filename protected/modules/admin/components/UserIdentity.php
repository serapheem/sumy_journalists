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
            Users::model()->updateByPk($record->id, array(
                'ip' => Yii::app()->request->getUserHostAddress(),
                'lasttime' => date('Y-m-d H:i:s'),
            ));

            $this->_id = $record->id;
            $this->setState('email', $record->email);
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    /**
     * Returns the user identifier
     * 
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

}
