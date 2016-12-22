<?php

namespace Kahyam;

class Response
{
    private $curl_error_no = null;
    private $curl_error_msg = null;

    private $error = false;
    private $curl_error = false;
    private $output = null;

    public function __construct($output)
    {
        $curl_error = $output['curl_error'];
        $this->output = $output['data'];
        if (!is_null($curl_error)) {
            $this->curl_error_no = $curl_error['number'];
            $this->curl_error_msg = $curl_error['message'];
            $this->error = true;
            $this->curl_error = true;
        } else {
            $this->output = json_decode($this->output, true);
            if (!$this->output['status']) {
                $this->error = true;
                $this->output = $this->output['errors'];
            } else {
                $this->output = $this->output['data'];
            }
        }
    }

    public function error()
    {
        if ($this->error) {
            if ($this->curl_error) {
                return [
                    'code'       => $this->curl_error_no,
                    'message'    => $this->curl_error_msg,
                    'curl_error' => true,
                ];
            } else {
                return array_map(function ($error) {
                    $error['curl_error'] = false;

                    return $error;
                }, $this->output);
            }
        }

        return [];
    }

    public function output()
    {
        if (!$this->error) {
            return $this->output;
        }

        return [];
    }

    public function isError()
    {
        return $this->error;
    }
}
