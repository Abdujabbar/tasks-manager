<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 6/20/18
 * Time: 2:07 PM
 */
namespace helpers;
class RandomGenerator
{
    protected static $_instance;
    public $availableChars = '1234567890qwertyuiopasdfghjklzxcvbnm';
    public static function getInstance() {
        if(!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function randomInt($from, $to) {
        return rand($from, $to);
    }

    public function randomSequence($length = 0) {
        $return = "";

        for($i = 0; $i < $length; $i++) {
            $return .= $this->availableChars[rand(0, strlen($this->availableChars) - 1)];
        }
        return $return;
    }
}