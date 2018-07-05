<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 6/23/18
 * Time: 11:25 AM
 */
if (($message = \system\Session::getInstance()->getFlash('success'))) {
    echo \helpers\Alert::show('success', $message);
}
echo "I am index.php file";
