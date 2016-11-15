<?php

namespace formCreator\app\Storage;

abstract class AbstractStorage
{
    abstract public function getData($mode);

    abstract public function save($entity);

    abstract public function delete($entity);
}