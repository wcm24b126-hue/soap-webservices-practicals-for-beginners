<?php
ini_set("soap.wsdl_cache_enabled", "0");

// WSDL Generator - Menu Card
if(isset($_GET['wsdl'])){
    header('Content-Type: text/xml; charset=utf-8');
    echo '<?xml version="1.0" encoding="UTF-8"?>
<definitions name="StudentService"
targetNamespace="urn:StudentService"
xmlns:tns="urn:StudentService"
xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"
xmlns:xsd="http://www.w3.org/2001/XMLSchema"
xmlns="http://schemas.xmlsoap.org/wsdl/">

  <!-- addStudent messages -->
  <message name="addStudentRequest">
    <part name="id"   type="xsd:int"/>
    <part name="name" type="xsd:string"/>
    <part name="age"  type="xsd:int"/>
  </message>
  <message name="addStudentResponse">
    <part name="return" type="xsd:string"/>
  </message>

  <!-- getStudentDetails messages -->
  <message name="getStudentDetailsRequest">
    <part name="id" type="xsd:int"/>
  </message>
  <message name="getStudentDetailsResponse">
    <part name="return" type="xsd:string"/>
  </message>

  <!-- deleteStudent messages -->
  <message name="deleteStudentRequest">
    <part name="id" type="xsd:int"/>
  </message>
  <message name="deleteStudentResponse">
    <part name="return" type="xsd:string"/>
  </message>

  <portType name="StudentServicePortType">
    <operation name="addStudent">
      <input  message="tns:addStudentRequest"/>
      <output message="tns:addStudentResponse"/>
    </operation>
    <operation name="getStudentDetails">
      <input  message="tns:getStudentDetailsRequest"/>
      <output message="tns:getStudentDetailsResponse"/>
    </operation>
    <operation name="deleteStudent">
      <input  message="tns:deleteStudentRequest"/>
      <output message="tns:deleteStudentResponse"/>
    </operation>
  </portType>

  <binding name="StudentServiceBinding" type="tns:StudentServicePortType">
    <soap:binding style="rpc" transport="http://schemas.xmlsoap.org/soap/http"/>

    <operation name="addStudent">
      <soap:operation soapAction="addStudent"/>
      <input><soap:body use="encoded" namespace="urn:StudentService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></input>
      <output><soap:body use="encoded" namespace="urn:StudentService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></output>
    </operation>

    <operation name="getStudentDetails">
      <soap:operation soapAction="getStudentDetails"/>
      <input><soap:body use="encoded" namespace="urn:StudentService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></input>
      <output><soap:body use="encoded" namespace="urn:StudentService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></output>
    </operation>

    <operation name="deleteStudent">
      <soap:operation soapAction="deleteStudent"/>
      <input><soap:body use="encoded" namespace="urn:StudentService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></input>
      <output><soap:body use="encoded" namespace="urn:StudentService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></output>
    </operation>

  </binding>

  <service name="StudentService">
    <port name="StudentServicePort" binding="tns:StudentServiceBinding">
      <soap:address location="http://localhost:8080/soap_practicals/P02 - Student Management/student_service.php"/>
    </port>
  </service>

</definitions>';
    exit;
}

// Actual Service - Real Work
class StudentService {
private $students = [];
public function addStudent($id, $name, $age) {
$this->students[$id] = ['id'=>$id,'name'=>$name,'age'=>$age];
return "Student added successfully.";
}
public function getStudentDetails($id) {
return $this->students[$id] ?? "Student not found.";
}
public function deleteStudent($id) {
if(isset($this->students[$id])) {
unset($this->students[$id]);
return "Student deleted successfully.";
}
return "Student not found.";
}
}

$server = new SoapServer(
    "http://localhost:8080/soap_practicals/P02 - Student Management/student_service.php?wsdl"
);
$server->setClass('StudentService');
$server->handle();
?>
