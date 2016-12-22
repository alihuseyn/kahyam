<?php

namespace Kahyam;

class Request
{
    const GET = 'GET';
    const POST = 'POST';
    const DELETE = 'DELETE';
    const PUT = 'PUT';

    protected $id = null;
    protected $method = null;
    protected $endpoint = null;

    protected $params = null;
    protected $body = null;


    public function __construct()
    {
        $this->body   = [];
        $this->params = [];
    }

    public function setMethod($method = 'GET')
    {
        $this->method = $method;

        return $this;
    }

    public  function getMethod()
    {
        return $this->method;
    }

    public function setEndPoint($endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    public function getEndPoint()
    {
        return$this->endpoint;
    }

    public function setParams($key, $value)
    {
        $this->params[strtolower($key)] = $value;

        return $this;
    }

    public function getParams()
    {
        return is_null($this->params) ? [] : $this->params;
    }

    public function setBody($key, $value)
    {
        $this->body[$key] = $value;

        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setID($id)
    {
        if (!is_null($id) && !empty($id)) {
            $this->id = $id;
        }

        return $this;
    }

    public function getID()
    {
        return $this->id;
    }
}