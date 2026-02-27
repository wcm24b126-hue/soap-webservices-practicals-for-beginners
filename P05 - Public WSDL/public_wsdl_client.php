<?php
// ============================================================
// Practical 05 - WSDL Understanding and Consumption
// Public SOAP Service: DNE Online Calculator
// URL: http://www.dneonline.com/calculator.asmx?WSDL
// ============================================================

echo "<h2>Practical 05 - Public WSDL SOAP Service Consumption</h2>";
echo "<hr>";

try {
    // Public WSDL URL
    $wsdlUrl = "http://www.dneonline.com/calculator.asmx?WSDL";

    // Initialize SoapClient pointing directly to the public WSDL
    $client = new SoapClient($wsdlUrl);

    echo "<h3>Test: Add(5, 10)</h3>";
    
    // Calling the Add operation with the required parameters
    $params = [
        'intA' => 5,
        'intB' => 10
    ];
    
    $response = $client->Add($params);

    // DNEOnline returns the result inside an AddResult property
    echo "<strong>Result from Public Service:</strong> " . $response->AddResult;

} catch (SoapFault $e) {
    echo "<p style='color:red'><strong>SoapFault Error:</strong> " . $e->getMessage() . "</p>";
    echo "<p>Please ensure you have an active internet connection to reach the public service.</p>";
}
?>
