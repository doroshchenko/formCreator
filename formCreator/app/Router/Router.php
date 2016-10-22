<?php

namespace formCreator\app\Router;

use formCreator\app\Request;

class Router
{
    protected $request;
    protected $controller;
    protected $action;
    protected $params = array();
    protected $controllerNamespace = 'formCreator\controllers\\';


    public function __construct(Request $request)
    {
        if (!$request instanceof Request) {
            throw new \Exception('invalid request');
        }
        $this->request = $request;
        $this->processRequest();
    }

    public function processRequest()
    {
        $pathElements = explode('/', $this->request->url);
        $pathParams = array();
        foreach ($pathElements as $element) {
            if (!$this->controller) {
                $this->controller = $element;
                continue;
            }
            if (!$this->action) {
                $this->action = $element;
                continue;
            }
        }
        $this->params = $this->request->getHttpParams();

    }
    public function getController()
    {
        return $this->controllerNamespace . ucfirst($this->controller).'Controller';
    }

    public function getAction()
    {
        return $this->action.'Action';
    }

    public function getParams()
    {
        return $this->params;
    }
}

