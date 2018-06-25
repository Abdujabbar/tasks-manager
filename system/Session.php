<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 6/23/18
 * Time: 12:44 PM
 */

namespace system;

class Session
{
    public static $instance;

    public function __construct()
    {
        session_start();
    }

    public function __clone()
    {
        // TODO: Implement __clone() method.
    }

    public function __wakeup()
    {
        // TODO: Implement __wakeup() method.
    }

    /**
     * @return Session
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param $name
     * @param $message
     */
    public function setFlash($name, $message)
    {
        $_SESSION[$name] = $message;
    }

    /**
     * @param $name
     * @return string
     */
    public function getFlash($name)
    {
        if (!empty($_SESSION[$name])) {
            $message = $_SESSION[$name];
            unset($_SESSION[$name]);
            return $message;
        }
        return "";
    }

    /**
     * @param $name
     * @param $value
     */
    public function setSessionValue($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * @param $name
     * @return null | mixed
     */
    public function getSessionValue($name)
    {
        if (!empty($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return null;
    }

    /**
     * @param $name
     */
    public function unsetSessionValue($name)
    {
        if (!empty($_SESSION[$name])) {
            unset($_SESSION[$name]);
        }
    }
}