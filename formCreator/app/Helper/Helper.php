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

    /**
     *  process method to prop name / example $mehtod = IdForm / prop = id_form
     * @param $method - method name
     * @return string - property name
     *
     */
    public static function methodToProperty($method)
    {
        preg_match_all('/[A-Z][^A-Z]+/', $method, $results);
        $propName = '';
        foreach ($results as $keyword) {
            $propName .= strtolower(implode('_', $keyword));
        }

        return $propName;
    }
}
