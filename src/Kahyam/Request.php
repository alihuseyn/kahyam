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
    protected $url = 'https://kahyam.co/sandbox/api/v1/';

    protected $out = false;

    protected $params = null;
    protected $body = null;

    public function __construct()
    {
        $this->body = [];
        $this->params = [];
    }

    public function setUrl($url='https://kahyam.co/sandbox/api/v1/')
    {
        if (!is_null($url) && !empty($url) ) {
            if ($this->contains($url, 'https://kahyam.co/') && $this->contains($url, 'api/v1/', 'END')) {
                $this->url = $url;

                return $this;
            }
        }
        throw new \Exception('Correct api url is not used');
    }

    public function setOut()
    {
        $this->out = true;

        return $this;
    }

    public function isFirmCode()
    {
        return $this->out;
    }

    protected function contains($haystack, $needle, $case = 'START')
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        if ($case == 'START') {
            return (substr($haystack, 0, $length) === $needle);
        } elseif ($case == 'END') {
            return (substr($haystack, -$length) === $needle);
        }

        return false;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setMethod($method = 'GET')
    {
        $this->method = $method;

        return $this;
    }

    public function getMethod()
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

    public function __call($name, $arguments)
    {
        if ($name == 'setBody'){
            if (is_array($arguments[0])) {
                $this->setBodyArray($arguments[0]);
            } else {
                if (isset($arguments[0]) && isset($arguments[1]) && is_string($arguments[0])) {
                    $this->setBodyKeyValue($arguments[0], $arguments[1]);
                }
            }

            return $this;
        } elseif ($name == 'setParams'){
            if (is_array($arguments[0])) {
                $this->setParamsArray($arguments[0]);
            } else {
                if (isset($arguments[0]) && isset($arguments[1]) && is_string($arguments[0])) {
                    $this->setParamsKeyValue($arguments[0], $arguments[1]);
                }
            }

            return $this;
        }
        $trace = debug_backtrace()[1];
        $error = "PHP Fatal error: Call to undefined method {$trace['class']}::{$trace['function']} in {$trace['file']} on line {$trace['line']}".PHP_EOL;
        throw(new \Exception($error));
    }

    protected function setParamsKeyValue($key, $value)
    {
        $this->params[$key] = $value;

        return $this;
    }

    protected function setParamsArray(array $params)
    {
        $this->params = $params;

        return $this;
    }

    public function getParams()
    {
        return is_null($this->params) ? [] : $this->params;
    }



    protected function setBodyKeyValue($key, $value)
    {
        $this->body[$key] = $value;
    }

    protected function setBodyArray(array $content){
        $this->body = $content;
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
