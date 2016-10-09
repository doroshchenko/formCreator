<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 9.10.16
 * Time: 10.42
 */

namespace formCreator\app;


class View
{
    const TPL_PATH = 'formCreator/views/';

    public $template;
    public $params;

    public static function create($template, array $params)
    {
        $templateName = self::TPL_PATH . $template . '.php';
        if (!file_exists($templateName)) {
            throw new \Exception('view ' . $templateName . ' doesn\'t exist');
        }
        ob_start();
        foreach ($params as $name => $value) {
            ${$name} = $value;
        }
        include_once $templateName;
        $buffer = ob_get_clean();

        return $buffer;
    }
}

