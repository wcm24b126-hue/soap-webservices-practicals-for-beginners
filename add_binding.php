<?php
// ============================================================
// UDDI Practical - Step 4: Add Binding Template
// ============================================================

$conn = new mysqli("localhost", "root", "", "uddi_registry");

if($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

$service_id   = 1;
$new_endpoint = "http://localhost:8080/soap_practicals/P01%20-%20Hello%20World/hello_server.php";

$stmt = $conn->prepare(
    "UPDATE services SET endpoint=? WHERE id=?"
);
$stmt->bind_param("si", $new_endpoint, $service_id);
$stmt->execute();

if($stmt->affected_rows > 0) {
    echo "✅ Binding Template Updated!";
    echo "<br>🔗 New Endpoint: " . $new_endpoint;
    echo "<br>🔑 Service ID: "   . $service_id;
} else {
    echo "⚠️ No changes made - check service ID!";
}

echo "<br><br>";
echo "<h3>📖 bindingTemplate vs businessService:</h3>";
echo "<table border='1' cellpadding='8'>";
echo "<tr style='background:#f0f0f0'>
        <th>Concept</th>
        <th>Description</th>
        <th>Example</th>
      </tr>";
echo "<tr>
        <td><b>businessService</b></td>
        <td>Service description (what it does)</td>
        <td>HelloWorldService</td>
      </tr>";
echo "<tr>
        <td><b>bindingTemplate</b></td>
        <td>Technical access point (how to reach it)</td>
        <td>http://localhost:8080/.../hello_server.php</td>
      </tr>";
echo "</table>";

$conn->close();
?>
