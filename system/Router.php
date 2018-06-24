<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 6/23/18
 * Time: 10:40 AM
 */

namespace system;


class Router
{
    public function parseRoute() {
        $pathInfo = "/";
        if(!empty($_SERVER['PATH_INFO'])) {
            $pathInfo = $_SERVER['PATH_INFO'];
        }
        $defaultController = DEFAULT_CONTROLLER;
        $defaultAction = "index";

        $pathInfo = trim($pathInfo, "/");



        $routePath = array_filter(explode("/", $pathInfo));

        if(count($routePath) > 0) {
            $defaultController = array_shift($routePath);
        }

        if(count($routePath) > 0) {
            $defaultAction = array_shift($routePath);
        }


        return [
            'controller' => $defaultController,
            'action' =>  $defaultAction,
        ];
    }
}