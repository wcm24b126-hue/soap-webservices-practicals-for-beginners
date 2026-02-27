# Practical 03 - Calculator SOAP Service 🧮



---

## 🎯 Objective (අරමුණ)
Numeric data handle කරන SOAP methods ඉගෙනගන්නවා + **SoapFault** (error handling) ඉගෙනගන්නවා!

> **Practical 2 vs Practical 3 වෙනස:**
> - Practical 2 = String + Integer parameters, CRUD operations
> - Practical 3 = Numeric operations (add/subtract/multiply/divide) + **Exception Handling!**
>
> **New concept - SoapFault:**
> Zero ගා divide කරන්න ගත්තාම server crash නොවී gracefully error return කරනවා!
> Artist කෙනෙක් impossible order reject කරනවා වගේ 🎨

---

## ✅ Tasks Completed
- ✅ `add(a, b)` method හැදුවා
- ✅ `subtract(a, b)` method හැදුවා
- ✅ `multiply(a, b)` method හැදුවා
- ✅ `divide(a, b)` method හැදුවා + zero division handle කළා
- ✅ SOAP UI ගා සියලු methods test කළා
- ✅ Client program හැදුවා

---

## 📁 File Structure
```
practical-03-calculator/
├── calculator_service.php  → SOAP Server (Calculator logic)
├── calculator_client.php   → SOAP Client (Methods test කරනවා)
└── README.md               → මේ file එක
```

---

## 📋 Available Methods

| Method | Parameters | Returns | Special |
|--------|-----------|---------|---------|
| `add` | `a` (int), `b` (int) | int | - |
| `subtract` | `a` (int), `b` (int) | int | - |
| `multiply` | `a` (int), `b` (int) | int | - |
| `divide` | `a` (int), `b` (int) | float | ⚠️ b=0 නම් SoapFault! |

---

## 🛠️ Step 1: XAMPP Start කරනවා
1. XAMPP Control Panel open කරං
2. Apache → **Start** click කරං ✅

---

## 🖥️ Step 2: Server File Copy කරනවා

`calculator_service.php` මේ folder ගා copy කරං:
```
C:\xampp\htdocs\soap_practicals\
```

### Code Explain කරනවා:

**Simple operations:**
```php
public function add($a, $b)      { return $a + $b; }
public function subtract($a, $b) { return $a - $b; }
public function multiply($a, $b) { return $a * $b; }
```

**Division with SoapFault (Key concept!):**
```php
public function divide($a, $b) {
    if($b == 0) {
        throw new SoapFault("Server", "Cannot divide by zero!");
    }
    return $a / $b;
}
```
> `b == 0` නම් `SoapFault` throw කරනවා = server crash නොවී error message return කරනවා!

---

## 📱 Step 3: Client File Copy කරනවා

`calculator_client.php` same folder ගා copy කරං.

### Key Part - SoapFault Catch කරනවා:
```php
try {
    echo $client->divide(5, 0);
} catch (SoapFault $e) {
    echo "⚠️ SoapFault caught! Error: " . $e->getMessage();
}
```
> `try-catch` use කරලා SoapFault gracefully handle කරනවා!

---

## 🌐 Step 4: Browser ගා Test කරනවා

Browser ගා:
```
http://localhost:8080/soap_practicals/calculator_client.php
```

**Expected Output:**
```
1. add(10, 5)
Result: 15

2. subtract(10, 5)
Result: 5

3. multiply(10, 5)
Result: 50

4. divide(10, 2)
Result: 5

5. divide(7, 2)
Result: 3.5

6. divide(5, 0) - Division by Zero Test
⚠️ SoapFault caught! Error: Cannot divide by zero!
```

---

## 🧪 Step 5: SOAP UI ගා Test කරනවා

### 5.1 - New Project හදනවා
1. SOAP UI → **SOAP** button click කරං
2. Fill කරං:
   - **Project Name:** `Calculator Project`
   - **Initial WSDL:** `http://localhost:8080/soap_practicals/calculator_service.php?wsdl`
3. **OK** click කරං ✅

### 5.2 - add Test කරනවා
```
CalculatorServiceBinding → add → Request 1
```
XML ගා fill කරං:
```xml
<a xsi:type="xsd:int">10</a>
<b xsi:type="xsd:int">5</b>
```
**▶ Click** → Response:
```xml
<return xsi:type="xsd:int">15</return>
```

### 5.3 - subtract Test කරනවා
```xml
<a xsi:type="xsd:int">10</a>
<b xsi:type="xsd:int">5</b>
```
**▶ Click** → Response:
```xml
<return xsi:type="xsd:int">5</return>
```

### 5.4 - multiply Test කරනවා
```xml
<a xsi:type="xsd:int">10</a>
<b xsi:type="xsd:int">5</b>
```
**▶ Click** → Response:
```xml
<return xsi:type="xsd:int">50</return>
```

### 5.5 - divide Normal Test කරනවා
```xml
<a xsi:type="xsd:int">10</a>
<b xsi:type="xsd:int">2</b>
```
**▶ Click** → Response:
```xml
<return xsi:type="xsd:float">5</return>
```

### 5.6 - divide by Zero Test (SoapFault!) ⚠️
```xml
<a xsi:type="xsd:int">5</a>
<b xsi:type="xsd:int">0</b>
```
**▶ Click** → Response (SoapFault!):
```xml
<faultcode>Server</faultcode>
<faultstring>Cannot divide by zero!</faultstring>
```
> ✅ Server crash නොවී gracefully error return කළා!

---

## 🔄 How It All Works

```
SOAP UI / Client ගා request යවනවා
            ↓
calculator_service.php handle() catch කරනවා
            ↓
CalculatorService class ගා method run වෙනවා
            ↓
Normal request   → Result return වෙනවා ✅
Zero division    → SoapFault throw වෙනවා ⚠️
            ↓
Client ගා try-catch ගා SoapFault catch කරනවා
```

---

## 💡 SoapFault vs Normal Exception

| Type | Use Case | Client Handle කරන හැටි |
|------|----------|------------------------|
| `SoapFault` | SOAP service errors | `catch (SoapFault $e)` |
| `Exception` | Normal PHP errors | `catch (Exception $e)` |

> SOAP world ගා errors = **SoapFault** - ඒකෙ reason SOAP protocol ගා errors XML format ගා communicate වෙනවා!

---

## ⚠️ Important Notes

| Issue | Solution |
|-------|----------|
| WSDL load නොවෙනවා | XAMPP Apache running ද check කරං |
| divide by zero crash | try-catch use කරං client side ගා |
| Decimal result | divide() float return කරනවා - normal! |

---

*Self Study Practical 03 - SOAP Web Services using PHP & XAMPP* 🧼
