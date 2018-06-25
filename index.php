<?php


include_once __DIR__ . DIRECTORY_SEPARATOR . "config/defines.php";


require_once __DIR__ . "/vendor/autoload.php";

spl_autoload_register(function ($class) {
    $file = APP_ROOT . str_replace("\\", "/", $class) . PHP_FILE_EXT;
    @include_once $file;
});

date_default_timezone_set("Asia/Karachi");
$app = \system\App::getInstance();

$app->run();