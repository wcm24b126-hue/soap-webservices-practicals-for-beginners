<?php
// ============================================================
// Practical 07 - Exception Handling Client
// ============================================================

$client = new SoapClient("http://localhost:8080/Soap_practicals/practical07/exception_service.php?wsdl");

echo "<h2>Practical 07 - Exception Handling Test Results ⚠️</h2>";
echo "<hr>";

// ============================================================
// Section 1: Division Tests
// ============================================================
echo "<h2>📐 Section 1: Division - DivisionByZero Fault</h2>";

echo "<h3>1a. divide(10, 2) - Normal ✅</h3>";
try {
    echo "Result: " . $client->divide(10, 2);
} catch(SoapFault $e) {
    echo "❌ Fault: " . $e->getMessage();
    echo "<br>Detail: " . $e->detail;
}
echo "<br><br>";

echo "<h3>1b. divide(5, 0) - Division by Zero ❌</h3>";
try {
    echo "Result: " . $client->divide(5, 0);
} catch(SoapFault $e) {
    echo "❌ Fault Code: " . $e->faultcode;
    echo "<br>❌ Fault Message: " . $e->getMessage();
    echo "<br>📋 Detail: " . $e->detail;
}
echo "<br><br>";

echo "<hr>";

// ============================================================
// Section 2: Student Tests
// ============================================================
echo "<h2>🎓 Section 2: Student - NotFound Fault</h2>";

echo "<h3>2a. getStudent(1) - Valid ID ✅</h3>";
try {
    echo $client->getStudent(1);
} catch(SoapFault $e) {
    echo "❌ Fault: " . $e->getMessage();
    echo "<br>Detail: " . $e->detail;
}
echo "<br><br>";

echo "<h3>2b. getStudent(99) - Not Found ❌</h3>";
try {
    echo $client->getStudent(99);
} catch(SoapFault $e) {
    echo "❌ Fault Code: " . $e->faultcode;
    echo "<br>❌ Fault Message: " . $e->getMessage();
    echo "<br>📋 Detail: " . $e->detail;
}
echo "<br><br>";

echo "<h3>2c. getStudent(-1) - Invalid ID ❌</h3>";
try {
    echo $client->getStudent(-1);
} catch(SoapFault $e) {
    echo "❌ Fault Code: " . $e->faultcode;
    echo "<br>❌ Fault Message: " . $e->getMessage();
    echo "<br>📋 Detail: " . $e->detail;
}
echo "<br><br>";

echo "<hr>";

// ============================================================
// Section 3: Age Validation Tests
// ============================================================
echo "<h2>👤 Section 3: Age Validation - InvalidAge Fault</h2>";

echo "<h3>3a. processAge(25) - Valid Adult ✅</h3>";
try {
    echo $client->processAge(25);
} catch(SoapFault $e) {
    echo "❌ Fault: " . $e->getMessage();
}
echo "<br><br>";

echo "<h3>3b. processAge(15) - Minor ⚠️</h3>";
try {
    echo $client->processAge(15);
} catch(SoapFault $e) {
    echo "❌ Fault: " . $e->getMessage();
}
echo "<br><br>";

echo "<h3>3c. processAge(-5) - Negative Age ❌</h3>";
try {
    echo $client->processAge(-5);
} catch(SoapFault $e) {
    echo "❌ Fault Code: " . $e->faultcode;
    echo "<br>❌ Fault Message: " . $e->getMessage();
    echo "<br>📋 Detail: " . $e->detail;
}
echo "<br><br>";

echo "<h3>3d. processAge(200) - Unrealistic Age ❌</h3>";
try {
    echo $client->processAge(200);
} catch(SoapFault $e) {
    echo "❌ Fault Code: " . $e->faultcode;
    echo "<br>❌ Fault Message: " . $e->getMessage();
    echo "<br>📋 Detail: " . $e->detail;
}
echo "<br><br>";

echo "<hr>";

// ============================================================
// Section 4: Money Transfer Tests
// ============================================================
echo "<h2>💰 Section 4: Money Transfer - Multiple Faults</h2>";

echo "<h3>4a. transferMoney(101, 102, 500) - Valid Transfer ✅</h3>";
try {
    echo $client->transferMoney(101, 102, 500.00);
} catch(SoapFault $e) {
    echo "❌ Fault: " . $e->getMessage();
    echo "<br>Detail: " . $e->detail;
}
echo "<br><br>";

echo "<h3>4b. transferMoney(103, 101, 5000) - Insufficient Balance ❌</h3>";
try {
    echo $client->transferMoney(103, 101, 5000.00);
} catch(SoapFault $e) {
    echo "❌ Fault Code: " . $e->faultcode;
    echo "<br>❌ Fault Message: " . $e->getMessage();
    echo "<br>📋 Detail: " . $e->detail;
}
echo "<br><br>";

echo "<h3>4c. transferMoney(999, 101, 100) - Invalid Account ❌</h3>";
try {
    echo $client->transferMoney(999, 101, 100.00);
} catch(SoapFault $e) {
    echo "❌ Fault Code: " . $e->faultcode;
    echo "<br>❌ Fault Message: " . $e->getMessage();
    echo "<br>📋 Detail: " . $e->detail;
}
echo "<br><br>";

echo "<h3>4d. transferMoney(101, 102, -100) - Negative Amount ❌</h3>";
try {
    echo $client->transferMoney(101, 102, -100.00);
} catch(SoapFault $e) {
    echo "❌ Fault Code: " . $e->faultcode;
    echo "<br>❌ Fault Message: " . $e->getMessage();
    echo "<br>📋 Detail: " . $e->detail;
}
echo "<br><br>";

echo "<hr>";
echo "<h3>📋 SoapFault Properties Explained:</h3>";
echo "<table border='1' cellpadding='8'>";
echo "<tr style='background:#f0f0f0'><th>Property</th><th>Description</th><th>Example</th></tr>";
echo "<tr><td><code>\$e->faultcode</code></td><td>Error category</td><td>Client / Server</td></tr>";
echo "<tr><td><code>\$e->getMessage()</code></td><td>Main error message</td><td>Division by zero</td></tr>";
echo "<tr><td><code>\$e->detail</code></td><td>Extra error details</td><td>Please provide non-zero divisor</td></tr>";
echo "</table>";
?>
