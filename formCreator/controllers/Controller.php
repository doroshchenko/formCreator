<?php

namespace formCreator\controllers;

use formCreator\app\Storage\StorageFactory;

class Controller
{
    private $storage;

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


}