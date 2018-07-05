<?php

include_once __DIR__ . DIRECTORY_SEPARATOR . "../config/defines.php";


require_once __DIR__ . "/../vendor/autoload.php";

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

date_default_timezone_set("Asia/Karachi");
$app = \system\App::getInstance();

$app->run();
