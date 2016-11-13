<?php

namespace formCreator\entities;

use formCreator\entities\Entity;
use formCreator\app\Storage\EntitySerializer;

class FormElement extends Entity
{
    protected $id_form_element;
    protected $id_form;
    protected $name;
    protected $type;
    protected $template;
    protected $label;
    protected $values = array();

    public static $type_definition = array(
        'text' => array('name'),
        'textarea' => array('name'),
        'dropdown' => array('name', 'values'),
        'multiselect' => array('name', 'values'),
        'radio' => array('name' => 'values'),
        'checkbox' => array('name', 'values'),
        'file' => array('name'),
        'hidden' => array('name')
    );

    public function setStorage($storage)
    {
        $this->storage = $storage;
        return $this;
    }

    /*public function setValues(array $values)
    {
        $elementClass = 'formCreator\entities\FormElementValue';
        $this->values = EntitySerializer::createEntities($values, $elementClass);

        return $this;
    }*/

}

