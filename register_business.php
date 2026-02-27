<?php
// ============================================================
// UDDI Practical - Step 2: Register a Business Entity
// ============================================================

$conn = new mysqli("localhost", "root", "", "uddi_registry");

if($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

$business_name = "XamppTestBusiness";

// Check already registered ද?
$check = $conn->query(
    "SELECT id FROM services WHERE business_name='$business_name' 
     AND service_name IS NULL"
);

if($check->num_rows > 0) {
    echo "⚠️ Business '$business_name' already registered!";
} else {
    $stmt = $conn->prepare(
        "INSERT INTO services (business_name) VALUES (?)"
    );
    $stmt->bind_param("s", $business_name);
    $stmt->execute();
    echo "✅ Business Registered Successfully!";
    echo "<br>📋 Business Name: " . $business_name;
    echo "<br>🔑 ID: " . $stmt->insert_id;
}

$conn->close();
?>
