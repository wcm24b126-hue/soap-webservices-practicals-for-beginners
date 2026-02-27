<?php
// ============================================================
// UDDI Practical - Step 3: Register a Web Service
// ============================================================

$conn = new mysqli("localhost", "root", "", "uddi_registry");

if($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

$business_name = "XamppTestBusiness";
$service_name  = "HelloWorldService";
$endpoint      = "http://localhost:8080/soap_practicals/P01%20-%20Hello%20World/hello_server.php";
$tmodel        = "HelloWorldSOAP";

// Check already registered ද?
$check = $conn->query(
    "SELECT id FROM services WHERE service_name='$service_name'"
);

if($check->num_rows > 0) {
    echo "⚠️ Service '$service_name' already registered!";
} else {
    $stmt = $conn->prepare(
        "INSERT INTO services (business_name, service_name, endpoint, tmodel)
         VALUES (?, ?, ?, ?)"
    );
    $stmt->bind_param("ssss", $business_name, $service_name, $endpoint, $tmodel);
    $stmt->execute();
    echo "✅ Service Registered Successfully!";
    echo "<br>🏢 Business: " . $business_name;
    echo "<br>⚙️ Service: "  . $service_name;
    echo "<br>🌐 Endpoint: " . $endpoint;
    echo "<br>📌 tModel: "   . $tmodel;
    echo "<br>🔑 ID: "       . $stmt->insert_id;
}

$conn->close();
?>
