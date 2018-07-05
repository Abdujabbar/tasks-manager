<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 6/23/18
 * Time: 11:56 AM
 */

namespace system;

class Configs
{
    protected static $instance;
    protected $configs;

    public function __construct($configs = [])
    {
        $this->configs = $configs;
    }

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    private function __wakeup()
    {
        // TODO: Implement __wakeup() method.
    }

    public static function getInstance($configs = [])
    {
        if (!self::$instance) {
            self::$instance = new self($configs);
        }
        return self::$instance;
    }

    public function getByName($name)
    {
        return !empty($this->configs[$name]) ? $this->configs[$name] : null;
    }
}
