<?php

require_once __DIR__ . '/../autoload.php';
require_once __DIR__ . '/../config.php';

use App\Helpers\Auth;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\SubjectAreaController;
use App\Controllers\CourseController;
use App\Controllers\ModuleController;
use App\Controllers\EnquiryController;

Auth::startSession();

$request = isset($_GET['url']) ? $_GET['url'] : '';
$request = parse_url($request, PHP_URL_PATH);
$request = trim($request, '/');

if (empty($request)) {
    require __DIR__ . '/../src/Views/home.php';
} elseif ($request === 'login') {
    $controller = new AuthController();
    $controller->loginPage();
} elseif ($request === 'logout') {
    $controller = new AuthController();
    $controller->logout();
} elseif ($request === 'users') {
    $controller = new UserController();
    $controller->listUsers();
} elseif ($request === 'users/create') {
    $controller = new UserController();
    $controller->createUser();
} elseif (strpos($request, 'users/delete') === 0) {
    $controller = new UserController();
    $controller->deleteUser();
} elseif ($request === 'admin') {
    Auth::requireLogin();
    require __DIR__ . '/../src/Views/admin.php';
} elseif ($request === 'subject-areas') {
    $controller = new SubjectAreaController();
    $controller->listSubjectAreas();
} elseif (strpos($request, 'subject-areas/save') === 0) {
    $controller = new SubjectAreaController();
    $controller->saveSubjectArea();
} elseif (strpos($request, 'subject-areas/delete') === 0) {
    $parts = explode('/', $request);
    $id = isset($parts[2]) ? $parts[2] : null;
    $controller = new SubjectAreaController();
    $controller->deleteSubjectArea($id);
} elseif (strpos($request, 'subject-area/') === 0) {
    $parts = explode('/', $request);
    $id = isset($parts[1]) ? $parts[1] : null;
    $controller = new SubjectAreaController();
    $controller->showSubjectArea($id);
} elseif ($request === 'course-search') {
    $controller = new CourseController();
    $controller->showSearchPage();
} elseif ($request === 'courses') {
    $controller = new CourseController();
    $controller->listCourses();
} elseif (strpos($request, 'courses/save') === 0) {
    $controller = new CourseController();
    $controller->saveCourse();
} elseif (strpos($request, 'courses/delete') === 0) {
    $parts = explode('/', $request);
    $id = isset($parts[2]) ? $parts[2] : null;
    $controller = new CourseController();
    $controller->deleteCourse($id);
} elseif (strpos($request, 'course/') === 0) {
    $parts = explode('/', $request);
    $id = isset($parts[1]) ? $parts[1] : null;
    $controller = new CourseController();
    $controller->showCourse($id);
} elseif ($request === 'modules') {
    $controller = new ModuleController();
    $controller->listModules();
} elseif (strpos($request, 'modules/save') === 0) {
    $controller = new ModuleController();
    $controller->saveModule();
} elseif (strpos($request, 'modules/delete') === 0) {
    $parts = explode('/', $request);
    $id = isset($parts[2]) ? $parts[2] : null;
    $controller = new ModuleController();
    $controller->deleteModule($id);
} elseif ($request === 'enquiry') {
    $controller = new EnquiryController();
    $controller->showForm();
} elseif ($request === 'enquiry/save') {
    $controller = new EnquiryController();
    $controller->saveEnquiry();
} elseif ($request === 'enquiries') {
    header('Location: /admin/enquiries');
    exit;
} elseif ($request === 'admin/enquiries') {
    $controller = new EnquiryController();
    $controller->listEnquiries();
} elseif (strpos($request, 'admin/enquiries/') === 0) {
    $parts = explode('/', $request);
    $id = isset($parts[2]) ? $parts[2] : null;
    $controller = new EnquiryController();
    $controller->showEnquiry($id);
} elseif (strpos($request, 'enquiry/respond/') === 0) {
    $parts = explode('/', $request);
    $id = isset($parts[2]) ? $parts[2] : null;
    $controller = new EnquiryController();
    $controller->markResponded($id);
} elseif (strpos($request, 'enquiry/delete/') === 0) {
    $parts = explode('/', $request);
    $id = isset($parts[2]) ? $parts[2] : null;
    $controller = new EnquiryController();
    $controller->deleteEnquiry($id);
} elseif ($request === 'add-sample-courses') {
    try {
        $courses = [
            ['Computing', 'BSc Computer Science', 'BSc', 3, 'Learn the fundamentals of computer science including algorithms, data structures, and software engineering principles.', 1, 1],
            ['Computing', 'MSc Advanced Computing', 'MSc', 2, 'Advanced computing course covering machine learning, cloud computing, and distributed systems.', 1, 1],
            ['Computing', 'BSc Software Engineering', 'BSc', 3, 'Focus on software development methodologies, project management, and real-world application development.', 0, 1],
            ['Computing', 'MA Web Development', 'MA', 2, 'Master modern web technologies including React, Node.js, and full-stack development practices.', 1, 1],
            ['Computing', 'BSc Information Technology', 'BSc', 3, 'Comprehensive IT course covering networking, databases, security, and IT infrastructure.', 1, 1],
            ['Computing', 'MSc Data Science', 'MSc', 2, 'Deep dive into data science, machine learning, and big data analytics.', 0, 1],
            ['Computing', 'BSc Cybersecurity', 'BSc', 3, 'Learn cybersecurity principles, ethical hacking, and information security management.', 1, 1],
            ['Computing', 'Diploma IT Support', 'Diploma', 2, 'Practical IT support and helpdesk fundamentals for career starters.', 1, 1],
            ['Computing', 'BSc Game Development', 'BSc', 3, 'Create games using modern game engines and learn game design principles.', 0, 1],
            ['Computing', 'MSc AI Engineering', 'MSc', 2, 'Advanced artificial intelligence and machine learning engineering.', 1, 1],
            ['Computing', 'BSc Mobile App Development', 'BSc', 3, 'Develop mobile applications for iOS and Android platforms.', 1, 1],
            ['Computing', 'Certificate Cloud Computing', 'Certificate', 1, 'Introduction to AWS, Azure, and Google Cloud platforms.', 1, 1],
            ['Computing', 'BSc Networking', 'BSc', 3, 'Computer networks, routing, switching, and network administration.', 0, 1],
            ['Computing', 'MA IT Management', 'MA', 2, 'IT strategy, project management, and enterprise IT systems.', 1, 1],
            ['Computing', 'BSc Database Systems', 'BSc', 3, 'Database design, SQL, and advanced database management systems.', 1, 1],
        ];

        $inserted = 0;

        foreach ($courses as $course) {
            list($subjectName, $title, $type, $duration, $description, $partTime, $userId) = $course;
            $stmt = \App\Models\Database::query('SELECT id FROM subject_areas WHERE name = ?', [$subjectName]);
            $subject = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($subject) {
                $sql = 'INSERT INTO courses (title, subject_area_id, type, duration_years, description, part_time_available, created_by, created_at) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, NOW())';
                \App\Models\Database::execute($sql, [
                    $title,
                    $subject['id'],
                    $type,
                    $duration,
                    $description,
                    $partTime,
                    $userId
                ]);
                $inserted++;
            }
        }

        echo "<h1>Sample Courses Added Successfully!</h1>";
        echo "<p>Inserted $inserted sample courses for pagination testing.</p>";
        echo "<p><a href='/subject-area/1'>View Computing Courses with Pagination →</a></p>";
    } catch (Exception $e) {
        http_response_code(500);
        echo "<h1>Error</h1>";
        echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    }
} elseif ($request === 'subject-area') {
    require __DIR__ . '/../src/Views/subject-area.php';
} else {
    http_response_code(404);
    require __DIR__ . '/../src/Views/404.php';
}
