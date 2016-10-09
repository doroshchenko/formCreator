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

    public function setElements(array $elements)
    {
        foreach ($elements as $element) {
            $this->elements[] = new FormElement();
        }
        return $this;
    }

    public function getElements()
    {
        return $this->elements;
    }

    public function getAll()
    {
        $data = $this->storage->getAll();
        $forms = array();
        foreach ($data as $row) {
            $form = new self();
            $form->setName($row['name'])
                ->setAction($row['action'])
                ->setMethod($row['method'])
                ->setType($row['type'])
                ->setElements($row['elements']);
            $forms[] = $form;
        }

        return $forms;
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

    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

   /* public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }*/

    public function __call($name, $value)
    {
        $method = substr($name, 0, 3);
        if ($method == 'set') {
            $prop = strtolower(substr($name, 3));
            if (property_exists($this, $prop)) {
                $this->{$prop} = $value;
            }
        } else if ($method == 'get') {
            $prop = strtolower(substr($name, 3));
            if (property_exists($this, $prop)) {
                return $this->{$prop};
            }
        }

        return $this;
    }
}

