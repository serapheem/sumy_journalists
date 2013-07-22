<?php
/**
 * Contains class for user identification
 *
 * @author      Serhiy Hlushko <serhiy.hlushko@gmail.com>
 * @copyright   Copyright 2013 Hlushko inc.
 * @company     Hlushko inc.
 */

/**
 * Manages User Identification
 */
class UserIdentity extends CUserIdentity
{
    /**
     * @var int Identifier of user
     */
    protected $_id;

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
        $record = User::model()
            ->findByAttributes(array('email' => $this->username));

        if ($record === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } elseif ($record->password !== sha1($this->username . $this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            User::model()->updateByPk(
                $record->primaryKey,
                array(
                    'ip' => Yii::app()->getRequest()->getUserHostAddress(),
                    'lasttime' => date('Y-m-d H:i:s'),
                )
            );

            $this->_id = $record->primaryKey;
            $this->setState('email', $record->email);
            $this->errorCode = self::ERROR_NONE;
        }

        return $this->getIsAuthenticated();
    }

}
