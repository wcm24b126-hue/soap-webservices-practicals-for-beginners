# Practical 05 - WSDL Understanding and Consumption 📖

> **සිංහල Guide එකක් - දවසක් ගිහිල්ලා ආවාමත් තේරෙන විදිහට!** 🎨

---

## 🎯 Objective (අරමුණ)
**Existing public SOAP services consume කරන ඉගෙනගන්නවා** - ඔයාගේම server නැතිව internet ගා public services use කරනවා!

> **Practical 1-4 vs Practical 5 ලොකුම වෙනස:**
> - Practical 1-4 = **ඔයාම server හදනවා** (chef + kitchen)
> - Practical 5 = **කෙනෙකුගේ service use කරනවා** (restaurant delivery order කරනවා වගේ!)
>
> Real world ගා බොහෝ services already built - ඒවා consume කරන්නයි ඉගෙනගන්නේ!

---

## ✅ Tasks Completed
- ✅ Public SOAP service (DNE Calculator) හොයාගත්තා
- ✅ WSDL examine කළා - available methods, types study කළා
- ✅ PHP client ගා public service consume කළා
- ✅ Raw SOAP XML request/response examine කළා
- ✅ SOAP UI ගා test කළා

---

## 📁 File Structure
```
practical-05-wsdl-consumption/
├── public_wsdl_client.php  → Public service consume කරනවා
├── wsdl_explorer.php       → WSDL structure examine කරනවා
└── README.md               → මේ file එක
```

---

## 🌐 Public SOAP Service Used

**Service:** DNE Online Calculator
**WSDL URL:**
```
http://www.dneonline.com/calculator.asmx?WSDL
```
**Available Operations:**
| Operation | Parameters | Returns |
|-----------|-----------|---------|
| `Add` | `intA`, `intB` | `AddResult` |
| `Subtract` | `intA`, `intB` | `SubtractResult` |
| `Multiply` | `intA`, `intB` | `MultiplyResult` |
| `Divide` | `intA`, `intB` | `DivideResult` |

---

## 💡 WSDL කියන්නේ මොකක්ද? (Recap)

```
WSDL = Web Services Description Language

Restaurant menu card වගේ:
├── Available methods (dishes)
├── Parameters needed (ingredients)
├── Return types (what you get)
└── Service location (restaurant address)
```

> WSDL URL දුන්නාම SoapClient **automatically** හැම method-ම
> detect කරනවා - manually define කරන්න ඕනේ නෑ! 🔥

---

## 🛠️ Step 1: XAMPP Start කරනවා
1. XAMPP Control Panel open කරං
2. Apache → **Start** click කරං ✅

---

## 🖥️ Step 2: Files Copy කරනවා

`public_wsdl_client.php` සහ `wsdl_explorer.php` මේ folder ගා copy කරං:
```
C:\xampp\htdocs\soap_practicals\
```

---

## 📄 Step 3: Code Explain කරනවා

### Practical 1-4 vs Practical 5 Client Code වෙනස:

**Practical 1-4 (ඔයාගේ server):**
```php
// null දීලා manually location + uri දෙනවා
$client = new SoapClient(null, [
    'location' => "http://localhost:8080/.../hello_server.php",
    'uri'      => "http://localhost:8080/.../hello_server.php",
]);
```

**Practical 5 (Public WSDL):**
```php
// WSDL URL directly දෙනවා - automatically everything detect වෙනවා!
$client = new SoapClient("http://www.dneonline.com/calculator.asmx?WSDL");
```
> WSDL URL දුන්නාම `null` දෙන්න ඕනේ නෑ + location/uri manually set කරන්න ඕනේ නෑ! ✨

### Method Call කරන හැටි (Public Service):
```php
// Named parameters (array) විදිහට pass කරනවා
$result = $client->Add(['intA' => 5, 'intB' => 10]);
echo $result->AddResult;  // 15
```

### Available Methods List කරනවා:
```php
$methods = $client->__getFunctions();
foreach($methods as $method) {
    echo $method;
}
```

### Raw XML examine කරනවා:
```php
$client = new SoapClient($url, ['trace' => true]); // trace ON
$result = $client->Add(['intA' => 3, 'intB' => 7]);

// Actual XML request/response බලනවා
echo $client->__getLastRequest();   // Client → Server XML
echo $client->__getLastResponse();  // Server → Client XML
```

---

## 🌐 Step 4: Browser ගා Test කරනවා

### Public Service Test:
```
http://localhost:8080/soap_practicals/public_wsdl_client.php
```
**Expected Output:**
```
✅ Connected to public SOAP service successfully!

1. Add(5, 10)      → Result: 15
2. Subtract(20, 8) → Result: 12
3. Multiply(6, 7)  → Result: 42
4. Divide(100, 4)  → Result: 25
```

### WSDL Explorer:
```
http://localhost:8080/soap_practicals/wsdl_explorer.php
```
**Expected Output:**
```
📋 Available Operations:
1. AddResponse Add(Add $parameters)
2. SubtractResponse Subtract(Subtract $parameters)
3. MultiplyResponse Multiply(Multiply $parameters)
4. DivideResponse Divide(Divide $parameters)

📡 Raw XML also shown!
```

---

## 🧪 Step 5: SOAP UI ගා Test කරනවා

### 5.1 - New Project හදනවා
1. SOAP UI → **SOAP** button click කරං
2. Fill කරං:
   - **Project Name:** `Public WSDL Project`
   - **Initial WSDL:** `http://www.dneonline.com/calculator.asmx?WSDL`
3. **OK** click කරං ✅

> ⚠️ Internet connection ඕනේ! Public service reach වෙනවාද check කරං.

### 5.2 - Add Test කරනවා
```
DNE Calculator Binding → Add → Request 1
```
XML ගා fill කරං:
```xml
<intA>5</intA>
<intB>10</intB>
```
**▶ Click** → Response:
```xml
<AddResult>15</AddResult>
```

### 5.3 - Subtract Test:
```xml
<intA>20</intA>
<intB>8</intB>
```
Response: `<SubtractResult>12</SubtractResult>`

### 5.4 - Multiply Test:
```xml
<intA>6</intA>
<intB>7</intB>
```
Response: `<MultiplyResult>42</MultiplyResult>`

---

## 🔄 How It All Works

```
ඔයාගේ PHP client
        ↓
WSDL URL request කරනවා (menu card ඉල්ලනවා)
        ↓
Public server WSDL return කරනවා
        ↓
SoapClient automatically methods detect කරනවා
        ↓
Add(5, 10) call කරනවා
        ↓
Public server calculate කරනවා
        ↓
Result (15) return වෙනවා ✅
```

---

## 💡 Practical 1-5 Full Picture

| Practical | Role | Concept |
|-----------|------|---------|
| P01 | Server + Client | Basic SOAP setup |
| P02 | Server + Client | Multiple parameters |
| P03 | Server + Client | SoapFault handling |
| P04 | Server + Client | Object-based params |
| P05 | **Client only** | **Consume public WSDL** |

> **P05 ගා key insight:**
> Real world ගා payment gateways (PayPal), weather APIs, SMS services
> සියල්ලම WSDL-based SOAP services! WSDL URL දීලා consume කරනවා! 🌍

---

## ⚠️ Important Notes

| Issue | Solution |
|-------|----------|
| Public service reach නොවෙනවා | Internet connection check කරං |
| WSDL load error | Service temporarily down - later try කරං |
| SoapUI Error: "The markup... must be well formed" | **Problem:** SoapUI එකට ඔයාගේ PHP client file එක (`public_wsdl_client.php`) දෙන්න එපා. ඒක XML එකක් නෙවෙයි (HTML තියෙනවා). <br> **Fix:** SoapUI එකට දෙන්න ඕනේ **Public WSDL URL** එක විතරයි (`http://www.dneonline.com/calculator.asmx?WSDL`). |

---

## 🚨 Troubleshooting - Why SoapUI Fails?

ඔයා SoapUI එකට ඔයාගේ **`public_wsdl_client.php`** URL එක දුන්නොත්, මෙන්න මේ වගේ error එකක් එනවා:
`"Error loading WSDL: The markup in the document following the root element must be well formed."`

### **ඇයි මෙහෙම වෙන්නේ?**
*   **SoapUI** එකට ඕනේ **WSDL (XML)** එකක්.
*   ඔයාගේ **`public_wsdl_client.php`** කියන්නේ **Client** එකක්. ඒකේ `<h2>`, `<hr>` වගේ HTML tags තියෙනවා. SoapUI එකට HTML කියවන්න බැරි නිසා error එක එනවා.

### **හරියටම කරන විදිහ (The Fix):**

1.  **SoapUI එකේදී:** පාවිච්චි කරන්න ඕනේ **Public WSDL URL** එක විතරයි:
    👉 `http://www.dneonline.com/calculator.asmx?WSDL`
    *(මතක තියාගන්න: මෙතනදී Server එක තියෙන්නේ Internet එකේ. ඒ නිසා localhost පාවිච්චි කරන්නේ නෑ).*

2.  **Browser එකේදී:** පාවිච්චි කරන්න ඔයාගේ **Local PHP Client** එක:
    👉 `http://localhost:8080/soap_practicals/P05 - Public WSDL/public_wsdl_client.php`
    *(මෙතනදී ඔයා ලියපු PHP code එක run වෙලා internet එකේ තියෙන service එකට කතා කරනවා).*

---

*Self Study Practical 05 - SOAP Web Services using PHP & XAMPP* 🧼


