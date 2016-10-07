<?php
/**
 * Created by PhpStorm.
 * User: dimador
 * Date: 7.10.16
 * Time: 12.12
 */

namespace formCreator\entities;

abstract class Entity
{
    protected $storage;

    abstract public function setStorage($storage);
}