<?php
$client = new SoapClient(null, [
    'location' => "http://localhost:8080/soap_practicals/practical01/hello_server.php",
    'uri'      => "http://localhost:8080/soap_practicals/practical01/hello_server.php",
]);

$response = $client->sayHello("Alice");
echo $response;
?>