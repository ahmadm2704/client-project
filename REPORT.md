# University of Northampton Website - Assessment Report

## Admin Login Information

- **Login URL:** http://localhost/login
- **Username:** superadmin
- **Password:** password123

---

## NMP-0001: User Accounts

### Acceptance Criteria

| Criteria | File | Line |
|----------|------|------|
| Superadmin can log in and add new accounts | src/Controllers/AuthController.php | 25 |
| New account can log in and add subject areas/courses | src/Controllers/UserController.php | 54 |
| Superadmin can delete accounts | src/Controllers/UserController.php | 66 |
| Superadmin account cannot be deleted | src/Controllers/UserController.php | 78 |
| Non-superadmin cannot add/remove accounts | src/Controllers/UserController.php | 12 |

### Password Security

| Feature | File | Line |
|---------|------|------|
| Password hashing with bcrypt | src/Models/User.php | 42 |
| Password verification | src/Models/User.php | 18 |

---

## NMP-0002: Add/Display Subject Areas

### Acceptance Criteria

| Criteria | File | Line |
|----------|------|------|
| Logged in users can add subject areas | src/Controllers/SubjectAreaController.php | 57 |
| Logged in users can edit subject areas | src/Controllers/SubjectAreaController.php | 75 |
| Logged in users can delete subject areas | src/Controllers/SubjectAreaController.php | 102 |
| Not logged in users cannot add/edit/delete | src/Controllers/SubjectAreaController.php | 16 |
| Subject area appears in menu | src/Helpers/HeaderHelper.php | 10 |
| Clicking subject area shows page with heading | src/Controllers/SubjectAreaController.php | 28 |

---

## NMP-0003: Add/Display Courses

### Acceptance Criteria

| Criteria | File | Line |
|----------|------|------|
| Courses can be added with all required data | src/Controllers/CourseController.php | 73 |
| Courses can be updated | src/Controllers/CourseController.php | 112 |
| Courses can be moved between subject areas | src/Controllers/CourseController.php | 114 |
| Courses visible on subject area page | src/Controllers/SubjectAreaController.php | 48 |
| Modules can be assigned to courses | src/Controllers/CourseController.php | 121 |

---

## NMP-0004: Enquiries

### Acceptance Criteria

| Criteria | File | Line |
|----------|------|------|
| Anyone can submit an enquiry | src/Controllers/EnquiryController.php | 18 |
| Enquiries visible to logged in admins | src/Controllers/EnquiryController.php | 94 |
| Enquiries can be marked as responded | src/Controllers/EnquiryController.php | 165 |
| Shows pending enquiries | src/Controllers/EnquiryController.php | 103 |
| Shows responded enquiries | src/Controllers/EnquiryController.php | 105 |

---

## NMP-0005: Course Search

### Acceptance Criteria

| Criteria | File | Line |
|----------|------|------|
| Search by subject area | src/Models/Course.php | 108 |
| Search by type | src/Models/Course.php | 112 |
| Search by duration | src/Models/Course.php | 116 |
| Search by one, two or all criteria | src/Models/Course.php | 101 |
| Search performed in database | src/Models/Course.php | 130 |

---

## NMP-0006: Part Time Courses

### Acceptance Criteria

| Criteria | File | Line |
|----------|------|------|
| Add part time option when adding/editing course | src/Controllers/CourseController.php | 83 |
| Display part time info on subject area list | src/Views/subject-area-detail.php | 157 |
| Display part time info in search results | src/Views/course-search.php | 316 |
| Search filter for part time courses | src/Models/Course.php | 128 |

---

## NMP-0007: Pagination

### Acceptance Criteria

| Criteria | File | Line |
|----------|------|------|
| Display 10 courses on subject area page | src/Controllers/SubjectAreaController.php | 38 |
| Pagination on subject area page | src/Controllers/SubjectAreaController.php | 42 |
| Pagination on search results | src/Controllers/CourseController.php | 227 |
| Uses LIMIT and OFFSET in database | src/Models/Course.php | 157 |
