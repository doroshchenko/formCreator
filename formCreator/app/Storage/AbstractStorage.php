<?php

namespace formCreator\app\Storage;

abstract class AbstractStorage
{
    abstract public function getAll();

    abstract public function getEntityByID($id);

    abstract public function save($entity);

    abstract public function delete($entity);
}