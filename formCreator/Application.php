<?php

namespace formCreator;

use formCreator\app\Request;
use formCreator\app\Helper\Helper;
use formCreator\app\Router\Router;

class Application
{
    /**
     * Controllers namespace
     *
     * @var string
     */

    public  function run($configs)
    {
        $url = Helper::getRequestPath();
        $httpParams = Helper::getHttpParams();

        $request = new Request($url, $httpParams);
        $router = new Router($request);

        $controllerName = $router->getController();
        $actionName = $router->getAction();
        $actionParams = $router->getParams();
        try {
            if ($this->controllerExists($controllerName)) {
                $controller = new $controllerName($configs);
            }
            $response = $controller->{$actionName}($actionParams);
            if (!$response) {
                throw new \Exception('wrong request');
            }
            echo $response;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

    }

    protected function controllerExists($controllerName)
    {
        $files = scandir('formCreator/controllers');
        $controllerFiles = array();
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) == 'php') {
                $controllerFiles[] = substr($file, 0, -4);
            }
        }
        $controllerName = explode('\\', $controllerName);
        $name = array_pop($controllerName);
        if (!in_array($name, $controllerFiles)) {
            throw new \Exception ('wrong request');
        }

        return true;
    }

    public static function printForm($name)
    {
        $configs = require_once '../formCreator/config/configs.php';
        $controller = new controllers\IndexController($configs);
        $result = $controller->usageAction($name);
        echo $result;
    }


}

