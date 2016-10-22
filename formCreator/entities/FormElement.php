<?php

namespace formCreator\entities;

use formCreator\entities\Entity;

class FormElement extends Entity
{
    protected $name;
    protected $type;
    protected $template;
    protected $values;
    public static $type_definition = array(
        'text' => array('name'),
        'textarea' => array('name'),
        'dropdown' => array('name', 'values'),
        'multiselect' => array('name', 'values'),
        'radio' => array('name' => 'values'),
        'switch' => array('name', 'values'),
        'file' => array('name')
    );

    public function setStorage($storage)
    {
        $this->storage = $storage;
        return $this;
    }

    public function getTemplate($type)
    {
        return 4;
    }
}

