<?php

spl_autoload_register(function ($class) {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    require_once $file;
});

$config = require_once 'formCreator/config/configs.php';
$app = new formCreator\Application();
$app->run($config);

