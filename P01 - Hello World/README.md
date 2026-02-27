# Practical 01 - Hello World SOAP Web Service 👋

> **සිංහල Guide එකක් - දවසක් ගිහිල්ලා ආවාමත් තේරෙන විදිහට ලියලා තියෙනවා!** 🎨

---

## 🎯 Objective (අරමුණ)
SOAP service එකක් හදන්න සහ ඒකට connect වෙන client එකක් හදන්න ඉගෙනගන්නවා.

> **SOAP කියන්නේ මොකක්ද?**
> Internet ගා services දෙකක් communicate කරන ක්‍රමයක් - restaurant order system වගේ!
> - **Server** = Kitchen (ඇණවුම් හදනවා)
> - **Client** = Customer (ඇණවුම් දෙනවා)
> - **WSDL** = Menu Card (මොනවා order කරන්න පුලුවන්ද කියලා describe කරනවා)

---

## ✅ Tasks Completed
- ✅ `sayHello(name)` method එකක් සහිත SOAP service එකක් හැදුවා
- ✅ XAMPP use කරලා locally publish කළා
- ✅ SOAP UI ගා test කළා
- ✅ Client application එකක් හැදුවා

---

## 📁 File Structure
```
practical-01-hello-world/
├── hello_server.php   → SOAP Server + WSDL Generator (Kitchen)
├── hello_client.php   → SOAP Client (Customer)
└── README.md          → මේ file එක
```

---

## 🛠️ Step 1: XAMPP Start කරනවා

1. **XAMPP Control Panel** open කරං
2. **Apache** → Start click කරං
3. Apache **green** වෙනවා = server ON ✅

> ⚠️ Port 80 busy නම් Apache **port 8080** ගා run වෙනවා - ඒ OK!

---

## 🖥️ Step 2: SOAP Server හදනවා (hello_server.php)

`C:\xampp\htdocs\soap_practicals\` folder ගා `hello_server.php` හදං.

### කොටස් 2ක් තියෙනවා:

**කොටස 1 - WSDL Generator (Menu Card)**
> `?wsdl` URL ගා request කළාම - "මේ service ගා `sayHello` method එකක් තියෙනවා" කියලා SOAP UI එකට describe කරනවා

**කොටස 2 - Actual Service (Real Work)**
> `sayHello("Alice")` call කළාම → `"Hello, Alice!"` return කරනවා

### 📄 Full Code:
```php
<?php
ini_set("soap.wsdl_cache_enabled", "0");

// WSDL Generator කොටස - Menu Card දෙනවා
if(isset($_GET['wsdl'])){
    header('Content-Type: text/xml; charset=utf-8');
    echo '<?xml version="1.0" encoding="UTF-8"?>
<definitions name="HelloService"
targetNamespace="urn:HelloService"
xmlns:tns="urn:HelloService"
xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"
xmlns:xsd="http://www.w3.org/2001/XMLSchema"
xmlns="http://schemas.xmlsoap.org/wsdl/">
<message name="sayHelloRequest">
    <part name="name" type="xsd:string"/>
</message>
<message name="sayHelloResponse">
    <part name="return" type="xsd:string"/>
</message>
<portType name="HelloServicePortType">
    <operation name="sayHello">
        <input message="tns:sayHelloRequest"/>
        <output message="tns:sayHelloResponse"/>
    </operation>
</portType>
<binding name="HelloServiceBinding" type="tns:HelloServicePortType">
    <soap:binding style="rpc" transport="http://schemas.xmlsoap.org/soap/http"/>
    <operation name="sayHello">
        <soap:operation soapAction="sayHello"/>
        <input><soap:body use="encoded" namespace="urn:HelloService"
            encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></input>
        <output><soap:body use="encoded" namespace="urn:HelloService"
            encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/></output>
    </operation>
</binding>
<service name="HelloService">
    <port name="HelloServicePort" binding="tns:HelloServiceBinding">
        <soap:address location="http://localhost:8080/soap_practicals/hello_server.php"/>
    </port>
</service>
</definitions>';
    exit;
}

// Actual Service කොටස - Real Work කරනවා
class HelloService {
    public function sayHello($name) {
        return "Hello, " . $name . "!";
    }
}

$server = new SoapServer(
    "http://localhost:8080/soap_practicals/hello_server.php?wsdl"
);
$server->setClass('HelloService');
$server->handle();
?>
```

---

## 📱 Step 3: SOAP Client හදනවා (hello_client.php)

Same folder ගා `hello_client.php` හදං.

> Client එක = Customer. Server එකට connect වෙලා `sayHello("Alice")` order දෙනවා!

```php
<?php
$client = new SoapClient(null, [
    'location' => "http://localhost:8080/soap_practicals/hello_server.php",
    'uri'      => "http://localhost:8080/soap_practicals/hello_server.php",
]);

$response = $client->sayHello("Alice");
echo $response;
?>
```

---

## 🌐 Step 4: Browser ගා Test කරනවා

Browser ගා මේ URL type කරං:
```
http://localhost:8080/soap_practicals/hello_client.php
```

**Expected Output:**
```
Hello, Alice!
```

> ✅ මේ output එක ආවොත් server + client දෙකම හරියට work කරනවා!

---

## 🧪 Step 5: SOAP UI ගා Test කරනවා

> **SOAP UI කියන්නේ මොකක්ද?**
> Server directly test කරන tool එකක් - Client code ලියන්නේ නැතිව directly requests යවන්න පුලුවන්. Postman වගේ!

### 5.1 - New Project හදනවා
1. SOAP UI open කරං
2. Top toolbar ගා **SOAP** button click කරං
3. Fill කරං:
   - **Project Name:** `Hello Project`
   - **Initial WSDL:** `http://localhost:8080/soap_practicals/hello_server.php?wsdl`
4. **OK** click කරං → Left side ගා project load වෙනවා ✅

> WSDL URL = Menu Card URL. SOAP UI ඒකෙන් available methods detect කරනවා!

### 5.2 - Request Open කරනවා
Left side ගා මේ විදිහට expand කරං:
```
Hello Project
    └── HelloServiceBinding
            └── sayHello
                    └── Request 1  ← Double Click!
```

### 5.3 - Request XML Edit කරනවා
Middle ගා XML window එකේ මේ line හොයං:
```xml
<name xsi:type="xsd:string">?</name>
```
`?` remove කරලා `Alice` දෙං:
```xml
<name xsi:type="xsd:string">Alice</name>
```

### 5.4 - Send කරනවා ▶
Top left corner ගා **Green ▶ Play button** click කරං!

### 5.5 - Response Check කරනවා
Right side ගා මේ response එනවා:
```xml
<return xsi:type="xsd:string">Hello, Alice!</return>
```
🎉 **Practical 01 Complete!**

---

## 🔄 How It All Works - Full Flow

```
SOAP UI / Browser ගා request යවනවා
            ↓
hello_server.php ගා handle() ඒක catch කරනවා
            ↓
HelloService class ගා sayHello("Alice") run වෙනවා
            ↓
"Hello, Alice!" return වෙනවා
            ↓
SOAP UI / Browser ගා response පෙනෙනවා ✅
```

| Part | Role | Example |
|------|------|---------|
| `hello_server.php` | Kitchen 🍳 | Order handle කරනවා |
| `hello_client.php` | Customer 🙋 | Order දෙනවා |
| `WSDL` | Menu Card 📋 | Available methods describe කරනවා |
| `sayHello()` | Chef Recipe 👨‍🍳 | Actual work කරනවා |
| `setClass()` | Hire Chef 👔 | Service register කරනවා |

---

## ⚠️ Important Notes

| Issue | Solution |
|-------|----------|
| Apache start නොවෙනවා | Port 80 busy - 8080 use කරං |
| WSDL load නොවෙනවා | XAMPP Apache running ද check කරං |
| URL error එනවා | `soap_practicals` (small s) ✅ `Soap_practicals` ❌ |
| SOAP UI error | Browser ගා WSDL URL check කරං first |

---

*Self Study Practical - SOAP Web Services using PHP & XAMPP* 🧼
