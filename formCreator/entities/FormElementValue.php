<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 7.11.16
 * Time: 17.57
 */

namespace formCreator\entities;


class FormElementValue extends Entity
{
    protected $id_form_element;
    protected $value;


    public function setStorage($storage)
    {
        $this->storage = $storage;
        return $this;
    }

}