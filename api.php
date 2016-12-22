<?php


require 'src/autoload.php';

$username = ''; // Username For Kahyam Commercial
$api_key = ''; // Api Key For Kahyam Commercial

$request = new \Kahyam\Request();
$request->setMethod(Kahyam\Request::PUT)
        ->setEndPoint(Kahyam\Endpoint::SALES)
        ->setBody('phone', '5077352617')
        ->setID('KHY0001638');

$api = new \Kahyam\API($username, $api_key);
$response = $api->setRequest($request)->getResponse();

if (!$response->isError()) {
    print_r($response->output());
} else {
    print_r($response->error());

}