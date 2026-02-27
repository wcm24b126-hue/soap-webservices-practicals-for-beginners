<?php
// ============================================================
// UDDI Practical - Step 8: Delete a Service
// ============================================================

$conn = new mysqli("localhost", "root", "", "uddi_registry");

if($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

$service_name = "HelloWorldService";

// Delete කරන්න කලින් confirm
$check = $conn->query(
    "SELECT * FROM services WHERE service_name='$service_name'"
);

if($check->num_rows == 0) {
    echo "⚠️ Service '$service_name' not found!";
} else {
    $row = $check->fetch_assoc();
    echo "📋 Deleting: " . $row['service_name'];
    echo "<br>🌐 Endpoint: " . $row['endpoint'];
    echo "<br><br>";

    $stmt = $conn->prepare(
        "DELETE FROM services WHERE service_name=?"
    );
    $stmt->bind_param("s", $service_name);
    $stmt->execute();

    echo "✅ Service '$service_name' Deleted Successfully!";
    echo "<br>❌ Service is no longer in UDDI Registry!";
}

$conn->close();
?>
