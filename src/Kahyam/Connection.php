<?php

namespace Kahyam;

class Connection
{
    const url = 'https://kahyam.co/sandbox/api/v1/';
    private $username = null;
    private $api_key = null;
    private $request = null;

    private $curl_url = null;
    private $curl_method = null;
    private $curl_params = null;
    private $curl_body = null;

    private $curl_output = null;

    public function __construct($username = null, $api_key = null)
    {
        $this->username = $username;
        $this->api_key = $api_key;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    protected function initialize()
    {
        $this->curl_output = [];
        $this->curl_method = $this->request->getMethod();
        $this->curl_url = $this->url();
        $this->curl_params = http_build_query($this->request->getParams());
        $this->curl_params = ((empty($this->curl_params) || is_null($this->curl_params)) ? '' : "&{$this->curl_params}");
        $this->curl_body = $this->request->getBody();
    }

    protected function url()
    {
        $required = '';
        if (!is_null($this->request->getID()) && !empty($this->request->getID())) {
            $required = "/{$this->request->getID()}";
        }

        return self::url.$this->request->getEndPoint()."{$required}?username={$this->username}&api_key={$this->api_key}";
    }

    public function connect()
    {
        if (function_exists('curl_version')) {
            $this->initialize();
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "{$this->curl_url}&{$this->curl_params}");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            if (Request::POST == $this->request->getMethod()) {
                curl_setopt($ch, CURLOPT_POST, true);
            } elseif (Request::PUT == $this->request->getMethod() || Request::DELETE == $this->request->getMethod()) {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->request->getMethod());
            }

            if (Request::POST == $this->request->getMethod() || Request::PUT == $this->request->getMethod()) {
                if (Request::PUT == $this->request->getMethod()) {
                    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
                }
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->curl_body));
            }
            $output = curl_exec($ch);

            if (curl_errno($ch)) {
                $this->curl_output = [
                    'curl_error' => [
                        'number'  => curl_errno($ch),
                        'message' => curl_error($ch),
                    ],
                    'data' => null,
                ];
            } else {
                $this->curl_output = [
                    'curl_error' => null,
                    'data'       => $output,
                ];
            }
            curl_close($ch);
        } else {
            $this->curl_output = [
                                    'curl_error' => [
                                        'number'  => '',
                                        'message' => 'Curl not available or disabled',
                                    ],
                                    'data' => null,
                                ];
        }

        return $this->curl_output;
    }
 }