<?php

namespace formCreator\controllers;

use formCreator\app\Storage\StorageFactory;

class Controller
{
    private $storage;

    const CSS_PATH = 'views/css';

    public function __construct($configs)
    {
        $this->setStorage($configs);
    }

    protected function setStorage($configs)
    {
        $this->storage = StorageFactory::createStorage($configs);
    }

    protected function getStorage()
    {
        return $this->storage;
    }

    public function redirect($action)
    {
        header('Location: ../form/index');

        return true;
    }

}