<?php

namespace formCreator\app\Storage;

use formCreator\app\Storage\Mysql\MysqlStorage;
use formCreator\app\Storage\XML\XMLStorage;

class StorageFactory
{
    public static function createStorage($configs)
    {
        switch ($configs['storage']) {
            case 'mysql':
                return new MysqlStorage($configs['storage_settings']);
            break;
            case 'XML':
                return new XMLStorage($configs['storage_settings']);
            break;
        }
    }
}

