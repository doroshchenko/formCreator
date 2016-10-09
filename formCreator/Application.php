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

        $controller = new $controllerName($configs);
        try {
            $response = $controller->{$actionName}($actionParams);
            if (!$response) {
                throw new \Exception('wrong request');
            }
            echo $response;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

    }

    protected function getRequest()
    {

    }
}

