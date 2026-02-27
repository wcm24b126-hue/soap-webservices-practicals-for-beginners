<?php
// Initialize in WSDL mode
$client = new SoapClient("http://localhost:8080/soap_practicals/practical04/employee_service.php?wsdl");

$emp = new stdClass();
$emp->id = 1; 
$emp->name = "Alice"; 
$emp->position = "Manager"; 
$emp->salary = 5000;

echo $client->addEmployee($emp) . "<br>";

$retrieved = $client->getEmployee(1);
if ($retrieved) {
    // When returning complex types, PHP SOAP client sometimes returns them as objects
    // If it returns as an array, you might need $retrieved['name']
    // But usually it's an object if using WSDL
    echo $retrieved->name . " - " . $retrieved->position . "<br>";
} else {
    echo "Employee not found.<br>";
}
?>