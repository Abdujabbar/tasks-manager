<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 6/23/18
 * Time: 5:25 PM
 */

namespace helpers;


class Alert
{
    public static function show($name, $message) {
        return "<div class=\"alert alert-{$name}\" role=\"alert\" style='margin-top: 5px;'>
                    {$message}
                </div>";
    }
}