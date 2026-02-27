# Practical 02 - Student Management SOAP Service 🎓

> **සිංහල Guide එකක් - දවසක් ගිහිල්ලා ආවාමත් තේරෙන විදිහට!** 🎨

---

## 🎯 Objective (අරමුණ)
Multiple parameters handle කරන SOAP methods ඉගෙනගන්නවා - Student data add, get, delete කරනවා!

 Multiple parameters (`id`, `name`, `age`) + CRUD operations!

---

## ✅ Tasks Completed
- ✅ `addStudent(id, name, age)` method හැදුවා
- ✅ `getStudentDetails(id)` method හැදුවා
- ✅ `deleteStudent(id)` method හැදුවා
- ✅ SOAP UI ගා සියලු methods test කළා
- ✅ Client program හැදුවා

---

## 📁 File Structure
```
practical-02-student-management/
├── student_service.php  → SOAP Server (Student data manage කරනවා)
├── student_client.php   → SOAP Client (Methods test කරනවා)
└── README.md            → මේ file එක
```

---

## 📋 Available Methods

| Method | Parameters | Returns |
|--------|-----------|---------|
| `addStudent` | `id` (int), `name` (string), `age` (int) | Success/Error message |
| `getStudentDetails` | `id` (int) | Student info string |
| `deleteStudent` | `id` (int) | Success/Error message |

---

## 🛠️ Step 1: XAMPP Start කරනවා
1. XAMPP Control Panel open කරං
2. Apache → **Start** click කරං ✅

---

## 🖥️ Step 2: Server File Copy කරනවා

`student_service.php` මේ folder ගා copy කරං:
```
C:\xampp\htdocs\soap_practicals\
```

### Code Explain කරනවා:

**Default students (pre-loaded data):**
```php
private static $students = [
    1 => ['id' => 1, 'name' => 'Alice',   'age' => 20],
    2 => ['id' => 2, 'name' => 'Bob',     'age' => 22],
    3 => ['id' => 3, 'name' => 'Charlie', 'age' => 21],
];
```
> Server start වෙද්දී Alice, Bob, Charlie already ඇතුලේ ඉන්නවා!

**addStudent method:**
```php
public function addStudent($id, $name, $age) {
    if(isset(self::$students[$id])) {
        return "Error: Student ID $id already exists!";
    }
    self::$students[$id] = ['id'=>$id, 'name'=>$name, 'age'=>$age];
    return "Student added successfully!...";
}
```
> ID already exist නම් error දෙනවා - duplicate prevent කරනවා!

**getStudentDetails method:**
```php
public function getStudentDetails($id) {
    if(!isset(self::$students[$id])) {
        return "Error: Student ID $id not found!";
    }
    $s = self::$students[$id];
    return "ID: {$s['id']} | Name: {$s['name']} | Age: {$s['age']}";
}
```

**deleteStudent method:**
```php
public function deleteStudent($id) {
    if(!isset(self::$students[$id])) {
        return "Error: Student ID $id not found!";
    }
    unset(self::$students[$id]);
    return "Student deleted successfully!";
}
```

---

## 📱 Step 3: Client File Copy කරනවා

`student_client.php` same folder ගා copy කරං.

---

## 🌐 Step 4: Browser ගා Test කරනවා

Browser ගා:
```
http://localhost:8080/soap_practicals/student_client.php
```

**Expected Output:**
```
1. getStudentDetails(1)
ID: 1 | Name: Alice | Age: 20

2. getStudentDetails(2)
ID: 2 | Name: Bob | Age: 22

3. addStudent(4, 'David', 23)
Student added successfully! ID: 4, Name: David, Age: 23

4. getStudentDetails(4) - newly added
ID: 4 | Name: David | Age: 23

5. deleteStudent(2)
Student 'Bob' (ID: 2) deleted successfully!

6. getStudentDetails(2) - after delete
Error: Student ID 2 not found!

7. getStudentDetails(99) - not found
Error: Student ID 99 not found!
```

---

## 🧪 Step 5: SOAP UI ගා Test කරනවා

### 5.1 - New Project හදනවා
1. SOAP UI → **SOAP** button click කරං
2. Fill කරං:
   - **Project Name:** `Student Project`
   - **Initial WSDL:** `http://localhost:8080/soap_practicals/student_service.php?wsdl`
3. **OK** click කරං ✅

### 5.2 - addStudent Test කරනවා
Left side ගා expand කරං:
```
Student Project
    └── StudentServiceBinding
            └── addStudent
                    └── Request 1  ← Double Click!
```
XML ගා fill කරං:
```xml
<id xsi:type="xsd:int">4</id>
<name xsi:type="xsd:string">David</name>
<age xsi:type="xsd:int">23</age>
```
**▶ Click** → Response:
```xml
<return>Student added successfully! ID: 4, Name: David, Age: 23</return>
```

### 5.3 - getStudentDetails Test කරනවා
```
└── getStudentDetails → Request 1
```
XML ගා fill කරං:
```xml
<id xsi:type="xsd:int">1</id>
```
**▶ Click** → Response:
```xml
<return>ID: 1 | Name: Alice | Age: 20</return>
```

### 5.4 - deleteStudent Test කරනවා
```
└── deleteStudent → Request 1
```
XML ගා fill කරං:
```xml
<id xsi:type="xsd:int">2</id>
```
**▶ Click** → Response:
```xml
<return>Student 'Bob' (ID: 2) deleted successfully!</return>
```

---

## 🔄 How It All Works

```
SOAP UI / Client ගා request යවනවා
            ↓
student_service.php handle() catch කරනවා
            ↓
StudentService class ගා method run වෙනවා
(addStudent / getStudentDetails / deleteStudent)
            ↓
$students array ගා data add/get/delete වෙනවා
            ↓
Response return වෙනවා ✅
```

> ⚠️ **Important:** `$students` array එක memory ගා store වෙනවා!
> Request end වෙද්දී data reset වෙනවා.
> Real project ගා MySQL database use කරනවා!

---

## ⚠️ Important Notes

| Issue | Solution |
|-------|----------|
| WSDL load නොවෙනවා | XAMPP Apache running ද check කරං |
| Data reset වෙනවා | Normal - memory storage use කරනවා |
| Duplicate ID error | Different ID එකක් use කරං |
| Not found error | Valid ID (1,2,3) use කරං |

---

*Self Study Practical 02 - SOAP Web Services using PHP & XAMPP* 🧼
