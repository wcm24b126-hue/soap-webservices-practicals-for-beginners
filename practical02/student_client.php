<?php
$client = new SoapClient(null, [
'location' => "http://localhost:8080/soap_practicals/practical02/student_service.php",
'uri' => "http://localhost:8080/soap_practicals/practical02/student_service.php",
]);
echo $client->addStudent(1, "John", 20) . "<br>";
echo $client->getStudentDetails(1)['name'] . "<br>";
echo $client->deleteStudent(1) . "<br>";
echo $client->getStudentDetails(1) . "<br>";
?>