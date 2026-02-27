<?php
ini_set("soap.wsdl_cache_enabled", "0");
if(isset($_GET['wsdl'])){
header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>
<definitions name="HelloService"
targetNamespace="urn:HelloService"
xmlns:tns="urn:HelloService"
xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"
xmlns:xsd="http://www.w3.org/2001/XMLSchema"
xmlns="http://schemas.xmlsoap.org/wsdl/">
<message name="sayHelloRequest">
<part name="name" type="xsd:string"/>
</message>
<message name="sayHelloResponse">
<part name="return" type="xsd:string"/>
</message>
<portType name="HelloServicePortType">
<operation name="sayHello">
<input message="tns:sayHelloRequest"/>
<output message="tns:sayHelloResponse"/>
</operation>
</portType>
<binding name="HelloServiceBinding" type="tns:HelloServicePortType">
<soap:binding style="rpc" transport="http://schemas.xmlsoap.org/soap/http"/>
<operation name="sayHello">
<soap:operation soapAction="sayHello"/>
<input><soap:body use="encoded" namespace="urn:HelloService"
encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></input>
<output><soap:body use="encoded" namespace="urn:HelloService"
encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></output>
</operation>
</binding>
<service name="HelloService">
<port name="HelloServicePort" binding="tns:HelloServiceBinding">
<soap:address location="http://localhost:8080/soap_practicals/P01 - Hello World/hello_server.php"/>
</port>
</service>
</definitions>';
exit;
}
class HelloService {
public function sayHello($name) {
return "Hello, " . $name . "!";
}
}
$server = new SoapServer("http://localhost:8080/soap_practicals/P01 - Hello World/hello_server.php?wsdl");
$server->setClass('HelloService');
$server->handle();
?>
```

**Step 4:** **Ctrl+S** කරලා save කරං

**Step 5:** Browser ගා refresh කරං:
```
http://localhost:8080/soap_practicals/hello_server.php?wsdl
```

---

## Important Check ⚠️

URL ගා **capital S** නෑ බලං:
```
soap_practicals  ✅ (small s)
Soap_practicals  ❌ (capital S)
