<?php
// ============================================================
// Practical 06 - SOAP Security Client
// ============================================================

$client = new SoapClient("http://localhost:8080/Soap_practicals/practical06/secure_service.php?wsdl");

echo "<h2>Practical 06 - SOAP Security Test Results 🔐</h2>";
echo "<hr>";

// ============================================================
// Test 1: Public method - no credentials needed
// ============================================================
echo "<h3>1. getPublicMessage() - No Auth Needed</h3>";
try {
    echo $client->getPublicMessage();
} catch (SoapFault $e) {
    echo "❌ Error: " . $e->getMessage();
}
echo "<br><br>";

// ============================================================
// Test 2: Secret message with CORRECT credentials
// ============================================================
echo "<h3>2. getSecretMessage() - Correct Credentials ✅</h3>";
echo "<em>Username: admin | Password: password123</em><br>";
try {
    echo $client->getSecretMessage("admin", "password123");
} catch (SoapFault $e) {
    echo "❌ Error: " . $e->getMessage();
}
echo "<br><br>";

// ============================================================
// Test 3: Secret message with WRONG password
// ============================================================
echo "<h3>3. getSecretMessage() - Wrong Password ❌</h3>";
echo "<em>Username: admin | Password: wrongpass</em><br>";
try {
    echo $client->getSecretMessage("admin", "wrongpass");
} catch (SoapFault $e) {
    echo $e->getMessage();
}
echo "<br><br>";

// ============================================================
// Test 4: Secret message with WRONG username
// ============================================================
echo "<h3>4. getSecretMessage() - Wrong Username ❌</h3>";
echo "<em>Username: hacker | Password: password123</em><br>";
try {
    echo $client->getSecretMessage("hacker", "password123");
} catch (SoapFault $e) {
    echo $e->getMessage();
}
echo "<br><br>";

// ============================================================
// Test 5: Get user info with correct credentials
// ============================================================
echo "<h3>5. getUserInfo() - Correct Credentials ✅</h3>";
echo "<em>Username: admin | Password: password123</em><br>";
try {
    echo $client->getUserInfo("admin", "password123");
} catch (SoapFault $e) {
    echo "❌ Error: " . $e->getMessage();
}
echo "<br><br>";

// ============================================================
// Test 6: Get user info with empty credentials
// ============================================================
echo "<h3>6. getUserInfo() - Empty Credentials ❌</h3>";
echo "<em>Username: (empty) | Password: (empty)</em><br>";
try {
    echo $client->getUserInfo("", "");
} catch (SoapFault $e) {
    echo $e->getMessage();
}
echo "<br><br>";

echo "<hr>";
echo "<h3>📋 Summary</h3>";
echo "<table border='1' cellpadding='8'>";
echo "<tr style='background:#f0f0f0'><th>Test</th><th>Credentials</th><th>Expected Result</th></tr>";
echo "<tr><td>Public message</td><td>None needed</td><td>✅ Always works</td></tr>";
echo "<tr><td>Secret message</td><td>admin/password123</td><td>✅ Access granted</td></tr>";
echo "<tr><td>Secret message</td><td>admin/wrongpass</td><td>❌ Unauthorized</td></tr>";
echo "<tr><td>Secret message</td><td>hacker/password123</td><td>❌ Unauthorized</td></tr>";
echo "</table>";
?>
