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
    const CSS_PATH = 'formCreator/views/css';
    public $template;
    public $params;

    public static function create($template, array $params)
    {
        $templateName = self::TPL_PATH . $template . '.php';
        if (!file_exists($templateName)) {
            throw new \Exception('view ' . $templateName . ' doesn\'t exist');
        }
        ob_start();

        self::addCss();
        self::addJs();
        foreach ($params as $name => $value) {
            ${$name} = $value;
        }
        include_once $templateName;
        $buffer = ob_get_clean();

        return $buffer;
    }

    public static function addCss($dir = self::CSS_PATH)
    {
        $dir_files = array_diff(scandir($dir), array('.', '..'));
        foreach ($dir_files as $file) {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $file)) {
                return self::addCss($dir . DIRECTORY_SEPARATOR . $file);
            } else {
                if (pathinfo($file, PATHINFO_EXTENSION) == 'css') {
                    echo '<link type="text/css" rel="stylesheet" href="../' . $dir . DIRECTORY_SEPARATOR . $file . '">';
                }
            }

        }
    }

    public static function addJs()
    {

    }
}

