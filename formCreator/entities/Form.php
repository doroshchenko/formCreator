<?php

namespace formCreator\entities;

use formCreator\entities\FormElement;
use formCreator\app\Storage\EntitySerializer;

class Form extends Entity
{
    protected $id_form;
    protected $name;
    protected $action;
    protected $enctype;
    protected $method;
    protected $elements = array();

    public static $method_definition = array('get' => array('enctype' => false),
                                             'post' => array('enctype' => true));

    public static $enctype_definition = array('application/x-www-form-urlencoded',
                                              'multipart/form-data',
                                              'text/plain');


    public function __construct($id = null)
    {
        if ($id) {
            $this->id_form = $id;
        }
    }

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

    public function delete()
    {
        $formData = EntitySerializer::serialize($this);
        $this->storage->delete($formData);
    }

}

