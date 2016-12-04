<?php

namespace Kahyam;


class API{

    private $connection = null;
    private $request    = null;
    private $response   = null;

    private $username   = null;
    private $api_key    = null;

    public function __construct($username=null,$api_key=null){
        $this->connection = new Connection($username,$api_key);
    }

    /**
     * @param $username
     */
    public function setUsername($username){
        $this->username = $username;
    }

    /**
     * @param $api_key
     */
    public function setApiKey($api_key){
        $this->api_key = $api_key;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getApiKey(){
        return $this->api_key;
    }

    public function setRequest(Request $request){
        $this->request = $request;
        $this->connection->setRequest($this->request);
        $this->curl();
        return $this;
    }

    public function getRequest(){
        return $this->request;
    }

    public function getResponse(){
        return $this->response;
    }

    protected function curl(){
        $output = $this->connection->connect();
        $this->response = new Response($output);
        return $this;
    }


}