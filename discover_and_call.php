<?php
// ============================================================
// UDDI Practical - Step 9: Invoke Service via UDDI Discovery
// Most Important File - UDDI ගා dynamically find කරලා call!
// ============================================================

$conn = new mysqli("localhost", "root", "", "uddi_registry");

if($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

echo "<h2>🔍 UDDI Dynamic Discovery + SOAP Call</h2>";
echo "<hr>";

$service_name = "HelloWorldService";

echo "<h3>Step 1: UDDI Registry ගා '$service_name' හොයනවා...</h3>";

// UDDI ගා endpoint dynamically find කරනවා
$result = $conn->query(
    "SELECT endpoint, tmodel, business_name 
     FROM services 
     WHERE service_name='$service_name'"
);
$row      = $result->fetch_assoc();
$endpoint = $row['endpoint'] ?? '';

if($endpoint) {
    echo "✅ Service found in UDDI Registry!";
    echo "<br>🏢 Business: " . $row['business_name'];
    echo "<br>🌐 Endpoint: " . $endpoint;
    echo "<br>📌 tModel: "   . $row['tmodel'];
    echo "<br><br>";

    echo "<h3>Step 2: Found endpoint use කරලා SOAP call කරනවා...</h3>";

    try {
        // Dynamically found endpoint use කරලා SoapClient හදනවා!
        $client = new SoapClient(null, [
            'location' => $endpoint,
            'uri'      => $endpoint
        ]);

        $response = $client->sayHello("Alice");
        echo "✅ SOAP Call Successful!";
        echo "<br>📢 Response: <b>" . $response . "</b>";

    } catch(SoapFault $e) {
        echo "❌ SOAP Error: " . $e->getMessage();
        echo "<br>💡 hello_server.php XAMPP ගා running ද check කරං!";
    }

} else {
    echo "❌ Service '$service_name' not found in UDDI Registry!";
    echo "<br>💡 register_service.php先 run කරං!";
}

$conn->close();
?>
