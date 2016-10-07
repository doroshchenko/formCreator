<?php

namespace formCreator\app;

class Request
{
    /**
     * HTTP  method
     *
     * @var string
     */
    protected $method;

    /**
     * Url path
     *
     * @var string
     */
    public $url;

    /**
     * Request params
     *
     * @var array
     */
    public $httpParams = array();

    public function __construct($url, $httpParams)
    {
        $this->url = $url;
        $this->httpParams = $httpParams;
    }

    public function getHttpParams()
    {
        return $this->httpParams;
    }
}