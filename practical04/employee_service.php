<?php
ini_set("soap.wsdl_cache_enabled", "0");


// WSDL Generator - Menu Card
if(isset($_GET['wsdl'])){
    header('Content-Type: text/xml; charset=utf-8');
    echo '<?xml version="1.0" encoding="UTF-8"?>
<definitions name="EmployeeService"
targetNamespace="urn:EmployeeService"
xmlns:tns="urn:EmployeeService"
xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"
xmlns:xsd="http://www.w3.org/2001/XMLSchema"
xmlns="http://schemas.xmlsoap.org/wsdl/">

  <types>
    <xsd:schema targetNamespace="urn:EmployeeService">
      <xsd:complexType name="Employee">
        <xsd:all>
          <xsd:element name="id" type="xsd:int" />
          <xsd:element name="name" type="xsd:string" />
          <xsd:element name="position" type="xsd:string" />
          <xsd:element name="salary" type="xsd:float" />
        </xsd:all>
      </xsd:complexType>
    </xsd:schema>
  </types>


  <!-- addEmployee messages -->
  <message name="addEmployeeRequest">
    <part name="employee" type="tns:Employee"/>
  </message>

  <message name="addEmployeeResponse">
    <part name="return" type="xsd:string"/>
  </message>

  <!-- getEmployee messages -->
  <message name="getEmployeeRequest">
    <part name="id" type="xsd:int"/>
  </message>
  <message name="getEmployeeResponse">
    <part name="return" type="tns:Employee"/>
  </message>


  <!-- updateEmployee messages -->
  <message name="updateEmployeeRequest">
    <part name="id"       type="xsd:int"/>
    <part name="name"     type="xsd:string"/>
    <part name="position" type="xsd:string"/>
    <part name="salary"   type="xsd:float"/>
  </message>
  <message name="updateEmployeeResponse">
    <part name="return" type="xsd:string"/>
  </message>

  <!-- deleteEmployee messages -->
  <message name="deleteEmployeeRequest">
    <part name="id" type="xsd:int"/>
  </message>
  <message name="deleteEmployeeResponse">
    <part name="return" type="xsd:string"/>
  </message>

  <portType name="EmployeeServicePortType">
    <operation name="addEmployee">
      <input  message="tns:addEmployeeRequest"/>
      <output message="tns:addEmployeeResponse"/>
    </operation>
    <operation name="getEmployee">
      <input  message="tns:getEmployeeRequest"/>
      <output message="tns:getEmployeeResponse"/>
    </operation>
    <operation name="updateEmployee">
      <input  message="tns:updateEmployeeRequest"/>
      <output message="tns:updateEmployeeResponse"/>
    </operation>
    <operation name="deleteEmployee">
      <input  message="tns:deleteEmployeeRequest"/>
      <output message="tns:deleteEmployeeResponse"/>
    </operation>
  </portType>

  <binding name="EmployeeServiceBinding" type="tns:EmployeeServicePortType">
    <soap:binding style="rpc" transport="http://schemas.xmlsoap.org/soap/http"/>

    <operation name="addEmployee">
      <soap:operation soapAction="addEmployee"/>
      <input><soap:body use="encoded" namespace="urn:EmployeeService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></input>
      <output><soap:body use="encoded" namespace="urn:EmployeeService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></output>

    </operation>

    <operation name="getEmployee">
      <soap:operation soapAction="getEmployee"/>
      <input><soap:body use="encoded" namespace="urn:EmployeeService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></input>
      <output><soap:body use="encoded" namespace="urn:EmployeeService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></output>

    </operation>

    <operation name="updateEmployee">
      <soap:operation soapAction="updateEmployee"/>
      <input><soap:body use="encoded" namespace="urn:EmployeeService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></input>
      <output><soap:body use="encoded" namespace="urn:EmployeeService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></output>

    </operation>

    <operation name="deleteEmployee">
      <soap:operation soapAction="deleteEmployee"/>
      <input><soap:body use="encoded" namespace="urn:EmployeeService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></input>
      <output><soap:body use="encoded" namespace="urn:EmployeeService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></output>

    </operation>

  </binding>

  <service name="EmployeeService">
    <port name="EmployeeServicePort" binding="tns:EmployeeServiceBinding">
      <soap:address location="http://localhost:8080/soap_practicals/practical04/employee_service.php"/>
    </port>
  </service>


</definitions>';
    exit;
}

class Employee {
public $id;
public $name;
public $position;
public $salary;
}
class EmployeeService {
private static $employees = [];
public function addEmployee($emp) {
self::$employees[$emp->id] = $emp;
return "Employee added successfully";
}
public function getEmployee($id) {
return self::$employees[$id] ?? null;
}

public function updateEmployee($emp) {
if(isset($this->employees[$emp->id])) {
$this->employees[$emp->id] = $emp;
return "Employee updated successfully";
}
return "Employee not found";
}
}
$server = new SoapServer("http://localhost:8080/soap_practicals/practical04/employee_service.php?wsdl");

$server->setClass('EmployeeService');
$server->handle();
?>