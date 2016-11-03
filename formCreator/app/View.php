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
    const JS_PATH = 'formCreator/views/js';
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

    /**
     * adding to buffer all css files in $dir recursively
     * @param string $dir
     * @return mixed
     */
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

    public static function addJs($dir = self::JS_PATH)
    {
        self::addJsLibs($dir . DIRECTORY_SEPARATOR . 'libs');

        $scripts = '<script src="../' . $dir . DIRECTORY_SEPARATOR .  'formCreator.js"></script>';
        $scripts .= '';

        echo $scripts;

    }

    public static function addJsLibs($path)
    {
        $libs = '<script src="../' . $path. DIRECTORY_SEPARATOR . 'prototype.js"></script>';
        $libs .= '';

        echo $libs;
    }
}

