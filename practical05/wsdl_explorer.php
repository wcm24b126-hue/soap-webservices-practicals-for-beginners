<?php
// ============================================================
// WSDL Explorer - WSDL එකක structure examine කරනවා
// ============================================================

echo "<h2>WSDL Explorer 🔍</h2>";
echo "<p>WSDL file එකක් examine කරලා available operations, messages, types show කරනවා</p>";
echo "<hr>";

// Explore කරන WSDL URL
$wsdlUrl = "http://www.dneonline.com/calculator.asmx?WSDL";

echo "<h3>🌐 WSDL URL:</h3>";
echo "<code>$wsdlUrl</code>";
echo "<hr>";

try {
    $client = new SoapClient($wsdlUrl, ['trace' => true]);

    // ============================================================
    // 1. Available Functions/Operations
    // ============================================================
    echo "<h3>📋 1. Available Operations (Methods):</h3>";
    echo "<p><em>WSDL ගා define කරලා තියෙන සියලු methods</em></p>";
    $functions = $client->__getFunctions();
    echo "<table border='1' cellpadding='8' cellspacing='0'>";
    echo "<tr style='background:#f0f0f0'><th>#</th><th>Operation Signature</th></tr>";
    foreach($functions as $i => $func) {
        echo "<tr>";
        echo "<td>" . ($i + 1) . "</td>";
        echo "<td><code>" . htmlspecialchars($func) . "</code></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<br>";

    // ============================================================
    // 2. Available Types
    // ============================================================
    echo "<h3>📦 2. Available Types:</h3>";
    echo "<p><em>WSDL ගා define කරලා තියෙන data types</em></p>";
    $types = $client->__getTypes();
    echo "<table border='1' cellpadding='8' cellspacing='0'>";
    echo "<tr style='background:#f0f0f0'><th>#</th><th>Type Definition</th></tr>";
    foreach($types as $i => $type) {
        echo "<tr>";
        echo "<td>" . ($i + 1) . "</td>";
        echo "<td><code>" . htmlspecialchars($type) . "</code></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<br>";

    // ============================================================
    // 3. Make a test call and show raw XML
    // ============================================================
    echo "<h3>📡 3. Raw SOAP Request/Response XML:</h3>";
    echo "<p><em>Behind the scenes - actual XML exchange</em></p>";

    $result = $client->Add(['intA' => 3, 'intB' => 7]);

    echo "<h4>Request XML (Client → Server):</h4>";
    echo "<pre style='background:#f8f8f8; padding:10px; border:1px solid #ccc; overflow:auto'>";
    echo htmlspecialchars($client->__getLastRequest());
    echo "</pre>";

    echo "<h4>Response XML (Server → Client):</h4>";
    echo "<pre style='background:#f8f8f8; padding:10px; border:1px solid #ccc; overflow:auto'>";
    echo htmlspecialchars($client->__getLastResponse());
    echo "</pre>";

    echo "<h4>Result: 3 + 7 = <strong>" . $result->AddResult . "</strong></h4>";

} catch (SoapFault $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p>💡 Public service reach නොවෙනවා නම් internet connection check කරං!</p>";
}
?>
