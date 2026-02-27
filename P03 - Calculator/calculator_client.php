<?php
$client = new SoapClient(null, [
'location' => "http://localhost:8080/soap_practicals/P03 - Calculator/calculator_service.php",
'uri' => "http://localhost:8080/soap_practicals/P03 - Calculator/calculator_service.php",
]);
echo "Add: ".$client->add(5,3)."<br>";
echo "Divide: ".$client->divide(10,2)."<br>";
?>
