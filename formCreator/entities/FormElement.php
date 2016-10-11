<?php

namespace formCreator\entities;

use formCreator\entities\Entity;

class FormElement extends Entity
{
    protected $name;
    protected $type;
    protected $value;


    public function setStorage($storage)
    {
        $this->storage = $storage;
        return $this;
    }
}

