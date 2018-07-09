<?php
include_once __DIR__ . DIRECTORY_SEPARATOR . "../config/defines.php";


require_once __DIR__ . "/../vendor/autoload.php";

require_once __DIR__ . "/../bootstrap.php";

date_default_timezone_set("Asia/Karachi");
$app = \system\App::getInstance();

$app->run();
