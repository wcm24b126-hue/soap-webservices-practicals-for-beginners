<?php
// ============================================================
// UDDI Practical - Step 6: Search Services by Name
// ============================================================

$conn = new mysqli("localhost", "root", "", "uddi_registry");

if($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

$keyword = "Hello";

echo "<h2>🔍 UDDI Search Results - Keyword: '$keyword'</h2>";

$result = $conn->query(
    "SELECT service_name, endpoint, tmodel, business_name 
     FROM services 
     WHERE service_name LIKE '%$keyword%'"
);

if($result->num_rows > 0) {
    echo "<table border='1' cellpadding='8'>";
    echo "<tr style='background:#f0f0f0'>
            <th>#</th>
            <th>Business</th>
            <th>Service</th>
            <th>Endpoint</th>
            <th>tModel</th>
          </tr>";
    $i = 1;
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $i++ . "</td>";
        echo "<td>" . $row['business_name'] . "</td>";
        echo "<td>✅ " . $row['service_name'] . "</td>";
        echo "<td><a href='" . $row['endpoint'] . "'>" 
             . $row['endpoint'] . "</a></td>";
        echo "<td>" . $row['tmodel'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "❌ No services found with keyword: '$keyword'";
}

$conn->close();
?>
