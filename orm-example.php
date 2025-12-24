<?php

require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/config.php';

use App\Models\User;
use App\Models\Course;
use App\Models\SubjectArea;

echo "<h2>ORM Usage Examples</h2>";

try {
    echo "<h3>1. User Model Examples</h3>";
    
    echo "<p><strong>Create a new staff user:</strong></p>";
    $existingUser = User::getUserByUsername('john_staff');
    if (!$existingUser) {
        $result = User::createUser('john_staff', 'securepass123', 'staff');
        echo "Created user with ID: " . $result['id'] . "<br>";
    } else {
        echo "User 'john_staff' already exists<br>";
    }

    echo "<p><strong>Get all users:</strong></p>";
    $allUsers = User::getAll();
    echo "Total users: " . count($allUsers) . "<br>";
    foreach ($allUsers as $user) {
        echo "- " . $user['username'] . " (" . $user['role'] . ")<br>";
    }

    echo "<p><strong>Get user by ID:</strong></p>";
    $user = User::getById(1);
    if ($user) {
        echo "Found: " . $user['username'] . "<br>";
    }

    echo "<p><strong>Authenticate user:</strong></p>";
    $authenticated = User::authenticateUser('superadmin', 'password');
    if ($authenticated) {
        echo "Authentication successful for: " . $authenticated['username'] . "<br>";
    } else {
        echo "Authentication failed<br>";
    }

    echo "<p><strong>Get staff users:</strong></p>";
    $staffUsers = User::getUsersByRole('staff');
    echo "Total staff: " . count($staffUsers) . "<br>";

    echo "<h3>2. SubjectArea Model Examples</h3>";

    echo "<p><strong>Create subject areas:</strong></p>";
    $existingArea = SubjectArea::getSubjectAreaByName('Computer Science');
    if (!$existingArea) {
        $result = SubjectArea::createSubjectArea('Computer Science', 1);
        echo "Created subject area with ID: " . $result['id'] . "<br>";
    } else {
        echo "Subject area 'Computer Science' already exists<br>";
    }

    echo "<p><strong>Get all subject areas:</strong></p>";
    $areas = SubjectArea::getAll();
    echo "Total subject areas: " . count($areas) . "<br>";
    foreach ($areas as $area) {
        echo "- " . $area['name'] . "<br>";
    }

    echo "<hr>";
    echo "<h3>3. Course Model Examples</h3>";

    echo "<p><strong>Create courses:</strong></p>";
    if (count($areas) > 0) {
        $areaId = $areas[0]['id'];
        $result = Course::createCourse(
            'Software Engineering',
            $areaId,
            'BSc',
            3,
            'A comprehensive course on software engineering principles',
            1,
            0
        );
        echo "Created course with ID: " . $result['id'] . "<br>";
    }

    echo "<p><strong>Get all courses:</strong></p>";
    $courses = Course::getAll();
    echo "Total courses: " . count($courses) . "<br>";
    foreach ($courses as $course) {
        echo "- " . $course['title'] . " (" . $course['type'] . ", " . $course['duration_years'] . " years)<br>";
    }

    echo "<p><strong>Get courses by subject area:</strong></p>";
    if (count($areas) > 0) {
        $coursesByArea = Course::getCoursesBySubjectArea($areas[0]['id']);
        echo "Courses in " . $areas[0]['name'] . ": " . count($coursesByArea) . "<br>";
    }

    echo "<p><strong>Get full-time courses:</strong></p>";
    $fullTime = Course::getFullTimeCourses();
    echo "Full-time courses: " . count($fullTime) . "<br>";

    echo "<p><strong>Get 3-year courses:</strong></p>";
    $threeYear = Course::getCoursesByDuration(3);
    echo "3-year courses: " . count($threeYear) . "<br>";

    echo "<hr>";
    echo "<h3>4. Update and Delete Examples</h3>";

    echo "<p><strong>Update a course:</strong></p>";
    if (count($courses) > 0) {
        $courseId = $courses[0]['id'];
        $updated = Course::updateRecord($courseId, [
            'title' => 'Advanced Software Engineering'
        ]);
        echo "Updated " . $updated . " course(s)<br>";
    }

    echo "<p><strong>User count:</strong></p>";
    $userCount = User::count();
    echo "Total users in database: " . $userCount . "<br>";

} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background: #f5f5f5;
    }
    h2, h3 {
        color: #333;
    }
    p {
        background: white;
        padding: 10px;
        margin: 10px 0;
        border-radius: 4px;
    }
    hr {
        margin: 30px 0;
        border: none;
        border-top: 2px solid #ddd;
    }
</style>
