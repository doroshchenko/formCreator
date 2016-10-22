<?php

namespace formCreator\entities;

use formCreator\entities\FormElement;
use formCreator\app\Storage\EntitySerializer;

class Form extends Entity
{
    protected $name;

    protected $action;

    protected $type;

    protected $method;

    protected $elements = array();

    public function setElements(array $elements)
    {
        $elementClass = 'formCreator\entities\FormElement';
        $this->elements = EntitySerializer::createEntities($elements, $elementClass);

        return $this;
    }

    public function getAll()
    {
        $data = $this->storage->getAll();
        $forms = EntitySerializer::createEntities($data, static::class);

        return $forms;
    }

    public function setStorage($storage)
    {
        $this->storage = $storage;
        return $this;
    }

    public function save()
    {
        $formData = EntitySerializer::serialize($this);
        $this->storage->save($formData);
    }

    public function getAllProperties()
    {

    }

}

