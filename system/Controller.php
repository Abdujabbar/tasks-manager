<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 6/23/18
 * Time: 10:22 AM
 */
namespace system;
class Controller
{
    protected $view;

    /**
     * Controller constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->view = new View();
    }

    /**
     * @param string $layout
     */
    public function setLayout($layout = 'layout') {
        $this->view->layout = $layout;
    }

    /**
     * @param $view
     * @param array $data
     * @throws \Exception
     */
    public function render($view, $data = []) {
        $this->view->render($view, $data);
    }


    public function redirect($path) {
        header("Location:". $path, true, 301);
        die();
    }

    public function getRequest() {
        return App::getInstance()->getRequest();
    }
}