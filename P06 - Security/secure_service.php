<?php
// ============================================================
// Practical 06 - SOAP Security (Basic Authentication)
// ============================================================
ini_set("soap.wsdl_cache_enabled", "0");

// ============================================================
// Basic Authentication Check
// Valid credentials: admin / password123
// ============================================================
$validUsername = "admin";
$validPassword = "password123";

function checkAuth($username, $password) {
    global $validUsername, $validPassword;
    if($username === $validUsername && $password === $validPassword) {
        return true;
    }
    return false;
}

// WSDL Generator
if(isset($_GET['wsdl'])){
    header('Content-Type: text/xml; charset=utf-8');
    echo '<?xml version="1.0" encoding="UTF-8"?>
<definitions name="SecureService"
targetNamespace="urn:SecureService"
xmlns:tns="urn:SecureService"
xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"
xmlns:xsd="http://www.w3.org/2001/XMLSchema"
xmlns="http://schemas.xmlsoap.org/wsdl/">

  <!-- getSecretMessage messages -->
  <message name="getSecretMessageRequest">
    <part name="username" type="xsd:string"/>
    <part name="password" type="xsd:string"/>
  </message>
  <message name="getSecretMessageResponse">
    <part name="return" type="xsd:string"/>
  </message>

  <!-- getPublicMessage messages (no auth needed) -->
  <message name="getPublicMessageRequest"/>
  <message name="getPublicMessageResponse">
    <part name="return" type="xsd:string"/>
  </message>

  <!-- getUserInfo messages -->
  <message name="getUserInfoRequest">
    <part name="username" type="xsd:string"/>
    <part name="password" type="xsd:string"/>
  </message>
  <message name="getUserInfoResponse">
    <part name="return" type="xsd:string"/>
  </message>

  <portType name="SecureServicePortType">
    <operation name="getSecretMessage">
      <input  message="tns:getSecretMessageRequest"/>
      <output message="tns:getSecretMessageResponse"/>
    </operation>
    <operation name="getPublicMessage">
      <input  message="tns:getPublicMessageRequest"/>
      <output message="tns:getPublicMessageResponse"/>
    </operation>
    <operation name="getUserInfo">
      <input  message="tns:getUserInfoRequest"/>
      <output message="tns:getUserInfoResponse"/>
    </operation>
  </portType>

  <binding name="SecureServiceBinding" type="tns:SecureServicePortType">
    <soap:binding style="rpc" transport="http://schemas.xmlsoap.org/soap/http"/>

    <operation name="getSecretMessage">
      <soap:operation soapAction="getSecretMessage"/>
      <input><soap:body use="encoded" namespace="urn:SecureService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></input>
      <output><soap:body use="encoded" namespace="urn:SecureService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></output>
    </operation>

    <operation name="getPublicMessage">
      <soap:operation soapAction="getPublicMessage"/>
      <input><soap:body use="encoded" namespace="urn:SecureService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></input>
      <output><soap:body use="encoded" namespace="urn:SecureService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></output>
    </operation>

    <operation name="getUserInfo">
      <soap:operation soapAction="getUserInfo"/>
      <input><soap:body use="encoded" namespace="urn:SecureService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></input>
      <output><soap:body use="encoded" namespace="urn:SecureService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></output>
    </operation>

  </binding>

  <service name="SecureService">
    <port name="SecureServicePort" binding="tns:SecureServiceBinding">
      <soap:address location="http://localhost:8080/Soap_practicals/P06 - Security/secure_service.php"/>
    </port>
  </service>

</definitions>';
    exit;
}

// ============================================================
// Secure Service Class
// ============================================================
class SecureService {

    // 🔓 Public method - no auth needed
    public function getPublicMessage() {
        return "✅ This is a PUBLIC message - anyone can see this!";
    }

    // 🔐 Protected method - auth needed
    public function getSecretMessage($username, $password) {
        if(!checkAuth($username, $password)) {
            throw new SoapFault("Client",
                "❌ Unauthorized! Invalid username or password.");
        }
        return "🔐 SECRET MESSAGE: Welcome " . $username . "! " .
               "You have access to classified information. " .
               "Auth successful at: " . date('Y-m-d H:i:s');
    }

    // 🔐 Protected method - returns user info
    public function getUserInfo($username, $password) {
        if(!checkAuth($username, $password)) {
            throw new SoapFault("Client",
                "❌ Unauthorized! Invalid username or password.");
        }
        return "👤 User Info | Username: " . $username .
               " | Role: Administrator | Access Level: Full | " .
               "Last Login: " . date('Y-m-d H:i:s');
    }
}

$server = new SoapServer(
    "http://localhost:8080/Soap_practicals/P06 - Security/secure_service.php?wsdl"
);
$server->setClass('SecureService');
$server->handle();
?>

