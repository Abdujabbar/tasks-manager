<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 6/23/18
 * Time: 10:37 AM
 */
namespace system;
class App
{
    protected $route;
    private $authUser;
    private $request;
    private static  $instance;
    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->route = new Router();
        $configurations = require_once CONFIG_FILE;
        Configs::getInstance($configurations);
        $this->authUser = new AuthUser();
        $this->request = new Request();
    }

    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getAuthUser() {
        return $this->authUser;
    }

    public function getRequest() {
        return $this->request;
    }


    public function run() {
        $parsedPath = $this->route->parseRoute();
        $controller = "\controllers\\".  ucfirst($parsedPath['controller']) . CONTROLLER_SUFFIX;
        $action = ACTION_PREFIX . ucfirst($parsedPath['action']);
        if(!class_exists($controller)) {
            echo $controller . PHP_FILE_EXT . " File not exists.";
            \http_response_code(404);
            die();
        }
        $class = new $controller();


        if(method_exists($class, $action)) {
            $class->$action();
        } else {
            echo str_replace(ACTION_PREFIX, "", $action) .  " method doesn't exists";
            \http_response_code(404);
            die();
        }
    }
}