# Kahyam
## Kahyam Commercial API
With this package the kahyam api usage is simplified.
  - Simple Request initialization
  - Procedure for curl
  - Response after request

## Usage
### Method
```sh
PUT    = Kahyam\Request::PUT
POST   = Kahyam\Request::POST
DELETE = Kahyam\Request::DELETE
GET    = Kahyam\Request::GET
```
### Endpoint
```sh
api/v1/sales = Kahyam\Endpoint::SALES
api/v1/hours = Kahyam\Endpoint::HOURS
api/v1/not_work_dates = Kahyam\Endpoint::HOLIDAYS
api/v1/reports = Kahyam\Endpoint::REPORTS
api/v1/places = Kahyam\Endpoint::PLACES
```
### Code
```sh
$request = new \Kahyam\Request();
$request->setMethod(Kahyam\Request::PUT)
        ->setEndPoint(Kahyam\Endpoint::SALES)
        ->setParams('prettyPrint',true) # Setting Url Parameters
        ->setBody('phone','5331456147') # Setting Body Items
        ->setID('KHY0001638');          # Specifying Which Order

$api = new \Kahyam\API($username,$api_key); # initialization for API
$response = $api->setRequest($request)->getResponse(); # Get Response
``` 
### More Info

wwww.kahyam.co
