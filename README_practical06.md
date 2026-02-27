# Practical 06 - SOAP Security 🔐

> **සිංහල Guide එකක් - දවසක් ගිහිල්ලා ආවාමත් තේරෙන විදිහට!** 🎨

---

## 🎯 Objective (අරමුණ)
SOAP services ගා **Basic Authentication** add කරන ඉගෙනගන්නවා - valid credentials නැතිව access block කරනවා!

> **New Concept - Authentication:**
> Art gallery ගා security guard කෙනෙක් ඉන්නවා - VIP pass
> නැතිව ඇතුලට ගන්නේ නෑ! SOAP security ඒ වගේ!
> - **Public methods** = Free entry area (everyone can access)
> - **Secure methods** = VIP area (credentials check කරනවා)
> - **Wrong credentials** = SoapFault throw කරනවා! 🔐

---

## ✅ Tasks Completed
- ✅ Basic Authentication server side add කළා
- ✅ `getPublicMessage()` - no auth needed method හැදුවා
- ✅ `getSecretMessage(username, password)` - auth required method හැදුවා
- ✅ `getUserInfo(username, password)` - auth required method හැදුවා
- ✅ Wrong credentials ගා SoapFault throw කළා
- ✅ SOAP UI ගා valid/invalid credentials test කළා
- ✅ Client program හැදුවා

---

## 📁 File Structure
```
practical-06-soap-security/
├── secure_service.php  → SOAP Server with Authentication
├── secure_client.php   → SOAP Client with credential tests
└── README.md           → මේ file එක
```

---

## 🔑 Valid Credentials

| Username | Password | Role |
|----------|----------|------|
| `admin` | `password123` | Administrator |

---

## 📋 Available Methods

| Method | Auth Required | Description |
|--------|--------------|-------------|
| `getPublicMessage()` | ❌ No | Public message return කරනවා |
| `getSecretMessage(username, password)` | ✅ Yes | Secret message return කරනවා |
| `getUserInfo(username, password)` | ✅ Yes | User info return කරනවා |

---

## 🛠️ Step 1: XAMPP Start කරනවා
1. XAMPP Control Panel open කරං
2. Apache → **Start** click කරං ✅

---

## 🖥️ Step 2: Server File Copy කරනවා

`secure_service.php` මේ folder ගා copy කරං:
```
C:\xampp\htdocs\soap_practicals\
```

### Code Explain කරනවා:

**Auth Check Function:**
```php
$validUsername = "admin";
$validPassword = "password123";

function checkAuth($username, $password) {
    global $validUsername, $validPassword;
    if($username === $validUsername && $password === $validPassword) {
        return true;
    }
    return false;
}
```
> Username + password validate කරනවා - match වෙනවා නම් true!

**Public Method (No Auth):**
```php
public function getPublicMessage() {
    return "✅ This is a PUBLIC message!";
}
```
> Credentials check නෑ - everyone access කරන්න පුලුවන්!

**Secure Method (Auth Required):**
```php
public function getSecretMessage($username, $password) {
    if(!checkAuth($username, $password)) {
        throw new SoapFault("Client",
            "❌ Unauthorized! Invalid username or password.");
    }
    return "🔐 SECRET MESSAGE: Welcome " . $username . "!";
}
```
> Wrong credentials → `SoapFault` throw! ✅

---

## 📱 Step 3: Client File Copy කරනවා

`secure_client.php` same folder ගා copy කරං.

---

## 🌐 Step 4: Browser ගා Test කරනවා

Browser ගා:
```
http://localhost:8080/soap_practicals/secure_client.php
```

**Expected Output:**
```
1. getPublicMessage() - No Auth
✅ This is a PUBLIC message - anyone can see this!

2. getSecretMessage() - Correct Credentials ✅
🔐 SECRET MESSAGE: Welcome admin! Auth successful at: 2026-02-27 10:00:00

3. getSecretMessage() - Wrong Password ❌
❌ Unauthorized! Invalid username or password.

4. getSecretMessage() - Wrong Username ❌
❌ Unauthorized! Invalid username or password.

5. getUserInfo() - Correct Credentials ✅
👤 User Info | Username: admin | Role: Administrator | Access Level: Full

6. getUserInfo() - Empty Credentials ❌
❌ Unauthorized! Invalid username or password.
```

---

## 🧪 Step 5: SOAP UI ගා Test කරනවා

### 5.1 - New Project හදනවා
1. SOAP UI → **SOAP** button click කරං
2. Fill කරං:
   - **Project Name:** `Security Project`
   - **Initial WSDL:** `http://localhost:8080/soap_practicals/secure_service.php?wsdl`
3. **OK** click කරං ✅

### 5.2 - Public Method Test (No Auth)
```
SecureServiceBinding → getPublicMessage → Request 1
```
XML ගා parameters නෑ - directly **▶ Click**

Response:
```xml
<return>✅ This is a PUBLIC message!</return>
```

### 5.3 - Secret Method - Correct Credentials ✅
```
SecureServiceBinding → getSecretMessage → Request 1
```
XML ගා fill කරං:
```xml
<username xsi:type="xsd:string">admin</username>
<password xsi:type="xsd:string">password123</password>
```
**▶ Click** → Response:
```xml
<return>🔐 SECRET MESSAGE: Welcome admin!</return>
```

### 5.4 - Secret Method - Wrong Password ❌
```xml
<username xsi:type="xsd:string">admin</username>
<password xsi:type="xsd:string">wrongpass</password>
```
**▶ Click** → SoapFault Response:
```xml
<faultcode>Client</faultcode>
<faultstring>❌ Unauthorized! Invalid username or password.</faultstring>
```

---

## 🔄 How It All Works

```
Client request යවනවා (username + password සමග)
            ↓
secure_service.php handle() catch කරනවා
            ↓
checkAuth() function credentials validate කරනවා
            ↓
Valid credentials    → Secret data return කරනවා ✅
Invalid credentials  → SoapFault throw කරනවා ❌
            ↓
Client try-catch ගා SoapFault catch කරනවා
```

---

## 💡 Security Flow Diagram

```
🙋 Client
    │
    ├── getPublicMessage()
    │       └── ✅ No auth → Direct response
    │
    └── getSecretMessage("admin", "password123")
            │
            ├── ✅ Valid → Secret data
            └── ❌ Invalid → SoapFault "Unauthorized"
```

---

## 💡 Practical 3 vs Practical 6 SoapFault Comparison

| | Practical 3 | Practical 6 |
|--|-------------|-------------|
| SoapFault Reason | Division by zero | Wrong credentials |
| Fault Code | `"Server"` | `"Client"` |
| Who's fault? | Server side error | Client sent wrong data |

> **`"Server"` vs `"Client"` fault code:**
> - `"Server"` = Server side ගා problem (divide by zero)
> - `"Client"` = Client wrong data දුන්නා (wrong credentials)

---

## ⚠️ Important Notes

| Issue | Solution |
|-------|----------|
| WSDL load නොවෙනවා | XAMPP Apache running ද check කරං |
| Always unauthorized | Username: `admin` Password: `password123` use කරං |
| Real world security | Real apps ගා database + hashed passwords use කරනවා |

---

*Self Study Practical 06 - SOAP Web Services using PHP & XAMPP* 🧼
