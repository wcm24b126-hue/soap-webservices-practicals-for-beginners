# UDDI Practical - Local UDDI Registry with MySQL 📒

> **සිංහල Guide එකක් - දවසක් ගිහිල්ලා ආවාමත් තේරෙන විදිහට!** 🎨

---

## 🎯 Objective
MySQL database use කරලා local UDDI registry එකක් හදනවා - SOAP services register, search, discover කරනවා!

> **UDDI = Yellow Pages Directory**
> SOAP services advertise + discover කරන registry එකක්!
> - Business register කරනවා
> - Services register කරනවා
> - Others search කරලා find කරනවා
> - Found endpoint use කරලා call කරනවා!

---

## 📁 File Structure
```
uddi-practical/
├── register_business.php  → Q2: Business register කරනවා
├── register_service.php   → Q3: Service register කරනවා
├── add_binding.php        → Q4: Binding template update
├── search_service.php     → Q6: Services search කරනවා
├── update_endpoint.php    → Q7: Endpoint update කරනවා
├── delete_service.php     → Q8: Service delete කරනවා
├── discover_and_call.php  → Q9: Dynamic discovery + call ⭐
├── list_all_services.php  → Q10: All services list
└── README.md              → මේ file
```

---

## 🛠️ Step 0: Prerequisites

### XAMPP Start කරනවා:
1. XAMPP Control Panel open කරං
2. **Apache** → Start ✅
3. **MySQL** → Start ✅

### Database හදනවා:
`http://localhost:8080/phpmyadmin` open කරං

SQL tab ගා මේ run කරං:
```sql
CREATE DATABASE uddi_registry;

USE uddi_registry;

CREATE TABLE services (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    business_name VARCHAR(100),
    service_name  VARCHAR(100),
    endpoint      VARCHAR(255),
    tmodel        VARCHAR(100)
);
```

---

## 📋 Test Order - Files Run කරන Order

| Order | File | URL | Expected Output |
|-------|------|-----|----------------|
| 1 | `register_business.php` | `/register_business.php` | ✅ Business Registered! |
| 2 | `register_service.php` | `/register_service.php` | ✅ Service Registered! |
| 3 | `add_binding.php` | `/add_binding.php` | ✅ Binding Updated! |
| 4 | `search_service.php` | `/search_service.php` | ✅ Service list |
| 5 | `discover_and_call.php` | `/discover_and_call.php` | ✅ Hello, Alice! |
| 6 | `list_all_services.php` | `/list_all_services.php` | ✅ Services table |
| 7 | `update_endpoint.php` | `/update_endpoint.php` | ✅ Endpoint updated |
| 8 | `delete_service.php` | `/delete_service.php` | ✅ Service deleted |

> ⚠️ delete_service.php **last** run කරං - delete කළාට පස්සේ discover_and_call.php work නොකරනවා!

---

## 🔑 Key File - discover_and_call.php ⭐

```php
// Step 1: UDDI ගා endpoint find කරනවා
$result = $conn->query(
    "SELECT endpoint FROM services WHERE service_name='HelloWorldService'"
);
$endpoint = $row['endpoint'];

// Step 2: Found endpoint use කරලා SOAP call!
$client = new SoapClient(null, [
    'location' => $endpoint,
    'uri'      => $endpoint
]);
echo $client->sayHello("Alice"); // Hello, Alice!
```

> **This is UDDI ගේ whole point!**
> Endpoint hardcode නොකරනවා - dynamically UDDI ගා find කරනවා!

---

## 🔄 Full UDDI Flow

```
1. hello_server.php හදනවා (Practical 01)
            ↓
2. UDDI Registry ගා register කරනවා
   (register_business + register_service)
            ↓
3. Client UDDI ගා search කරනවා
   (search_service.php)
            ↓
4. Endpoint found!
   http://localhost:8080/.../hello_server.php
            ↓
5. That endpoint use කරලා SOAP call!
   sayHello("Alice") → "Hello, Alice!" ✅
```

---

## 💡 bindingTemplate vs businessService

| Concept | කියන්නේ | Example |
|---------|---------|---------|
| **businessService** | Service description | HelloWorldService |
| **bindingTemplate** | Access point (URL) | http://localhost:8080/... |

> businessService = "Pizza shop" 🍕
> bindingTemplate = "Pizza shop address" 📍

---

## 🔗 UDDI + SOAP Practicals Connection

```
Practical 01 hello_server.php  ← UDDI ගා registered!
Practical 02 student_service   ← UDDI ගා register කරන්න පුලුවන්
Practical 03 calculator        ← UDDI ගා register කරන්න පුලුවන්
Practical 04 employee_service  ← UDDI ගා register කරන්න පුලුවන්
        ↑
   UDDI Registry (MySQL)
        ↓
   Any client → search → find endpoint → call!
```

---

## ⚠️ Important Notes

| Issue | Solution |
|-------|----------|
| DB connection failed | MySQL running ද check කරං |
| Already registered | Duplicate check built-in ✅ |
| discover fails | register_service.php先 run කරං |
| hello_server missing | Practical 01 files copy කරං |

---

*UDDI Self Study Practical - Web Technology and Applications* 🧼
