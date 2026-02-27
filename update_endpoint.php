<?php
// ============================================================
// UDDI Practical - Step 7: Update Service Endpoint
// ============================================================

$conn = new mysqli("localhost", "root", "", "uddi_registry");

if($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

$service_name = "HelloWorldService";
$new_endpoint = "http://localhost:8080/soap_practicals/hello_server_v2.php";

// Old endpoint show කරනවා
$old = $conn->query(
    "SELECT endpoint FROM services WHERE service_name='$service_name'"
);
$old_row = $old->fetch_assoc();

// Update කරනවා
$stmt = $conn->prepare(
    "UPDATE services SET endpoint=? WHERE service_name=?"
);
$stmt->bind_param("ss", $new_endpoint, $service_name);
$stmt->execute();

if($stmt->affected_rows > 0) {
    echo "✅ Service Endpoint Updated!";
    echo "<br>⚙️  Service: "       . $service_name;
    echo "<br>📌 Old Endpoint: "   . $old_row['endpoint'];
    echo "<br>🔗 New Endpoint: "   . $new_endpoint;
} else {
    echo "⚠️ No changes - service not found!";
}

$conn->close();
?>
