<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 6/23/18
 * Time: 12:52 PM
 */

namespace system;

/**
 * Class Auth
 * @package system
 */
class AuthUser
{
    protected $id;
    public $username;
    public function __construct()
    {
        $this->id = Session::getInstance()->getSessionValue('userID');
    }



    public function isGuest() {
        return empty($this->getId());
    }

    public function getId() {
        return $this->id;
    }


    public function login($username, $password) {
        if($username === ADMIN_USERNAME && $this->validatePassword($password, ADMIN_PASS)) {
            $this->username = $username;
            $this->id = 100;
            Session::getInstance()->setSessionValue("userID", $this->id);

            Session::getInstance()->setSessionValue('identity', $this);
            return true;
        }
        return false;
    }


    public function validatePassword($password, $definedPassword) {
        return $password === $definedPassword;
    }

    public function logout() {
        if(!$this->isGuest()) {
            Session::getInstance()->unsetSessionValue('userID');
        }
    }

    public function getIdentity() {
        return Session::getInstance()->getSessionValue('identity');
    }
}