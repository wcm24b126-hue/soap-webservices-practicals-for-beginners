<?php
$client = new SoapClient(null, [
    'location' => "http://localhost:8080/soap_practicals/P01 - Hello World/hello_server.php",
    'uri'      => "http://localhost:8080/soap_practicals/P01 - Hello World/hello_server.php",
]);

$response = $client->sayHello("Alice");
echo $response;
?>
