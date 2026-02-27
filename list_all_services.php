<?php
// ============================================================
// UDDI Practical - Step 10: List All Services of a Business
// ============================================================

$conn = new mysqli("localhost", "root", "", "uddi_registry");

if($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

$business_name = "XamppTestBusiness";

echo "<h2>📋 All Services - $business_name</h2>";
echo "<hr>";

$result = $conn->query(
    "SELECT service_name, endpoint, tmodel 
     FROM services 
     WHERE business_name='$business_name'
     AND service_name IS NOT NULL"
);

if($result->num_rows > 0) {
    echo "<table border='1' cellpadding='8' cellspacing='0'>";
    echo "<tr style='background:#4CAF50; color:white'>
            <th>#</th>
            <th>Service Name</th>
            <th>Endpoint URL</th>
            <th>tModel</th>
          </tr>";
    $i = 1;
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $i++ . "</td>";
        echo "<td>✅ " . $row['service_name'] . "</td>";
        echo "<td><a href='" . $row['endpoint'] . "' target='_blank'>" 
             . $row['endpoint'] . "</a></td>";
        echo "<td>📌 " . $row['tmodel'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<br>";
    echo "✅ Total Services: " . ($i-1);
} else {
    echo "❌ No services found for '$business_name'";
    echo "<br>💡 register_service.php run කරං first!";
}

$conn->close();
?>
