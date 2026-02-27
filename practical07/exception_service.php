<?php
// ============================================================
// Practical 07 - Exception Handling in SOAP
// ============================================================
ini_set("soap.wsdl_cache_enabled", "0");

// WSDL Generator
if(isset($_GET['wsdl'])){
    header('Content-Type: text/xml; charset=utf-8');
    echo '<?xml version="1.0" encoding="UTF-8"?>
<definitions name="ExceptionService"
targetNamespace="urn:ExceptionService"
xmlns:tns="urn:ExceptionService"
xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"
xmlns:xsd="http://www.w3.org/2001/XMLSchema"
xmlns="http://schemas.xmlsoap.org/wsdl/">

  <!-- divide messages -->
  <message name="divideRequest">
    <part name="a" type="xsd:int"/>
    <part name="b" type="xsd:int"/>
  </message>
  <message name="divideResponse">
    <part name="return" type="xsd:float"/>
  </message>

  <!-- getStudent messages -->
  <message name="getStudentRequest">
    <part name="id" type="xsd:int"/>
  </message>
  <message name="getStudentResponse">
    <part name="return" type="xsd:string"/>
  </message>

  <!-- processAge messages -->
  <message name="processAgeRequest">
    <part name="age" type="xsd:int"/>
  </message>
  <message name="processAgeResponse">
    <part name="return" type="xsd:string"/>
  </message>

  <!-- transferMoney messages -->
  <message name="transferMoneyRequest">
    <part name="fromAccount" type="xsd:int"/>
    <part name="toAccount"   type="xsd:int"/>
    <part name="amount"      type="xsd:float"/>
  </message>
  <message name="transferMoneyResponse">
    <part name="return" type="xsd:string"/>
  </message>

  <portType name="ExceptionServicePortType">
    <operation name="divide">
      <input  message="tns:divideRequest"/>
      <output message="tns:divideResponse"/>
    </operation>
    <operation name="getStudent">
      <input  message="tns:getStudentRequest"/>
      <output message="tns:getStudentResponse"/>
    </operation>
    <operation name="processAge">
      <input  message="tns:processAgeRequest"/>
      <output message="tns:processAgeResponse"/>
    </operation>
    <operation name="transferMoney">
      <input  message="tns:transferMoneyRequest"/>
      <output message="tns:transferMoneyResponse"/>
    </operation>
  </portType>

  <binding name="ExceptionServiceBinding" type="tns:ExceptionServicePortType">
    <soap:binding style="rpc" transport="http://schemas.xmlsoap.org/soap/http"/>

    <operation name="divide">
      <soap:operation soapAction="divide"/>
      <input><soap:body use="encoded" namespace="urn:ExceptionService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></input>
      <output><soap:body use="encoded" namespace="urn:ExceptionService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></output>
    </operation>

    <operation name="getStudent">
      <soap:operation soapAction="getStudent"/>
      <input><soap:body use="encoded" namespace="urn:ExceptionService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></input>
      <output><soap:body use="encoded" namespace="urn:ExceptionService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></output>
    </operation>

    <operation name="processAge">
      <soap:operation soapAction="processAge"/>
      <input><soap:body use="encoded" namespace="urn:ExceptionService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></input>
      <output><soap:body use="encoded" namespace="urn:ExceptionService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></output>
    </operation>

    <operation name="transferMoney">
      <soap:operation soapAction="transferMoney"/>
      <input><soap:body use="encoded" namespace="urn:ExceptionService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></input>
      <output><soap:body use="encoded" namespace="urn:ExceptionService"
        encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></output>
    </operation>

  </binding>

  <service name="ExceptionService">
    <port name="ExceptionServicePort" binding="tns:ExceptionServiceBinding">
      <soap:address location="http://' . $_SERVER['HTTP_HOST'] . '/Soap_practicals/practical07/exception_service.php"/>
    </port>
  </service>

</definitions>';
    exit;
}

// ============================================================
// Custom SoapFault Types - Different error scenarios
// ============================================================
class ExceptionService {

    private static $students = [
        1 => ['name' => 'Alice', 'age' => 20],
        2 => ['name' => 'Bob',   'age' => 22],
        3 => ['name' => 'Charlie', 'age' => 21],
    ];

    private static $accounts = [
        101 => ['name' => 'Alice', 'balance' => 5000.00],
        102 => ['name' => 'Bob',   'balance' => 3000.00],
        103 => ['name' => 'Charlie', 'balance' => 1000.00],
    ];

    // ============================================================
    // 1. Division - DivisionByZeroFault
    // ============================================================
    public function divide($a, $b) {
        if($b == 0) {
            throw new SoapFault(
                "Client",                          // Fault code
                "Division by zero is not allowed", // Fault message
                null,                              // Actor
                "Please provide a non-zero divisor" // Detail
            );
        }
        return $a / $b;
    }

    // ============================================================
    // 2. Get Student - StudentNotFoundFault
    // ============================================================
    public function getStudent($id) {
        if($id <= 0) {
            throw new SoapFault(
                "Client",
                "Invalid student ID",
                null,
                "Student ID must be a positive integer. Provided: $id"
            );
        }
        if(!isset(self::$students[$id])) {
            throw new SoapFault(
                "Client",
                "Student not found",
                null,
                "No student exists with ID: $id. Valid IDs are 1, 2, 3"
            );
        }
        $s = self::$students[$id];
        return "ID: $id | Name: {$s['name']} | Age: {$s['age']}";
    }

    // ============================================================
    // 3. Process Age - InvalidAgeFault
    // ============================================================
    public function processAge($age) {
        if($age < 0) {
            throw new SoapFault(
                "Client",
                "Invalid age - negative value",
                null,
                "Age cannot be negative. Provided: $age"
            );
        }
        if($age > 150) {
            throw new SoapFault(
                "Client",
                "Invalid age - unrealistic value",
                null,
                "Age cannot exceed 150. Provided: $age"
            );
        }
        if($age < 18) {
            return "⚠️ Minor: Age $age - Under 18, restricted access";
        }
        if($age >= 18 && $age <= 60) {
            return "✅ Adult: Age $age - Full access granted";
        }
        return "👴 Senior: Age $age - Senior discount applied";
    }

    // ============================================================
    // 4. Transfer Money - Multiple fault scenarios
    // ============================================================
    public function transferMoney($fromAccount, $toAccount, $amount) {
        // Check accounts exist
        if(!isset(self::$accounts[$fromAccount])) {
            throw new SoapFault(
                "Client",
                "Source account not found",
                null,
                "Account $fromAccount does not exist"
            );
        }
        if(!isset(self::$accounts[$toAccount])) {
            throw new SoapFault(
                "Client",
                "Destination account not found",
                null,
                "Account $toAccount does not exist"
            );
        }

        // Check amount valid
        if($amount <= 0) {
            throw new SoapFault(
                "Client",
                "Invalid transfer amount",
                null,
                "Amount must be greater than 0. Provided: $amount"
            );
        }

        // Check sufficient balance
        if(self::$accounts[$fromAccount]['balance'] < $amount) {
            throw new SoapFault(
                "Server",
                "Insufficient balance",
                null,
                "Account $fromAccount balance: $" .
                self::$accounts[$fromAccount]['balance'] .
                " | Requested: $$amount"
            );
        }

        // Process transfer
        self::$accounts[$fromAccount]['balance'] -= $amount;
        self::$accounts[$toAccount]['balance']   += $amount;

        return "✅ Transfer successful! " .
               "From: Account $fromAccount (" . self::$accounts[$fromAccount]['name'] . ") → " .
               "To: Account $toAccount (" . self::$accounts[$toAccount]['name'] . ") | " .
               "Amount: $$amount | " .
               "New Balance (From): $" . self::$accounts[$fromAccount]['balance'];
    }
}

$server = new SoapServer(
    "http://" . $_SERVER['HTTP_HOST'] . "/Soap_practicals/practical07/exception_service.php?wsdl"
);
$server->setClass('ExceptionService');
$server->handle();
?>
