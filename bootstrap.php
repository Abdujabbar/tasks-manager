<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/9/18
 * Time: 2:27 PM
 */

spl_autoload_register(
    function ($class) {
        $file = APP_ROOT . str_replace("\\", "/", $class) . PHP_FILE_EXT;
        if (file_exists($file)) {
            include_once $file;
        } else {
            return false;
        }
    }
);