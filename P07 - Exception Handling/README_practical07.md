# Practical 07 - Exception Handling in SOAP ⚠️

> **සිංහල Guide එකක් - දවසක් ගිහිල්ලා ආවාමත් තේරෙන විදිහට!** 🎨

---

## 🎯 Objective (අරමුණ)
SOAP services ගා **errors gracefully handle** කරන ඉගෙනගන්නවා - different fault scenarios handle කරනවා!

> **Practical 3 vs Practical 7 වෙනස:**
> - Practical 3 = Basic SoapFault (divide by zero එකයි)
> - Practical 7 = **Advanced Exception Handling** - multiple scenarios,
>   fault codes, fault details, real world examples!
>
> **New Concept:**
> SOAP world ගා errors = **SoapFault** - ඒකේ properties 3ක් තියෙනවා:
> - `faultcode` = Error category (Client/Server)
> - `getMessage()` = Main error message
> - `detail` = Extra details about the error

---

## ✅ Tasks Completed
- ✅ `divide()` - DivisionByZero fault
- ✅ `getStudent()` - NotFound + InvalidID fault
- ✅ `processAge()` - InvalidAge fault (negative + unrealistic)
- ✅ `transferMoney()` - Multiple faults (invalid account, insufficient balance, negative amount)
- ✅ SOAP UI ගා test කළා
- ✅ Client program හැදුවා

---

## 📁 File Structure
```
practical-07-exception-handling/
├── exception_service.php  → SOAP Server with multiple fault scenarios
├── exception_client.php   → SOAP Client with comprehensive tests
└── README.md              → මේ file එක
```

---

## 📋 Available Methods & Their Faults

| Method | Parameters | Possible Faults |
|--------|-----------|----------------|
| `divide(a, b)` | int, int | b=0 → DivisionByZero |
| `getStudent(id)` | int | id≤0 → InvalidID, id not found → NotFound |
| `processAge(age)` | int | age<0 → Negative, age>150 → Unrealistic |
| `transferMoney(from, to, amount)` | int, int, float | Invalid account, Insufficient balance, Negative amount |

---

## 🛠️ Step 1: XAMPP Start කරනවා
1. XAMPP Control Panel open කරං
2. Apache → **Start** click කරං ✅

---

## 🖥️ Step 2: Files Copy කරනවා

`exception_service.php` + `exception_client.php` මේ folder ගා copy කරං:
```
C:\xampp\htdocs\Soap_practicals\P07 - Exception Handling\
```

### Code Explain කරනවා:

**SoapFault Full Structure:**
```php
throw new SoapFault(
    "Client",                           // faultcode
    "Division by zero is not allowed",  // faultstring (getMessage())
    null,                               // faultactor
    "Please provide a non-zero divisor" // detail
);
```

**Client Side Catch:**
```php
try {
    echo $client->divide(5, 0);
} catch(SoapFault $e) {
    echo $e->faultcode;      // "Client"
    echo $e->getMessage();   // "Division by zero is not allowed"
    echo $e->detail;         // "Please provide a non-zero divisor"
}
```

**Multiple Validations (transferMoney):**
```php
public function transferMoney($from, $to, $amount) {
    // Check 1: Account exists?
    if(!isset(self::$accounts[$from])) {
        throw new SoapFault("Client", "Source account not found", null, "Account $from does not exist");
    }
    // Check 2: Amount valid?
    if($amount <= 0) {
        throw new SoapFault("Client", "Invalid amount", null, "Amount must be > 0");
    }
    // Check 3: Sufficient balance?
    if(self::$accounts[$from]['balance'] < $amount) {
        throw new SoapFault("Server", "Insufficient balance", null, "Balance: $balance | Requested: $amount");
    }
    // All checks passed - process transfer!
}
```

---

## 🌐 Step 3: Browser ගා Test කරනවා

```
http://localhost:8080/Soap_practicals/P07 - Exception Handling/exception_client.php
```

**Expected Output:**
```
Section 1: Division
1a. divide(10, 2)  → Result: 5 ✅
1b. divide(5, 0)   → ❌ Fault: Division by zero is not allowed

Section 2: Student
2a. getStudent(1)  → ID: 1 | Name: Alice | Age: 20 ✅
2b. getStudent(99) → ❌ Fault: Student not found
2c. getStudent(-1) → ❌ Fault: Invalid student ID

Section 3: Age
3a. processAge(25)  → ✅ Adult: Age 25 - Full access granted
3b. processAge(15)  → ⚠️ Minor: Age 15 - Under 18
3c. processAge(-5)  → ❌ Fault: Invalid age - negative value
3d. processAge(200) → ❌ Fault: Invalid age - unrealistic value

Section 4: Money Transfer
4a. transfer(101→102, $500)  → ✅ Transfer successful!
4b. transfer(103→101, $5000) → ❌ Fault: Insufficient balance
4c. transfer(999→101, $100)  → ❌ Fault: Source account not found
4d. transfer(101→102, -$100) → ❌ Fault: Invalid transfer amount
```

---

## 🧪 Step 4: SOAP UI ගා Test කරනවා

### New Project:
- **Project Name:** `Exception Project`
- **WSDL:** `http://localhost:8080/Soap_practicals/P07 - Exception Handling/exception_service.php?wsdl`

### divide - Zero Test:
```xml
<a xsi:type="xsd:int">5</a>
<b xsi:type="xsd:int">0</b>
```
Response (SoapFault):
```xml
<faultcode>Client</faultcode>
<faultstring>Division by zero is not allowed</faultstring>
<detail>Please provide a non-zero divisor</detail>
```

### getStudent - Not Found:
```xml
<id xsi:type="xsd:int">99</id>
```
Response:
```xml
<faultcode>Client</faultcode>
<faultstring>Student not found</faultstring>
<detail>No student exists with ID: 99. Valid IDs are 1, 2, 3</detail>
```

### transferMoney - Insufficient Balance:
```xml
<fromAccount xsi:type="xsd:int">103</fromAccount>
<toAccount xsi:type="xsd:int">101</toAccount>
<amount xsi:type="xsd:float">5000</amount>
```
Response:
```xml
<faultcode>Server</faultcode>
<faultstring>Insufficient balance</faultstring>
<detail>Account 103 balance: $1000 | Requested: $5000</detail>
```

---

## 💡 Client vs Server Fault Codes

```
"Client" Fault = Client ගා problem
    ├── Wrong ID sent
    ├── Invalid parameters
    ├── Negative values
    └── Non-existent records

"Server" Fault = Server ගා problem
    ├── Insufficient balance (data issue)
    ├── Database connection failed
    └── Internal processing error
```

---

## 🔄 Exception Handling Flow

```
Client request යවනවා
        ↓
Server validation check කරනවා
        ↓
Valid   → Normal response return කරනවා ✅
Invalid → SoapFault throw කරනවා ❌
        ↓
Client try-catch ගා:
├── $e->faultcode    → "Client" or "Server"
├── $e->getMessage() → Main error message
└── $e->detail       → Extra details
```

---

## 💡 All Practicals - Complete Summary

| Practical | Concept | Key Learning |
|-----------|---------|-------------|
| P01 | Basic SOAP | Server + Client setup |
| P02 | Multiple Params | CRUD operations |
| P03 | Basic SoapFault | Divide by zero |
| P04 | Objects | Object-based params |
| P05 | Public WSDL | Consume external services |
| P06 | Security | Authentication |
| P07 | **Advanced Exceptions** | **Multiple fault scenarios** |

---

## ⚠️ Important Notes

| Issue | Solution |
|-------|----------|
| WSDL load නොවෙනවා | XAMPP Apache running ද check කරං |
| detail property empty | SoapFault 4th parameter check කරං |
| Fault code confusion | Client=input error, Server=processing error |

---

*Self Study Practical 07 - SOAP Web Services using PHP & XAMPP* 🧼

