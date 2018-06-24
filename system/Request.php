<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 6/23/18
 * Time: 5:06 PM
 */

namespace system;


class Request
{
    private $getParams;
    private $postParams;
    public function __construct()
    {
        $this->getParams = $_GET;
        $this->postParams = $_POST;
    }

    public function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function isGet() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    public function get($name = '') {
        if(empty($name)) {
            return $this->getParams;
        }
        return !empty($this->getParams[$name]) ? $this->getParams[$name] : null;
    }


    public function post($name = '') {
        if(empty($name)) {
            return $this->postParams;
        }
        return !empty($this->postParams[$name]) ? $this->postParams[$name] : null;
    }

    public function getPathInfo() {
        if(isset($_SERVER['PATH_INFO'])) {
            return $_SERVER['PATH_INFO'];
        }
        return "/";
    }
}