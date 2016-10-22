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

    /**
     * getter/setter
     *
     * @param $name
     * @param $value
     * @return $this
     */

    public function __call($name, $value)
    {
        $method = substr($name, 0, 3);
        if ($method == 'set') {
            $prop = strtolower(substr($name, 3));
            if (property_exists($this, $prop)) {
                $this->{$prop} = $value[0];
                return $this;
            }
        } else if ($method == 'get') {
            $prop = strtolower(substr($name, 3));
            if (property_exists($this, $prop)) {
                return $this->{$prop};
            }
        }

       return false;
    }
}