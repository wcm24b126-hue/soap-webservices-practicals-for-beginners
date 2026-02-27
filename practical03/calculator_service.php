<?php
ini_set("soap.wsdl_cache_enabled", "0");

// WSDL Generator - Menu Card
if(isset($_GET['wsdl'])){
    header('Content-Type: text/xml; charset=utf-8');
    echo '<?xml version="1.0" encoding="UTF-8"?>
<definitions name="CalculatorService"
targetNamespace="urn:CalculatorService"
xmlns:tns="urn:CalculatorService"
xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"
xmlns:xsd="http://www.w3.org/2001/XMLSchema"
xmlns="http://schemas.xmlsoap.org/wsdl/">

  <!-- add messages -->
  <message name="addRequest">
    <part name="a" type="xsd:int"/>
    <part name="b" type="xsd:int"/>
  </message>
  <message name="addResponse">
    <part name="return" type="xsd:int"/>
  </message>

  <!-- subtract messages -->
  <message name="subtractRequest">
    <part name="a" type="xsd:int"/>
    <part name="b" type="xsd:int"/>
  </message>
  <message name="subtractResponse">
    <part name="return" type="xsd:int"/>
  </message>

  <!-- multiply messages -->
  <message name="multiplyRequest">
    <part name="a" type="xsd:int"/>
    <part name="b" type="xsd:int"/>
  </message>
  <message name="multiplyResponse">
    <part name="return" type="xsd:int"/>
  </message>

  <!-- divide messages -->
  <message name="divideRequest">
    <part name="a" type="xsd:int"/>
    <part name="b" type="xsd:int"/>
  </message>
  <message name="divideResponse">
    <part name="return" type="xsd:float"/>
  </message>

  <portType name="CalculatorServicePortType">
    <operation name="add">
      <input  message="tns:addRequest"/>
      <output message="tns:addResponse"/>
    </operation>
    <operation name="subtract">
      <input  message="tns:subtractRequest"/>
      <output message="tns:subtractResponse"/>
    </operation>
    <operation name="multiply">
      <input  message="tns:multiplyRequest"/>
      <output message="tns:multiplyResponse"/>
    </operation>
    <operation name="divide">
      <input  message="tns:divideRequest"/>
      <output message="tns:divideResponse"/>
    </operation>
  </portType>

  <binding name="CalculatorServiceBinding" type="tns:CalculatorServicePortType">
    <soap:binding style="rpc" transport="http://schemas.xmlsoap.org/soap/http"/>

    <operation name="add">
      <soap:operation soapAction="add"/>
      <input><soap:body use="encoded" namespace="urn:CalculatorService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></input>
      <output><soap:body use="encoded" namespace="urn:CalculatorService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></output>
    </operation>

    <operation name="subtract">
      <soap:operation soapAction="subtract"/>
      <input><soap:body use="encoded" namespace="urn:CalculatorService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></input>
      <output><soap:body use="encoded" namespace="urn:CalculatorService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></output>
    </operation>

    <operation name="multiply">
      <soap:operation soapAction="multiply"/>
      <input><soap:body use="encoded" namespace="urn:CalculatorService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></input>
      <output><soap:body use="encoded" namespace="urn:CalculatorService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></output>
    </operation>

    <operation name="divide">
      <soap:operation soapAction="divide"/>
      <input><soap:body use="encoded" namespace="urn:CalculatorService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></input>
      <output><soap:body use="encoded" namespace="urn:CalculatorService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></output>
    </operation>

  </binding>

  <service name="CalculatorService">
    <port name="CalculatorServicePort" binding="tns:CalculatorServiceBinding">
      <soap:address location="http://localhost:8080/soap_practicals/practical03/calculator_service.php"/>
    </port>
  </service>

</definitions>';
    exit;
}
class CalculatorService {
public function add($a, $b) { return $a + $b; }
public function subtract($a, $b) { return $a - $b; }
public function multiply($a, $b) { return $a * $b; }
public function divide($a, $b) {
if($b == 0) throw new SoapFault("Server", "Division by zero");
return $a / $b;
}
}
$server = new SoapServer(null, ['uri' =>
"http://localhost:8080/soap_practicals/practical03/calculator_service.php"]);
$server->setClass('CalculatorService');
$server->handle();
?>