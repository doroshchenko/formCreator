<?php

namespace formCreator\entities;

use formCreator\entities\FormElement;

class Form extends Entity
{
    protected $name;

    protected $action;

    protected $type;

    protected $method;

    protected $elements = array();

    public function __construct()
    {
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    public function setElements(array $elements)
    {
        foreach ($elements as $element) {
            if (($element instanceof FormElement)) {
                $this->elements[] = $element;
            }
        }
        return $this;
    }

    public function getElements()
    {
        return $this->elements;
    }

    public function getAll()
    {
        return $this->storage->getAll();
    }

    public function setStorage($storage)
    {
        $this->storage = $storage;
        return $this;
    }

    public function save()
    {
        $this->storage->save($this);
    }
}

