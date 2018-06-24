<?php



include_once __DIR__ . DIRECTORY_SEPARATOR. "config/defines.php";

include_once APP_ROOT . "bootstrap.php";

date_default_timezone_set("Asia/Karachi");
$app = new system\App();

$app->run();