# Practical 04 - Employee Management SOAP Service 👔

> **සිංහල Guide එකක් - දවසක් ගිහිල්ලා ආවාමත් තේරෙන විදිහට!** 🎨

---

## 🎯 Objective (අරමුණ)
SOAP service ගා **Objects** handle කරන ඉගෙනගන්නවා - Employee object එකක් create කරලා add, get, update, delete කරනවා!

> **Practical 3 vs Practical 4 වෙනස:**
> - Practical 3 = Simple int parameters (a, b)
> - Practical 4 = **Object-based** parameters (id, name, position, salary) - real world වලට ළඟ!
>
> **New concept - Object/Class:**
> Employee කෙනෙකුගේ සියලු details (id, name, position, salary) එකම object එකක bundle කරනවා!
> Real HR system වගේ 🏢

---

## ✅ Tasks Completed
- ✅ `Employee` class හැදුවා (id, name, position, salary)
- ✅ `addEmployee(id, name, position, salary)` method හැදුවා
- ✅ `getEmployee(id)` method හැදුවා
- ✅ `updateEmployee(id, name, position, salary)` method හැදුවා
- ✅ `deleteEmployee(id)` method හැදුවා
- ✅ SOAP UI ගා සියලු methods test කළා
- ✅ Client program හැදුවා

---

## 📁 File Structure
```
practical-04-employee-management/
├── employee_service.php  → SOAP Server (Employee data manage කරනවා)
├── employee_client.php   → SOAP Client (Methods test කරනවා)
└── README.md             → මේ file එක
```

---

## 📋 Available Methods

| Method | Parameters | Returns |
|--------|-----------|---------|
| `addEmployee` | `id`, `name`, `position`, `salary` | Success/Error message |
| `getEmployee` | `id` | Employee details string |
| `updateEmployee` | `id`, `name`, `position`, `salary` | Success/Error message |
| `deleteEmployee` | `id` | Success/Error message |

---

## 👔 Employee Object Structure

```php
class Employee {
    public $id;        // int   - Unique ID
    public $name;      // string - Full name
    public $position;  // string - Job title
    public $salary;    // float  - Monthly salary
}
```

> **Object කියන්නේ මොකක්ද?**
> Real world entity එකක blueprint - Employee කෙනෙකුගේ
> සියලු details එකම package ගා bundle කරනවා!
> Portfolio submit කරනවා වගේ - single values නෙමෙයි whole package! 🎨

---

## 🛠️ Step 1: XAMPP Start කරනවා
1. XAMPP Control Panel open කරං
2. Apache → **Start** click කරං ✅

---

## 🖥️ Step 2: Server File Copy කරනවා

`employee_service.php` මේ folder ගා copy කරං:
```
C:\xampp\htdocs\soap_practicals\
```

### Code Explain කරනවා:

**Employee Class (Blueprint):**
```php
class Employee {
    public $id;
    public $name;
    public $position;
    public $salary;

    public function __construct($id, $name, $position, $salary) {
        $this->id       = $id;
        $this->name     = $name;
        $this->position = $position;
        $this->salary   = $salary;
    }
}
```
> `__construct` = Object create වෙද්දී automatically run වෙන method!

**Pre-loaded sample data:**
```php
private static $employees = [];

public static function init() {
    self::$employees[1] = new Employee(1, "Alice",   "Manager",   5000.00);
    self::$employees[2] = new Employee(2, "Bob",     "Developer", 4000.00);
    self::$employees[3] = new Employee(3, "Charlie", "Designer",  3500.00);
}
```

**addEmployee method:**
```php
public function addEmployee($id, $name, $position, $salary) {
    if(isset(self::$employees[$id])) {
        return "Error: Employee ID $id already exists!";
    }
    self::$employees[$id] = new Employee($id, $name, $position, $salary);
    return "Employee added! " . self::$employees[$id]->toString();
}
```

**updateEmployee method (New in Practical 4!):**
```php
public function updateEmployee($id, $name, $position, $salary) {
    if(!isset(self::$employees[$id])) {
        return "Error: Employee ID $id not found!";
    }
    self::$employees[$id] = new Employee($id, $name, $position, $salary);
    return "Employee updated! " . self::$employees[$id]->toString();
}
```
> Update = Existing employee ගේ details replace කරනවා!

---

## 📱 Step 3: Client File Copy කරනවා

`employee_client.php` same folder ගා copy කරං.

---

## 🌐 Step 4: Browser ගා Test කරනවා

Browser ගා:
```
http://localhost:8080/soap_practicals/employee_client.php
```

**Expected Output:**
```
1. getEmployee(1) - Get Alice
ID: 1 | Name: Alice | Position: Manager | Salary: $5000

2. getEmployee(2) - Get Bob
ID: 2 | Name: Bob | Position: Developer | Salary: $4000

3. addEmployee(4, 'Diana', 'Tester', 3800)
Employee added! ID: 4 | Name: Diana | Position: Tester | Salary: $3800

4. getEmployee(4) - Get Diana
ID: 4 | Name: Diana | Position: Tester | Salary: $3800

5. updateEmployee(2, 'Bob', 'Senior Developer', 5500)
Employee updated! ID: 2 | Name: Bob | Position: Senior Developer | Salary: $5500

6. getEmployee(2) - After update
ID: 2 | Name: Bob | Position: Senior Developer | Salary: $5500

7. deleteEmployee(3) - Delete Charlie
Employee 'Charlie' (ID: 3) deleted successfully!

8. getEmployee(3) - After delete
Error: Employee ID 3 not found!

9. getEmployee(99) - Not found
Error: Employee ID 99 not found!

10. addEmployee(1, ...) - Duplicate ID
Error: Employee ID 1 already exists!
```

---

## 🧪 Step 5: SOAP UI ගා Test කරනවා

### 5.1 - New Project හදනවා
1. SOAP UI → **SOAP** button click කරං
2. Fill කරං:
   - **Project Name:** `Employee Project`
   - **Initial WSDL:** `http://localhost:8080/soap_practicals/employee_service.php?wsdl`
3. **OK** click කරං ✅

### 5.2 - addEmployee Test කරනවා
```
EmployeeServiceBinding → addEmployee → Request 1
```
XML ගා fill කරං:
```xml
<id xsi:type="xsd:int">4</id>
<name xsi:type="xsd:string">Diana</name>
<position xsi:type="xsd:string">Tester</position>
<salary xsi:type="xsd:float">3800</salary>
```
**▶ Click** → Response:
```xml
<return>Employee added! ID: 4 | Name: Diana | Position: Tester | Salary: $3800</return>
```

### 5.3 - getEmployee Test කරනවා
```xml
<id xsi:type="xsd:int">1</id>
```
**▶ Click** → Response:
```xml
<return>ID: 1 | Name: Alice | Position: Manager | Salary: $5000</return>
```

### 5.4 - updateEmployee Test කරනවා
```xml
<id xsi:type="xsd:int">2</id>
<name xsi:type="xsd:string">Bob</name>
<position xsi:type="xsd:string">Senior Developer</position>
<salary xsi:type="xsd:float">5500</salary>
```
**▶ Click** → Response:
```xml
<return>Employee updated! ID: 2 | Name: Bob | Position: Senior Developer | Salary: $5500</return>
```

### 5.5 - deleteEmployee Test කරනවා
```xml
<id xsi:type="xsd:int">3</id>
```
**▶ Click** → Response:
```xml
<return>Employee 'Charlie' (ID: 3) deleted successfully!</return>
```

---

## 🔄 How It All Works

```
SOAP UI / Client ගා request යවනවා
            ↓
employee_service.php handle() catch කරනවා
            ↓
EmployeeService class ගා method run වෙනවා
            ↓
Employee object create/get/update/delete වෙනවා
            ↓
Response string return වෙනවා ✅
```

---

## 💡 Practical 1 to 4 - Evolution එක

| Practical | Concept | Parameters |
|-----------|---------|-----------|
| Practical 01 | Basic SOAP | `name` (string) |
| Practical 02 | Multiple params | `id, name, age` |
| Practical 03 | SoapFault | `a, b` (int) |
| Practical 04 | Object-based | `id, name, position, salary` |

> **Practical 4 ගා key takeaway:**
> Real world ගා employee systems, HR software, CRM systems
> සියල්ලම මේ වගේ object-based SOAP services use කරනවා! 🏢

---

## ⚠️ Important Notes

| Issue | Solution |
|-------|----------|
| WSDL load නොවෙනවා | XAMPP Apache running ද check කරං |
| Data reset වෙනවා | Normal - memory storage use කරනවා |
| Duplicate ID error | Different ID use කරං |
| Not found error | Valid ID (1,2,3) use කරං |

---

*Self Study Practical 04 - SOAP Web Services using PHP & XAMPP* 🧼
