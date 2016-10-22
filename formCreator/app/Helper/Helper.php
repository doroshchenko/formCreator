<?php

namespace formCreator\app\Helper;

class Helper
{
    protected static $params = array();

    public static function getHttpParams()
    {
        $params = $_GET + $_POST;
        foreach ($params as $param => $value) {
            self::$params[$param] = $value;
        }
        return self::$params;
    }

    public function getRequestPath()
    {
        return $_SERVER['REQUEST_URI'];
    }
}
