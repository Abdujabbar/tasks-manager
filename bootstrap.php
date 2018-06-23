<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 6/23/18
 * Time: 10:21 AM
 */


spl_autoload_register(function ($class) {
    $file = APP_ROOT .  str_replace("\\", "/", $class) . PHP_FILE_EXT;
    @include_once $file;
});