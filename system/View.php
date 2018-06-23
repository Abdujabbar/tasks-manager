<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 6/23/18
 * Time: 10:22 AM
 */
namespace system;
class View
{
    public $layout = "layout";
    protected $layoutsPath = DEFAULT_LAYOUTS_PATH;


    public function render($view, $data = [])
    {
        $viewPath = VIEWS_PATH . DIRECTORY_SEPARATOR . $view . PHP_FILE_EXT;
        $layoutPath = $this->layoutsPath . DIRECTORY_SEPARATOR . $this->layout . PHP_FILE_EXT;

        foreach([$viewPath, $layoutPath] as $file) {
            if(!file_exists($file)) {
                throw new \Exception($file . " file not exists");
                die();
            }
        }

        extract($data);
        ob_start();
        include_once $viewPath;
        $content = ob_get_contents();
        ob_clean();
        include_once $layoutPath;
    }


    public function setLayoutsPath($layoutPath) {
        $this->layoutsPath = $layoutPath;
    }
}