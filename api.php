<?php


require 'src/autoload.php';

$username = ''; // Username For Kahyam Commercial
$api_key = ''; // Api Key For Kahyam Commercial

try {
    $request = new \Kahyam\Request();
    $request->setMethod(Kahyam\Request::GET)
        ->setEndPoint(Kahyam\Endpoint::REPORTS)
        ->setParams([
            'interval' => '20161227;20161227',
            'limit'    => 1,
        ])
        ->setUrl();

    $api = new \Kahyam\API($username, $api_key);
    $response = $api->setRequest($request)->getResponse();

    if (!$response->isError()) {
        print_r($response->output());
    } else {
        print_r($response->error());
    }

} catch (Exception $err) {
    print_r($err->getMessage());
}
